<?php
session_start();
require 'vendor/autoload.php';

class PartnerController
{
    private $userModel, $requestMethod, $role, $options, $pusher, $appointmentModel, $partnerModel, $inquiryModel, $contentModel, $confidentialDocumentsModel, $linkageModel, $institutionalMembershipModel, $OJTPartnerModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($_SESSION['user_role'])) {
            $this->role = $_SESSION['user_role'];
        }

        $this->appointmentModel = new AppointmentModel();
        $this->partnerModel = new PartnerModel();
        $this->inquiryModel = new InquiryModel();
        $this->contentModel = new ContentModel();
        $this->linkageModel = new LinkageModel();
        $this->institutionalMembershipModel = new InstitutionalMembershipModel();
        $this->OJTPartnerModel = new OJTPartnerModel();
        $this->confidentialDocumentsModel = new ConfidentialDocumentsModel();

        /* Pusher */
        $this->options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $this->pusher = new Pusher\Pusher(
            'faac39db04715651483d',
            '91031d6b1e44055bac06',
            '1797895',
            $this->options
        );
    }

    public function index()
    {
        loadView('head');
        loadView('partner/index');
    }

    public function dashboard()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        $events = $this->contentModel->getDashboardEvents();
        $news = $this->contentModel->getDashboardNews();

        $data = ["events" => $events, "news" => $news];

        loadView('head');
        loadView('partner/dashboard', $data);
    }

    public function profile()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('partner/profile');
    }

    public function inquiry()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if($this->requestMethod == "POST") {
            $create = $this->inquiryModel->createInquiry($_SESSION['user_id'], $_POST['inquiry_subject'], $_POST['inquiry_message']);
            if($create > 0) {
                $this->pusher->trigger('inquiry', 'update', ["success" => "true"]);
                echo(json_encode(['success' => "true", "message" => 'Inquiry sent successfully']));
            } else {
                echo(json_encode(['success' => "false", "message" => 'Error sending inquiry']));
            }
            return $create;
        }
    }

    public function updateProfile()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        
        if ($this->requestMethod == "POST") {
            header("Content-Type: application/json");
            $check = $this->userModel->checkDuplicate($_POST['user_email']);
            if($check['num_rows'] == 0 || $_POST['user_email'] == $_SESSION['user_email']) {
                if(isset($_FILES['partner_photo']) && $_FILES['partner_photo']['error'] != 4) {
                    $file = $_FILES['partner_photo'];
    
                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        echo(json_encode(['success' => "false", "message" => 'File upload error: ' . $file['error']]));
                        return false;
                    }
    
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $file['tmp_name']);
                    if (strpos($mime, 'image') === false) {
                        echo(json_encode(["success" => "false", "message" => "Only images are allowed"]));
                        return false;
                    }
                    finfo_close($finfo);
    
                    $maxSize = 5 * 1024 * 1024;
                    if ($file['size'] > $maxSize) {
                        echo(json_encode(["success" => "false", "message" => "The file is too large"]));
                        return false;
                    }
    
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $ext;
    
                    $filename = str_replace(["../", "./"], "", $filename);
    
                    $uploadDir = 'uploads/partners/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
    
                    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                        echo(json_encode(["success" => "false", "message" => "Failed to move uploaded file"]));
                        return false;
                    }
    
                    if (!@getimagesize($uploadDir . $filename)) {
                        unlink($uploadDir . $filename);
                        echo(json_encode(["success" => "false", "message" => "The file is not a valid image"]));
                        return false;
                    }
    
                    $_POST['partner_photo'] = $uploadDir . $filename;
                    $this->partnerModel->updateProfile($_POST);
                    $this->userModel->updateEmail($_POST['user_email'], $_SESSION['user_id']);
                    $getInfo = $this->partnerModel->getByUserID($_SESSION['user_id']);
                    foreach ($getInfo as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
                    
                    $this->pusher->trigger('myProfile-' . $_SESSION['user_id'], 'update', [
                        "success" => "partner",
                        "partner_name" => substr($_SESSION['partner_name'], 0, 19) . "<br>". substr($_SESSION['partner_name'], 19),
                        "user_email" => substr($_SESSION['user_email'], 0, 30) . "<br>" . substr($_SESSION['user_email'], 30),
                        "partner_name_plain" => $_SESSION['partner_name'],
                        "partner_photo" => $_SESSION["partner_photo"]
                    ]);
                    echo json_encode(["success" => "true"]);
                    return true;
    
                } else {
                    $_POST['partner_photo'] = $_SESSION['partner_photo'];
                    $this->partnerModel->updateProfile($_POST);
                    $this->userModel->updateEmail($_POST['user_email'], $_SESSION['user_id']);
                    $getInfo = $this->partnerModel->getByUserID($_SESSION['user_id']);
                    foreach ($getInfo as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
    
                    $this->pusher->trigger('myProfile-' . $_SESSION['user_id'], 'update', [
                        "success" => "partner",
                        "partner_name" => substr($_SESSION['partner_name'], 0, 19) . "<br>". substr($_SESSION['partner_name'], 19),
                        "partner_name_plain" => $_SESSION['partner_name'],
                        "user_email" => substr($_SESSION['user_email'], 0, 30) . "<br>" . substr($_SESSION['user_email'], 30),
                    ]);
                    echo json_encode(["success" => "true"]);
                    return true;
                }
            } else {
                echo json_encode(["success" => "false", "message" => "Email already exists!"]);
                return true;
            }
            
        }
    }

    public function appointments()
    {
        loadView('head');
        loadView('partner/appointments', ["appointments" => $this->appointmentModel->getAll2()]);
    }

    public function getAllAppointments()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        header("Content-Type: application/json");
        $list = $this->appointmentModel->getAll2();
        $data = [];
        
        foreach($list as $row) {
            $id = $row['appointment_id'];
            if($row['appointment_status'] != 'Approved') {
                $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#updateAppointmentModal{$id}'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteAppointmentModal{$id}'><i class='ph ph-trash'></i></button>";
                $modals = '
                <div class="modal fade" id="updateAppointmentModal'.$id.'" tabindex="-1" aria-labelledby="updateAppointmentModalLabel'.$id.'" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form class="appointmentFormUpdate" data-id="'.$id.'">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateAppointmentModalLabel'.$id.'">Update Appointment Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-md-3">
                                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                                            <label class="form-label fw-semibold">Contact Person</label>
                                            <input class="form-control" type="text" name="appointment_contact_person" value="'.$row['appointment_contact_person'].'" readonly>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Position</label>
                                            <input class="form-control" type="text" name="appointment_position" value="'.$row['appointment_position'].'" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Company Name</label>
                                            <input class="form-control" type="text" name="appointment_company_name" value="'.$row['appointment_company_name'].'" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Company Address</label>
                                            <textarea class="form-control" name="appointment_company_address" readonly>'.$row['appointment_company_address'].'</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input class="form-control" type="text" name="appointment_phone_number" value="'.$row['appointment_phone_number'].'" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <input class="form-control" type="email" name="appointment_email" value="'.$row['appointment_email'].'" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Date and Time</label>
                                            <input class="form-control" type="datetime-local" name="appointment_date_time" value="'.$row['appointment_date_time'].'" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Message</label>
                                            <textarea class="form-control" name="appointment_message" required>'.$row['appointment_message'].'</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="appointment_id" value="'.$id.'" required>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteAppointmentModal'.$id.'" tabindex="-1" aria-labelledby="deleteAppointmentModalLabel'.$id.'" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form class="appointmentFormDelete" data-id="'.$id.'">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAppointmentModalLabel'.$id.'">Delete Appointment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 alert alert-danger">
                                            <b>Are you sure to delete this appointment?</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="appointment_id" value="'.$id.'" required>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    var updateAppointmentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'updateAppointmentModal'.$id.'\'), {
                        keyboard: true
                    });
                    var deleteAppointmentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteAppointmentModal'.$id.'\'), {
                        keyboard: true
                    });
        
                    $("#updateAppointmentModal'.$id.' .appointmentFormUpdate").data("modal", updateAppointmentModal'.$id.');
                    $("#deleteAppointmentModal'.$id.' .appointmentFormDelete").data("modal", deleteAppointmentModal'.$id.');
                </script>
                ';
            } else {
                $buttons = "";
                $modals = "";
            }

            $newRow = [
                $row['appointment_contact_person'],
                $row['appointment_company_name'],
                $row['appointment_phone_number'],
                $row['appointment_email'],
                $row['appointment_date_time'],
                $row['appointment_status'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function createAppointment()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if($this->requestMethod == "POST") {
            $create = $this->appointmentModel->createAppointment($_POST);

            if($create > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('appointments', 'update', ["success" => "true"]);
                return $create;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $create;
        }
    }

    public function updateAppointment($appointment_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['appointment_id'] = $appointment_id;
            $create = $this->appointmentModel->updateAppointment($_POST);

            if ($create > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('appointments', 'update', ["success" => "true"]);
                return $create;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $create;
        }
    }

    public function deleteAppointment($appointment_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['appointment_id'] = $appointment_id;
            $create = $this->appointmentModel->deleteAppointment($_POST);

            if ($create > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('appointments', 'update', ["success" => "true"]);
                return $create;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $create;
        }
    }

    public function linkage_and_partners()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('partner/linkage_and_partners');
    }

    public function getLinkageAndPartners()
    {
        if($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->linkageModel->getAll();

        echo json_encode(["data" => $list]);
    }

    public function institutional_membership()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('partner/institutional_membership');
    }

    public function getInstitutionalMemberships()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->institutionalMembershipModel->getAll();

        echo json_encode(["data" => $list]);
    }

    public function ojt_partners()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('partner/ojt_partners');
    }

    public function getOJTPartners()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->OJTPartnerModel->getAll();

        echo json_encode(["data" => $list]);
    }

    public function announcements()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getAnnouncementsPartner();

        loadView('head');
        loadView('partner/announcements', ["contents" => $list]);
    }

    public function events()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getEventsPartner();

        loadView('head');
        loadView('partner/events', ["contents" => $list]);
    }

    public function news()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getNewsPartner();

        loadView('head');
        loadView('partner/news', ["contents" => $list]);
    }

    public function getAnnouncements()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getAnnouncementsPartner();
        $data = [];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 200px; height: 200px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                // $row['content_content'],
                $row['content_date'],
                $row['content_status'],
                $buttons
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getEvents()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getEventsPartner();
        $data = [];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#contentViewModal{$id}'><i class='ph ph-eye'></i></button>&nbsp;<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="contentViewModal'.$id.'" tabindex="-1" aria-labelledby="contentViewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-capitalize" id="contentViewModalLabel">'.$row['content_type'].'</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    <h1>'.$row['content_title'].'</h1>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    '.(($row['content_photo'] != '') ? '<img src="'.$row['content_photo'].'" class="img-thumbnail"/>' : '').'
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    '.$row['content_content'].'
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editContentModal'.$id.'" tabindex="-1" aria-labelledby="editContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormUpdate" data-id="'.$id.'" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editContentModalLabel'.$id.'">Update Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12 text-center">
                                        <label class="form-label fw-semibold">Content Photo</label>
                                        <input class="form-control" id="file" type="file" name="content_photo" onchange="loadFile'.$id.'(event)" />
                                        <img id="output'.$id.'" class="img-fluid" src="'.$row['content_photo'].'" style="width: 200px; height: 200px" alt="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content Title</label>
                                        <input class="form-control" type="text" name="content_title" value="'.$row['content_title'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content</label>
                                        <div id="toolbar-container'.$id.'"></div>
                                        <div id="ckeditor_classic_empty'.$id.'" class="form-control content_content" placeholder="Enter your content..." data-content-id="'.$id.'">'.$row['content_content'].'</div>
                                    </div>
                                </div>
                                <input type="hidden" name="content_date" value="'.date('Y-m-d H:i:s').'" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteContentModal'.$id.'" tabindex="-1" aria-labelledby="deleteContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteContentModalLabel'.$id.'">Delete Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this content?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Content</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var editContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'editContentModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteContentModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#editContentModal'.$id.' .contentFormUpdate").data("modal", editContentModal'.$id.');
                $("#deleteContentModal'.$id.' .contentFormDelete").data("modal", deleteContentModal'.$id.');
            </script>
            ';
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 200px; height: 200px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                "<span class='text-capitalize'>".$row['content_status']."</span>",
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getNews()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getNewsPartner();
        $data = [];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#contentViewModal{$id}'><i class='ph ph-eye'></i></button>&nbsp;<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="contentViewModal'.$id.'" tabindex="-1" aria-labelledby="contentViewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-capitalize" id="contentViewModalLabel">'.$row['content_type'].'</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    <h1>'.$row['content_title'].'</h1>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    '.(($row['content_photo'] != '') ? '<img src="'.$row['content_photo'].'" class="img-thumbnail"/>' : '').'
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    '.$row['content_content'].'
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editContentModal'.$id.'" tabindex="-1" aria-labelledby="editContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormUpdate" data-id="'.$id.'" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editContentModalLabel'.$id.'">Update Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12 text-center">
                                        <label class="form-label fw-semibold">Content Photo</label>
                                        <input class="form-control" id="file" type="file" name="content_photo" onchange="loadFile'.$id.'(event)" />
                                        <img id="output'.$id.'" class="img-fluid" src="'.$row['content_photo'].'" style="width: 200px; height: 200px" alt="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content Title</label>
                                        <input class="form-control" type="text" name="content_title" value="'.$row['content_title'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content</label>
                                        <div id="toolbar-container'.$id.'"></div>
                                        <div id="ckeditor_classic_empty'.$id.'" class="form-control content_content" placeholder="Enter your content..." data-content-id="'.$id.'">'.$row['content_content'].'</div>
                                    </div>
                                </div>
                                <input type="hidden" name="content_date" value="'.date('Y-m-d H:i:s').'" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteContentModal'.$id.'" tabindex="-1" aria-labelledby="deleteContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteContentModalLabel'.$id.'">Delete Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this content?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Content</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var editContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'editContentModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteContentModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#editContentModal'.$id.' .contentFormUpdate").data("modal", editContentModal'.$id.');
                $("#deleteContentModal'.$id.' .contentFormDelete").data("modal", deleteContentModal'.$id.');
            </script>
            ';
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 200px; height: 200px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                "<span class='text-capitalize'>".$row['content_status']."</span>",
                $buttons .$modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function createContent()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");

        if ($this->requestMethod == "POST") {
            if (isset($_FILES['content_photo']) && $_FILES['content_photo']['error'] != 4) {
                $file = $_FILES['content_photo'];

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo (json_encode(['success' => "false", "message" => 'File upload error: ' . $file['error']]));
                    return false;
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                if (strpos($mime, 'image') === false) {
                    echo (json_encode(["success" => "false", "message" => "Only images are allowed"]));
                    return false;
                }
                finfo_close($finfo);

                $maxSize = 5 * 1024 * 1024;
                if ($file['size'] > $maxSize) {
                    echo (json_encode(["success" => "false", "message" => "The file is too large"]));
                    return false;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                $filename = str_replace(["../", "./"], "", $filename);

                $x = $_POST['content_type'];
                $uploadDir = 'uploads/' . $x . '/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    echo (json_encode(["success" => "false", "message" => "Failed to move uploaded file"]));
                    return false;
                }

                if (!@getimagesize($uploadDir . $filename)) {
                    unlink($uploadDir . $filename);
                    echo (json_encode(["success" => "false", "message" => "The file is not a valid image"]));
                    return false;
                }

                $_POST['content_photo'] = $uploadDir . $filename;
                $create = $this->contentModel->createContent($_POST);
                header("Content-Type: application/json");
            } else {
                $_POST['content_photo'] = '';
                $create = $this->contentModel->createContent($_POST);
                header("Content-Type: application/json");
            }

            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'Content added successfully']));
                $this->pusher->trigger('contents', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'Content adding failed']));
            }
            return $create;
        }
    }

    public function updateContent($content_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['content_id'] = $content_id;
            if (isset($_FILES['content_photo']) && $_FILES['content_photo']['error'] != 4) {
                $file = $_FILES['content_photo'];

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo (json_encode(['success' => "false", "message" => 'File upload error: ' . $file['error']]));
                    return false;
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                if (strpos($mime, 'image') === false) {
                    echo (json_encode(["success" => "false", "message" => "Only images are allowed"]));
                    return false;
                }
                finfo_close($finfo);

                $maxSize = 5 * 1024 * 1024;
                if ($file['size'] > $maxSize) {
                    echo (json_encode(["success" => "false", "message" => "The file is too large"]));
                    return false;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                $filename = str_replace(["../", "./"], "", $filename);

                $x = $_POST['content_type'];
                $uploadDir = 'uploads/' . $x . '/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    echo (json_encode(["success" => "false", "message" => "Failed to move uploaded file"]));
                    return false;
                }

                if (!@getimagesize($uploadDir . $filename)) {
                    unlink($uploadDir . $filename);
                    echo (json_encode(["success" => "false", "message" => "The file is not a valid image"]));
                    return false;
                }

                $_POST['content_photo'] = $uploadDir . $filename;
                $update = $this->contentModel->updateContent($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('contents', 'update', ["success" => "true"]);
                return true;
            } else {
                $_POST['content_photo'] = '';
                $update = $this->contentModel->updateContent($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('contents', 'update', ["success" => "true"]);
                return true;
            }
        }
    }

    public function deleteContent($content_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->contentModel->deleteContent($content_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('contents', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function confidential_document()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        $list = $this->confidentialDocumentsModel->getAll();

        loadView('head');
        loadView('partner/confidential_document', ['documents' => $list]);
    }

    public function createRequest()
    {
        if ($this->role == 'student' || !isset($this->role)) {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] != 4) {
                $file = $_FILES['document_file'];

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo (json_encode(['success' => "false", "message" => 'File upload error: ' . $file['error']]));
                    return false;
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                $allowedMimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain']; // Add more document mime types as needed

                if (!in_array($mime, $allowedMimeTypes)) {
                    echo (json_encode(["success" => "false", "message" => "Only document files are allowed"]));
                    return false;
                }
                finfo_close($finfo);

                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($file['size'] > $maxSize
                ) {
                    echo (json_encode(["success" => "false", "message" => "The file is too large"]));
                    return false;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                $filename = str_replace(["../", "./"], "", $filename);

                $uploadDir = 'uploads/files/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    echo (json_encode(["success" => "false", "message" => "Failed to move uploaded file"]));
                    return false;
                }

                $_POST['document_file'] = $uploadDir . $filename;
                $create = $this->confidentialDocumentsModel->createRequestFile($_POST);
                header("Content-Type: application/json");
            } else {
                header("Content-Type: application/json");
                echo (json_encode(['success' => "false", "message" => 'No file selected!']));
            }

            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'File added successfully']));
                $this->pusher->trigger('documents', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'File adding failed']));
            }
            return $create;
        }
    }

    public function getAllRequests()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->confidentialDocumentsModel->getRequestFiles();
        $data = [];

        foreach ($list as $row) {
            $id = $row['document_id'];
            
            if($row['document_uploaded_by'] == $_SESSION['user_id']) {
                $buttons = "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteRequestModal{$id}'><i class='ph ph-trash'></i></button>";
            } else {
                $buttons = "<button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#approveRequestModal{$id}'><i class='ph ph-check'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#denyRequestModal{$id}'><i class='ph ph-x'></i></button>";
            }

            $modals = '
            <div class="modal fade" id="deleteRequestModal'.$id.'" tabindex="-1" aria-labelledby="deleteRequestModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="requestFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteRequestModalLabel'.$id.'">Delete Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this request information?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="document_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="approveRequestModal'.$id.'" tabindex="-1" aria-labelledby="approveRequestModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="requestFormApprove" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveRequestModalLabel'.$id.'">Approve Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <b>Are you sure to approve this request information?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="document_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Approve Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="denyRequestModal'.$id.'" tabindex="-1" aria-labelledby="denyRequestModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="requestFormDeny" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="denyRequestModalLabel'.$id.'">Deny Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to deny this file?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="document_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Deny Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var approveRequestModal'.$id.' = new bootstrap.Modal(document.getElementById(\'approveRequestModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteRequestModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteRequestModal'.$id.'\'), {
                    keyboard: true
                });
                var denyRequestModal'.$id.' = new bootstrap.Modal(document.getElementById(\'denyRequestModal'.$id.'\'), {
                    keyboard: true
                });

                $("#approveRequestModal'.$id.' .requestFormApprove").data("modal", approveRequestModal'.$id.');
                $("#deleteRequestModal'.$id.' .requestFormDelete").data("modal", deleteRequestModal'.$id.');
                $("#denyRequestModal'.$id.' .requestFormDeny").data("modal", denyRequestModal'.$id.');
            </script>
            ';

            $status = "<span class='badge bg-primary text-white'>{$row['document_status']}</span>";

            $newRow = [
                $row['document_type'],
                $row['document_company'],
                $status,
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getAllFiles()
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->confidentialDocumentsModel->getFiles();
        $data = [];

        foreach ($list as $row) {
            $id = $row['document_id'];
            $buttons = "<button class='btn btn-sm btn-success text-white' onclick='window.open(\"" . $row['document_file'] . "\")'><i class='ph ph-download'></i></button>";

            switch ($row['document_status']) {
                case 'Approved':
                    $status = "<span class='badge bg-success text-white'>{$row['document_status']}</span>";
                    break;
                case 'Denied':
                    $status = "<span class='badge bg-danger text-white'>{$row['document_status']}</span>";
                    break;
                default:
                    $status = "<span class='badge bg-secondary text-white'>{$row['document_status']}</span>";
                    break;
            }

            $newRow = [
                $row['document_type'],
                $row['document_company'],
                $status,
                $buttons
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function approveRequest($document_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $approve = $this->confidentialDocumentsModel->approveRequest($document_id);

            if ($approve > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('documents', 'update', ["success" => "true"]);
                return $approve;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $approve;
        }
    }

    public function denyRequest($document_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $deny = $this->confidentialDocumentsModel->denyRequest($document_id);

            if ($deny > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('documents', 'update', ["success" => "true"]);
                return $deny;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $deny;
        }
    }

    public function deleteRequest($document_id)
    {
        if ($this->role != 'partner') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->confidentialDocumentsModel->deleteFile($document_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('documents', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }
}
