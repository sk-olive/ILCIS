<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AdminController
{
    private $userModel, $requestMethod, $role, $options, $pusher, $studentModel, $partnerModel, $expertModel, $appointmentModel, $linkageModel, $OJTPartnerModel, $institutionalMembershipModel, $contentModel, $inquiryModel, $confidentialDocumentsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($_SESSION['user_role'])) {
            $this->role = $_SESSION['user_role'];
        }

        $this->studentModel = new StudentModel();
        $this->partnerModel = new PartnerModel();
        $this->expertModel = new ExpertModel();
        $this->appointmentModel = new AppointmentModel();
        $this->linkageModel = new LinkageModel();
        $this->OJTPartnerModel = new OJTPartnerModel();
        $this->institutionalMembershipModel = new InstitutionalMembershipModel();
        $this->contentModel = new ContentModel();
        $this->inquiryModel = new InquiryModel();
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
        loadView('admin/index');
    }

    public function dashboard()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }
        $total_students = $this->studentModel->getTotalStudents();
        $total_partners = $this->partnerModel->getTotalPartners();
        $total_admins = $this->userModel->getTotalAdmin();
        $total_all = $total_students + $total_partners + $total_admins;
        $appointments = $this->appointmentModel->getAll1();

        $data = [
            "total_students" => $total_students,
            "total_partners" => $total_partners,
            "total_admins" => $total_admins,
            "total_all" => $total_all,
            "appointments" => $appointments
        ];

        loadView('head');
        loadView('admin/dashboard', $data);
    }

    public function students()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $data = [
            "students" => $this->studentModel->getStudents()
        ];
        
        loadView('head');
        loadView('admin/students', $data);
    }

    public function getAllStudents()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->studentModel->getStudents();
        $data = [];

        foreach ($list as $row) {
            $id = $row['user_id'];
            $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editStudentModal{$id}'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteStudentModal{$id}'><i class='ph ph-trash'></i></button>";
            $courses = ["BS in Information Technology", "BS Business Administration Major in Marketing Management", "BS Hospitality Management", "BS Psychology", "Bachelor of Science in Office Administration", "Bachelor of Secondary Education Major in English"];
            $modals = '
            <div class="modal fade" id="editStudentModal'.$id.'" tabindex="-1" aria-labelledby="editStudentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="studentFormUpdate" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStudentModalLabel'.$id.'">Update Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-md-3">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input class="form-control" type="text" name="student_fname" value="'.$row['student_fname'].'"  oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, \'\').slice(0, 100)" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input class="form-control" type="text" name="student_lname" value="'.$row['student_lname'].'" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, \'\').slice(0, 100)" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Student Number</label>
                                        <input class="form-control" type="text" name="student_number" value="'.$row['student_number'].'" oninput="this.value = this.value.replace(/[^0-9-]/g, \'\').slice(0,14)" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Student Birthday</label>
                                        <input class="form-control" type="date" name="student_birthday" value="'.$row['student_birthday'].'" max="'.date('Y-m-d').'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Sex</label>
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="student_gender" name="student_gender" required value="Male" '.($row['student_gender'] == "Male" ? "checked" : "").'>
                                                <span class="form-check-label">Male</span>
                                            </label>

                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="student_gender" name="student_gender" value="Female" '.($row['student_gender'] == "Female" ? "checked" : "").'>
                                                <span class="form-check-label">Female</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Course</label>
                                        <select class="form-select" name="student_course" required>
                                            <option value="'.$row['student_course'].'" selected>'.$row['student_course'].'</option>';
                                            foreach ($courses as $course) :
                                                if ($row['student_course'] !== $course) :
                                                    $modals .= '<option value="$course">$course</option>';
                                                endif;
                                            endforeach;
                                            $modals .= '
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteStudentModal'.$id.'" tabindex="-1" aria-labelledby="deleteStudentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="studentFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteStudentModalLabel'.$id.'">Delete Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this student?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var editStudentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'editStudentModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteStudentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteStudentModal'.$id.'\'), {
                    keyboard: true
                });

                $("#editStudentModal'.$id.' .studentFormUpdate").data("modal", editStudentModal'.$id.');
                $("#deleteStudentModal'.$id.' .studentFormDelete").data("modal", deleteStudentModal'.$id.');
            </script>
            ';

            $newRow = [
                $row['student_number'],
                $row['student_fname'] . " " . $row['student_lname'],
                $row['user_email'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function updateStudent($user_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['user_id'] = $user_id;
            
            $update = $this->studentModel->updateStudent($_POST);
            header("Content-Type: application/json");
            
            echo json_encode(["success" => "true"]);
            $this->pusher->trigger('students', 'update', ["success" => "true"]);
            return true;
        }
    }

    public function deleteStudent($user_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->studentModel->deleteStudent($user_id);

            if ($delete > 0) {
                if($this->userModel->deleteUser($user_id) > 0) {
                    header("Content-Type: application/json");
                    echo json_encode(["success" => "true"]);
                    $this->pusher->trigger('students', 'update', ["success" => "true"]);
                    return $delete;
                }
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function partners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $data = [
            "partners" => $this->partnerModel->getPartners()
        ];

        loadView('head');
        loadView('admin/partners', $data);
    }

    public function getPartners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $data = [
            "partners" => $this->partnerModel->getPartners()
        ];

        echo json_encode($data);
        return true;
    }

    public function getPartner($partner_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        echo json_encode($this->partnerModel->getByPartnerID($partner_id));
        return true;
    }

    public function getAllPartners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->partnerModel->getPartners();
        $data = [];

        foreach ($list as $row) {
            $id = $row['user_id'];
            $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editPartnerModal{$id}'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deletePartnerModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="editPartnerModal'.$id.'" tabindex="-1" aria-labelledby="editPartnerModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="partnerFormUpdate" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPartnerModalLabel'.$id.'">Update Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Partner Name</label>
                                        <input class="form-control" type="text" name="partner_name" value="'.$row['partner_name'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Partner Address</label>
                                        <input class="form-control" type="text" name="partner_address" value="'.$row['partner_address'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Contact Person</label>
                                        <input class="form-control" type="text" name="partner_person" value="'.$row['partner_person'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input class="form-control" type="text" name="partner_contact" value="'.$row['partner_contact'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Telephone Number</label>
                                        <input class="form-control" type="text" name="partner_telephone" value="'.$row['partner_telephone'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Position</label>
                                        <input class="form-control" type="text" name="partner_position" value="'.$row['partner_position'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deletePartnerModal'.$id.'" tabindex="-1" aria-labelledby="deletePartnerModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="partnerFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletepartnerModalLabel'.$id.'">Delete Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this partner?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Partner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var editPartnerModal'.$id.' = new bootstrap.Modal(document.getElementById(\'editPartnerModal'.$id.'\'), {
                    keyboard: true
                });
                var deletePartnerModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deletePartnerModal'.$id.'\'), {
                    keyboard: true
                });

                $("#editPartnerModal'.$id.' .partnerFormUpdate").data("modal", editPartnerModal'.$id.');
                $("#deletePartnerModal'.$id.' .partnerFormDelete").data("modal", deletePartnerModal'.$id.');
            </script>
            ';

            $newRow = [
                $row['partner_name'],
                $row['partner_address'],
                $row['user_email'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function updatePartner($user_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['user_id'] = $user_id;

            $update = $this->partnerModel->updatePartner($_POST);
            header("Content-Type: application/json");

            echo json_encode(["success" => "true"]);
            $this->pusher->trigger('partners', 'update', ["success" => "true"]);
            return true;
        }
    }

    public function deletePartner($user_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->partnerModel->deletePartner($user_id);

            if ($delete > 0) {
                if($this->userModel->deleteUser($user_id) > 0) {
                    header("Content-Type: application/json");
                    echo json_encode(["success" => "true"]);
                    $this->pusher->trigger('partners', 'update', ["success" => "true"]);
                    return $delete;
                }
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function pool_of_experts()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $data = [
            "experts" => $this->expertModel->getAll()
        ];

        loadView('head');
        loadView('admin/pool_of_experts', $data);
    }

    public function getAllExperts()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->expertModel->getAll();
        $data = [];

        foreach ($list as $row) {
            $id = $row['expert_id'];
            $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#updateExpertModal{$id}'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteExpertModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="updateExpertModal'.$id.'" tabindex="-1" aria-labelledby="updateExpertModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="expertFormUpdate" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateExpertModalLabel'.$id.'">Update Expert</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Name of Expert</label>
                                        <input class="form-control" type="text" name="expert_name" value="'.$row['expert_name'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Position/Designation</label>
                                        <input class="form-control" type="text" name="expert_department" value="'.$row['expert_department'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Field of Specialization</label>
                                        <input class="form-control" type="text" name="expert_position" value="'.$row['expert_position'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Contact</label>
                                        <input class="form-control" type="text" name="expert_contact" value="'.$row['expert_contact'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="expert_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteExpertModal'.$id.'" tabindex="-1" aria-labelledby="deleteExpertModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="expertFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteExpertModalLabel'.$id.'">Delete Expert</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this expert?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="expert_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Expert</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var updateExpertModal'.$id.' = new bootstrap.Modal(document.getElementById(\'updateExpertModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteExpertModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteExpertModal'.$id.'\'), {
                    keyboard: true
                });

                $("#updateExpertModal'.$id.' .expertFormUpdate").data("modal", updateExpertModal'.$id.');
                $("#deleteExpertModal'.$id.' .expertFormDelete").data("modal", deleteExpertModal'.$id.');
            </script>
            ';

            $newRow = [
                $row['expert_name'],
                $row['expert_department'],
                $row['expert_position'],
                $row['expert_contact'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function createExpert()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $create = $this->expertModel->createExpert($_POST);
            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'Expert added successfully']));
                $this->pusher->trigger('experts', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'Expert adding failed']));
            }
            return $create;
        }
    }

    public function updateExpert($expert_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['expert_id'] = $expert_id;

            $update = $this->expertModel->updateExpert($_POST);
            header("Content-Type: application/json");

            echo json_encode(["success" => "true"]);
            $this->pusher->trigger('experts', 'update', ["success" => "true"]);
            return true;
        }
    }

    public function deleteExpert($expert_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['expert_id'] = $expert_id;
            $delete = $this->expertModel->deleteExpert($_POST);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('experts', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function appointments()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }
        
        loadView('head');
        loadView('admin/appointments', ["appointments" => $this->appointmentModel->getAll(), "partners" => $this->partnerModel->getPartners()]);
    }

    public function getAllAppointments()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }
        header("Content-Type: application/json");
        $list = $this->appointmentModel->getAll();
        $data = [];

        foreach ($list as $row) {
            $id = $row['appointment_id'];
            $status = ['Approved', 'Cancelled', 'Did not attend', 'Postponed'];
            if($row['appointment_status'] != 'Approved' && $row['appointment_status'] && 'Cancelled' && $row['appointment_status'] != 'Did not attend') {
                $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#updateAppointmentModal{$id}'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#changeAppointmentModal{$id}'><i class='ph ph-gear'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteAppointmentModal{$id}'><i class='ph ph-trash'></i></button>";
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
                                            <label class="form-label fw-semibold">Date and Time  <span class="text-danger">*</span></label>
                                            <input class="form-control" type="datetime-local" name="appointment_date_time" value="'.$row['appointment_date_time'].'" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Message  <span class="text-danger">*</span></label>
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
                <div class="modal fade" id="changeAppointmentModal'.$id.'" tabindex="-1" aria-labelledby="changeAppointmentModalLabel'.$id.'" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form class="appointmentFormChange" data-id="'.$id.'">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeAppointmentModalLabel'.$id.'">Delete Appointment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select class="form-select" name="appointment_status" required>
                                                <option value="'.$row['appointment_status'].'" selected>'.$row['appointment_status'].'</option>';
                                                foreach ($status as $x):
                                                    if ($row['appointment_status'] !== $x) :
                                                        $modals .= ' <option value="'.$x.'">'.$x.'</option>';
                                                    endif;
                                                endforeach;
                                                $modals .= '
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="appointment_id" value="'.$id.'" required>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Change Status</button>
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
                    var changeAppointmentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'changeAppointmentModal'.$id.'\'), {
                        keyboard: true
                    });
        
                    $("#updateAppointmentModal'.$id.' .appointmentFormUpdate").data("modal", updateAppointmentModal'.$id.');
                    $("#deleteAppointmentModal'.$id.' .appointmentFormDelete").data("modal", deleteAppointmentModal'.$id.');
                    $("#changeAppointmentModal'.$id.' .appointmentFormChange").data("modal", changeAppointmentModal'.$id.');
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
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $create = $this->appointmentModel->createAppointment($_POST);

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

    public function updateAppointment($appointment_id)
    {
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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

    public function changeAppointment($appointment_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['appointment_id'] = $appointment_id;
            $create = $this->appointmentModel->updateStatus($_POST);

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
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->linkageModel->getAll();

        loadView('head');
        loadView('admin/linkage_and_partners', ["linkages" => $list]);
    }

    public function getLinkageAndPartners()
    {
        if($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->linkageModel->getAll();
        $modals = [];
        foreach($list as $row) {
            $id = $row['linkage_id'];
            $modals[] .= '
            <div class="modal fade" id="updateLinkageModal'.$id.'" tabindex="-1" aria-labelledby="updateLinkageModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="linkageFormUpdate" data-id="'.$id.'" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateLinkageModalLabel'.$id.'">Update Linkage</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Linkage Partner Logo</label>
                                        <input class="form-control" id="file" type="file" name="linkage_photo" value="'.$row['linkage_photo'].'" required/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Linkage Name</label>
                                        <input class="form-control" type="text" name="linkage_name" value="'.$row['linkage_name'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Linkage Link</label>
                                        <input class="form-control" type="text" name="linkage_link" value="'.$row['linkage_link'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteLinkageModal'.$id.'" tabindex="-1" aria-labelledby="deleteLinkageModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="linkageFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteLinkageModalLabel'.$id.'">Delete Linkage</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this linkage?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Linkage</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var updateLinkageModal'.$id.' = new bootstrap.Modal(document.getElementById(\'updateLinkageModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteLinkageModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteLinkageModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#updateLinkageModal'.$id.' .linkageFormUpdate").data("modal", updateLinkageModal'.$id.');
                $("#deleteLinkageModal'.$id.' .linkageFormDelete").data("modal", deleteLinkageModal'.$id.');
            </script>
            ';
        }

        echo json_encode(["data" => $list, "modals" => $modals]);
    }

    public function createLinkageAndPartners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            if (isset($_FILES['linkage_photo']) && $_FILES['linkage_photo']['error'] != 4) {
                $file = $_FILES['linkage_photo'];

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

                $uploadDir = 'uploads/linkages/';
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

                $_POST['linkage_photo'] = $uploadDir . $filename;
                $create = $this->linkageModel->createLinkage($_POST);
                header("Content-Type: application/json");
            } else {
                $_POST['linkage_photo'] = '/public/assets/images/user.png';
                $create = $this->linkageModel->createLinkage($_POST);
                header("Content-Type: application/json");
            }

            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'Linkage added successfully']));
                $this->pusher->trigger('linkages', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'Linkage adding failed']));
            }
            return $create;
        }
    }

    public function updateLinkageAndPartners($linkage_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['linkage_id'] = $linkage_id;
            if (isset($_FILES['linkage_photo']) && $_FILES['linkage_photo']['error'] != 4) {
                $file = $_FILES['linkage_photo'];

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

                $uploadDir = 'uploads/linkages/';
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

                $_POST['linkage_photo'] = $uploadDir . $filename;
                $update = $this->linkageModel->updateLinkage($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('linkages', 'update', ["success" => "true"]);
                return true;
            } else {
                $_POST['linkage_photo'] = '';
                $update = $this->linkageModel->updateLinkage($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('linkages', 'update', ["success" => "true"]);
                return true;
            }
        }
    }

    public function deleteLinkageAndPartners($linkage_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->linkageModel->deleteLinkage($linkage_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('linkages', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function ojt_partners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->OJTPartnerModel->getAll();

        loadView('head');
        loadView('admin/ojt_partners', ["ojts" => $list]);
    }

    public function getOJTPartners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->OJTPartnerModel->getAll();
        $modals = [];
        foreach($list as $row) {
            $id = $row['ojt_id'];
            $modals[] .= '
            <div class="modal fade" id="updateOJTPartnerModal'.$id.'" tabindex="-1" aria-labelledby="updateOJTPartnerModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="ojtFormUpdate" data-id="'.$id.'" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateOJTPartnerModalLabel'.$id.'">Update OJT Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">OJT Partner Partner Logo</label>
                                        <input class="form-control" id="file" type="file" name="ojt_photo" value="'.$row['ojt_photo'].'" required/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">OJT Partner Name</label>
                                        <input class="form-control" type="text" name="ojt_name" value="'.$row['ojt_name'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">OJT Partner Link</label>
                                        <input class="form-control" type="text" name="ojt_link" value="'.$row['ojt_link'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteOJTPartnerModal'.$id.'" tabindex="-1" aria-labelledby="deleteOJTPartnerModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="ojtFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteOJTPartnerModalLabel'.$id.'">Delete OJT Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this OJT partner?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete OJT Partner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var updateOJTPartnerModal'.$id.' = new bootstrap.Modal(document.getElementById(\'updateOJTPartnerModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteOJTPartnerModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteOJTPartnerModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#updateOJTPartnerModal'.$id.' .ojtFormUpdate").data("modal", updateOJTPartnerModal'.$id.');
                $("#deleteOJTPartnerModal'.$id.' .ojtFormDelete").data("modal", deleteOJTPartnerModal'.$id.');
            </script>
            ';
        }

        echo json_encode(["data" => $list, "modals" => $modals]);
    }

    public function createOJTPartners()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            if (isset($_FILES['ojt_photo']) && $_FILES['ojt_photo']['error'] != 4) {
                $file = $_FILES['ojt_photo'];

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

                $uploadDir = 'uploads/ojts/';
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

                $_POST['ojt_photo'] = $uploadDir . $filename;
                $create = $this->OJTPartnerModel->createOJTPartner($_POST);
                header("Content-Type: application/json");
            } else {
                $_POST['ojt_photo'] = '/public/assets/images/user.png';
                $create = $this->OJTPartnerModel->createOJTPartner($_POST);
                header("Content-Type: application/json");
            }

            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'OJT Partner added successfully']));
                $this->pusher->trigger('ojts', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'OJT Partner adding failed']));
            }
            return $create;
        }
    }

    public function updateOJTPartners($ojt_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['ojt_id'] = $ojt_id;
            if (isset($_FILES['ojt_photo']) && $_FILES['ojt_photo']['error'] != 4) {
                $file = $_FILES['ojt_photo'];

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

                $uploadDir = 'uploads/ojts/';
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

                $_POST['ojt_photo'] = $uploadDir . $filename;
                $update = $this->OJTPartnerModel->updateOJTPartner($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('ojts', 'update', ["success" => "true"]);
                return true;
            } else {
                $_POST['ojt_photo'] = '';
                $update = $this->OJTPartnerModel->updateOJTPartner($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('ojts', 'update', ["success" => "true"]);
                return true;
            }
        }
    }

    public function deleteOJTPartners($ojt_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->OJTPartnerModel->deleteOJTPartner($ojt_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('ojts', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function institutional_membership()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->institutionalMembershipModel->getAll();

        loadView('head');
        loadView('admin/institutional_membership', ["institutional_memberships" => $list]);
    }

    public function getInstitutionalMemberships()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->institutionalMembershipModel->getAll();
        $modals = [];
        foreach($list as $row) {
            $id = $row['institutional_membership_id'];
            $modals[] .= '
            <div class="modal fade" id="updateInstitutionalMembershipModal'.$id.'" tabindex="-1" aria-labelledby="updateInstitutionalMembershipModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="institutional_membershipFormUpdate" data-id="'.$id.'" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateInstitutionalMembershipModalLabel'.$id.'">Update Institutional Membership</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Institutional Membership Partner Logo</label>
                                        <input class="form-control" id="file" type="file" name="institutional_membership_photo" value="'.$row['institutional_membership_photo'].'" required/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Institutional Membership Name</label>
                                        <input class="form-control" type="text" name="institutional_membership_name" value="'.$row['institutional_membership_name'].'" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Institutional Membership Link</label>
                                        <input class="form-control" type="text" name="institutional_membership_link" value="'.$row['institutional_membership_link'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteInstitutionalMembershipModal'.$id.'" tabindex="-1" aria-labelledby="deleteInstitutionalMembershipModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="institutional_membershipFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteInstitutionalMembershipModalLabel'.$id.'">Delete Institutional Membership Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this institutional membership partner?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Institutional Membership</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var updateInstitutionalMembershipModal'.$id.' = new bootstrap.Modal(document.getElementById(\'updateInstitutionalMembershipModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteInstitutionalMembershipModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteInstitutionalMembershipModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#updateInstitutionalMembershipModal'.$id.' .institutional_membershipFormUpdate").data("modal", updateInstitutionalMembershipModal'.$id.');
                $("#deleteInstitutionalMembershipModal'.$id.' .institutional_membershipFormDelete").data("modal", deleteInstitutionalMembershipModal'.$id.');
            </script>
            ';
        }

        echo json_encode(["data" => $list, "modals" => $modals]);

        // echo json_encode(["data" => $list]);
    }

    public function createInstitutionalMemberships()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            if (isset($_FILES['institutional_membership_photo']) && $_FILES['institutional_membership_photo']['error'] != 4) {
                $file = $_FILES['institutional_membership_photo'];

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

                $uploadDir = 'uploads/institutional_memberships/';
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

                $_POST['institutional_membership_photo'] = $uploadDir . $filename;
                $create = $this->institutionalMembershipModel->createInstitutionalMembership($_POST);
                header("Content-Type: application/json");
            } else {
                $_POST['institutional_membership_photo'] = '/public/assets/images/user.png';
                $create = $this->institutionalMembershipModel->createInstitutionalMembership($_POST);
                header("Content-Type: application/json");
            }

            if ($create > 0) {
                echo (json_encode(['success' => "true", "message" => 'Institutional Membership Partner added successfully']));
                $this->pusher->trigger('institutional_memberships', 'update', ["success" => "true"]);
            } else {
                echo (json_encode(['success' => "false", "message" => 'Institutional Membership Partner adding failed']));
            }
            return $create;
        }
    }

    public function updateInstitutionalMemberships($institutional_membership_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $_POST['institutional_membership_id'] = $institutional_membership_id;
            if (isset($_FILES['institutional_membership_photo']) && $_FILES['institutional_membership_photo']['error'] != 4) {
                $file = $_FILES['institutional_membership_photo'];

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

                $uploadDir = 'uploads/institutional_memberships/';
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

                $_POST['institutional_membership_photo'] = $uploadDir . $filename;
                $update = $this->institutionalMembershipModel->updateInstitutionalMembership($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('institutional_memberships', 'update', ["success" => "true"]);
                return true;
            } else {
                $_POST['institutional_membership_photo'] = '';
                $update = $this->institutionalMembershipModel->updateInstitutionalMembership($_POST);
                header("Content-Type: application/json");

                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('institutional_memberships', 'update', ["success" => "true"]);
                return true;
            }
        }
    }

    public function deleteInstitutionalMemberships($institutional_membership_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->institutionalMembershipModel->deleteInstitutionalMembership($institutional_membership_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('institutional_memberships', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function announcements()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getAnnouncements();

        loadView('head');
        loadView('admin/announcements', ["contents" => $list]);
    }

    public function events()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getEvents();

        loadView('head');
        loadView('admin/events', ["contents" => $list]);
    }

    public function news()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getNews();

        loadView('head');
        loadView('admin/news', ["contents" => $list]);
    }

    public function for_approvals()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->contentModel->getForApprovals();

        loadView('head');
        loadView('admin/for_approvals', ["contents" => $list]);
    }

    public function getAnnouncements()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getAnnouncements();
        $data = [];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 100px; height: 100px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                ucwords($row['content_status']),
                $buttons
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getEvents()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getEvents();
        $data = [];
        $array = ["published" => "Published", "unpublished" => "Unpublished"];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#contentViewModal{$id}'><i class='ph ph-eye'></i></button>&nbsp;<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="contentViewModal'.$id.'" tabindex="-1" aria-labelledby="contentViewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="contentViewModalLabel">Event</h1>
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
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content Visibility</label>
                                        <select class="form-select" name="content_status" required>';
                                            foreach($array as $key => $value):
                                                if ($key == $row['content_status']) :
                                                    $modals .= '<option value="'.$key.'" selected>'.$value.'</option>';
                                                else:
                                                $modals .= '<option value="'.$key.'">'.$value.'</option>';
                                                endif;
                                            endforeach;
                                            $modals .= '
                                        </select>
                                    </div>
                                </div>
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
            <div class="modal fade" id="approveContentModal'.$id.'" tabindex="-1" aria-labelledby="approveContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormApprove" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveContentModalLabel'.$id.'">Approve Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <b>Are you sure to approve this content?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Approve Content</button>
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
                var approveContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'approveContentModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#editContentModal'.$id.' .contentFormUpdate").data("modal", editContentModal'.$id.');
                $("#deleteContentModal'.$id.' .contentFormDelete").data("modal", deleteContentModal'.$id.');
                $("#approveContentModal'.$id.' .contentFormApprove").data("modal", approveContentModal'.$id.');
            </script>
            ';
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 100px; height: 100px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                ucwords($row['content_status']),
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getNews()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getNews();
        $data = [];
        $array = ["published" => "Published", "unpublished" => "Unpublished"];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#contentViewModal{$id}'><i class='ph ph-eye'></i></button>&nbsp;<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
            $modals = '
            <div class="modal fade" id="contentViewModal'.$id.'" tabindex="-1" aria-labelledby="contentViewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="contentViewModalLabel">News</h1>
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
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Content Visibility</label>
                                        <select class="form-select" name="content_status" required>';
                                            foreach($array as $key => $value):
                                                if ($key == $row['content_status']) :
                                                    $modals .= '<option value="'.$key.'" selected>'.$value.'</option>';
                                                else:
                                                $modals .= '<option value="'.$key.'">'.$value.'</option>';
                                                endif;
                                            endforeach;
                                            $modals .= '
                                        </select>
                                    </div>
                                </div>
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
            <div class="modal fade" id="approveContentModal'.$id.'" tabindex="-1" aria-labelledby="approveContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormApprove" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveContentModalLabel'.$id.'">Approve Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <b>Are you sure to approve this content?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Approve Content</button>
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
                var approveContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'approveContentModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#editContentModal'.$id.' .contentFormUpdate").data("modal", editContentModal'.$id.');
                $("#deleteContentModal'.$id.' .contentFormDelete").data("modal", deleteContentModal'.$id.');
                $("#approveContentModal'.$id.' .contentFormApprove").data("modal", approveContentModal'.$id.');
            </script>
            ';
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 100px; height: 100px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                ucwords($row['content_status']),
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getForApprovals()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->contentModel->getForApprovals();
        $data = [];

        foreach ($list as $row) {
            $id = $row['content_id'];
            $buttons = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#contentViewModal{$id}'><i class='ph ph-eye'></i></button>&nbsp;<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editContentModal{$id}' onclick='openEditor($id)'><i class='ph ph-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#approveContentModal{$id}'><i class='ph ph-check'></i></button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteContentModal{$id}'><i class='ph ph-trash'></i></button>";
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
            <div class="modal fade" id="approveContentModal'.$id.'" tabindex="-1" aria-labelledby="approveContentModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="contentFormApprove" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveContentModalLabel'.$id.'">Approve Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <b>Are you sure to approve this content?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Approve Content</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var deleteContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteContentModal'.$id.'\'), {
                    keyboard: true
                });
                var editContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'editContentModal'.$id.'\'), {
                    keyboard: true
                });
                var approveContentModal'.$id.' = new bootstrap.Modal(document.getElementById(\'approveContentModal'.$id.'\'), {
                    keyboard: true
                });

                var loadFile'.$id.' = function(event) {
                    var image'.$id.' = document.getElementById("output'.$id.'");
                    image'.$id.'.src = URL.createObjectURL(event.target.files[0]);
                };

                $("#deleteContentModal'.$id.' .contentFormDelete").data("modal", deleteContentModal'.$id.');
                $("#approveContentModal'.$id.' .contentFormApprove").data("modal", approveContentModal'.$id.');
                $("#editContentModal'.$id.' .contentFormUpdate").data("modal", editContentModal'.$id.');
            </script>
            ';
            $img = ($row['content_photo'] != '') ? "<img src='" . $row['content_photo'] . "' style='width: 100px; height: 100px' />" : 'No Photo Available';
            $newRow = [
                $img,
                $row['content_author'],
                $row['content_title'],
                ucwords($row['content_type']),
                strlen($cleaned_content = strip_tags($row['content_content'])) > 50 ? substr($cleaned_content, 0, 50) . '...' : $cleaned_content,
                $row['content_date'],
                ucwords($row['content_status']),
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function createContent()
    {
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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

    public function approveContent($content_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $approve = $this->contentModel->approveContent($content_id);

            if ($approve > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('contents', 'update', ["success" => "true"]);
                return $approve;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $approve;
        }
    }

    public function inquiry()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $inquiry = $this->inquiryModel->getAll();
        $inquiry1 = $this->inquiryModel->getAll1();

        $data = ["inquiry" => $inquiry, "inquiry1" => $inquiry1];

        loadView('head');
        loadView('admin/inquiry', $data);
    }

    public function getAllInquiry()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->inquiryModel->getAll();
        $data = [];

        foreach ($list as $row) {
            $id = $row['inquiry_id'];
            $buttons = "<button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#replyInquiryModal{$id}' onclick='openEditor($id)'>Reply</button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteInquiryModal{$id}'>Delete</button>";
            $modals = '
            <div class="modal fade" id="deleteInquiryModal'.$id.'" tabindex="-1" aria-labelledby="deleteInquiryModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="inquiryFormDelete" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteInquiryModalLabel'.$id.'">Delete Inquiry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this inquiry?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="inquiry_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Inquiry</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="replyInquiryModal'.$id.'" tabindex="-1" aria-labelledby="replyInquiryModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="replyInquiryForm" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="replyInquiryModalLabel'.$id.'">Reply to Inquiry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-md-3">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold">Name</label>
                                        <input class="form-control" type="text" value="'.$row['inquiry_name'].'" readonly>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input class="form-control" type="text" name="reply_email" value="'.$row['user_email'].'" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Subject</label>
                                        <input class="form-control" type="text" name="reply_subject" value="[REPLY] '.$row['inquiry_subject'].'" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message</label>
                                        <textarea class="form-control" readonly>'.$row['inquiry_message'].'</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message Reply</label>
                                        <div id="toolbar-container'.$id.'"></div>
                                        <div class="form-control reply_message" id="ckeditor_classic_empty'.$id.'"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var replyInquiryModal'.$id.' = new bootstrap.Modal(document.getElementById(\'replyInquiryModal'.$id.'\'), {
                    keyboard: true
                });
                var deleteInquiryModal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteInquiryModal'.$id.'\'), {
                    keyboard: true
                });

                $("#replyInquiryModal'.$id.' .replyInquiryForm").data("modal", replyInquiryModal'.$id.');
                $("#deleteInquiryModal'.$id.' .inquiryFormDelete").data("modal", deleteInquiryModal'.$id.');
            </script>
            ';

            $newRow = [
                $row['user_email'],
                $row['inquiry_subject'],
                $row['inquiry_name'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function getAllInquiry1()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->inquiryModel->getAll1();
        $data = [];

        foreach ($list as $row) {
            $id = $row['inquiry_id'];
            $buttons = "<button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#replyInquiry1Modal{$id}' onclick='openEditor1($id)'>Reply</button>&nbsp;<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteInquiry1Modal{$id}'>Delete</button>";
            $modals = '
            <div class="modal fade" id="deleteInquiry1Modal'.$id.'" tabindex="-1" aria-labelledby="deleteInquiry1ModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="inquiryFormDelete1" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteInquiry1ModelLabel'.$id.'">Delete Inquiry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 alert alert-danger">
                                        <b>Are you sure to delete this inquiry?</b>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="inquiry_id" value="'.$id.'" required>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete Inquiry</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="replyInquiry1Modal'.$id.'" tabindex="-1" aria-labelledby="replyInquiry1ModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="replyInquiry1Form" data-id="'.$id.'">
                            <div class="modal-header">
                                <h5 class="modal-title" id="replyInquiry1ModalLabel'.$id.'">Reply to Inquiry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-md-3">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold">Name</label>
                                        <input class="form-control" type="text" value="'.$row['inquiry_name'].'" readonly>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input class="form-control" type="text" name="reply_email" value="'.$row['inquiry_email'].'" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Subject</label>
                                        <input class="form-control" type="text" name="reply_subject" value="[REPLY] '.$row['inquiry_subject'].'" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message</label>
                                        <textarea class="form-control" readonly>'.$row['inquiry_message'].'</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message Reply</label>
                                        <div id="toolbar-container'.$id.'"></div>
                                        <div class="form-control reply_message" id="ckeditor_classic1_empty'.$id.'"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var replyInquiry1Modal'.$id.' = new bootstrap.Modal(document.getElementById(\'replyInquiry1Modal'.$id.'\'), {
                    keyboard: true
                });
                var deleteInquiry1Modal'.$id.' = new bootstrap.Modal(document.getElementById(\'deleteInquiry1Modal'.$id.'\'), {
                    keyboard: true
                });

                $("#replyInquiry1Modal'.$id.' .replyInquiry1Form").data("modal", replyInquiry1Modal'.$id.');
                $("#deleteInquiry1Modal'.$id.' .inquiryFormDelete1").data("modal", deleteInquiry1Modal'.$id.');
            </script>
            ';

            $newRow = [
                $row['inquiry_email'],
                $row['inquiry_subject'],
                $row['inquiry_name'],
                $buttons . $modals
            ];

            $data[] = $newRow;
        }

        echo json_encode(["data" => $data]);
    }

    public function replyInquiry()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if($this->requestMethod == 'POST') {
            extract($_POST);

            header("Content-Type: application/json");

            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "ssl";
            $mail->Port       = 465;
            $mail->Username   = "cvsuIlink2024@gmail.com";
            $mail->Password   = "rsmfdtknjxgtgzro";
            $mail->IsHTML(true);
            $mail->From       = "cvsuIlink2024@gmail.com";
            $mail->FromName   = "ILINK Information Management";
            $mail->Sender     = "cvsuIlink2024@gmail.com";
            $mail->Subject    = $reply_subject;
            $mail->Body       = $reply_message;
            $mail->AddAddress($reply_email);
            try {
                if($mail->Send()) {
                    echo json_encode(["success" => "true"]);
                    return true;
                }
            } catch (Exception $e) {
                echo json_encode(["success" => "false", "message" => 'Caught exception: ' . $e->getMessage() . "\n"]);
                return false;
            }
        }
    }

    public function deleteInquiry($inquiry_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->inquiryModel->deleteInquiry($inquiry_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('inquiry', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function deleteInquiry1($inquiry_id)
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $delete = $this->inquiryModel->deleteInquiry1($inquiry_id);

            if ($delete > 0) {
                header("Content-Type: application/json");
                echo json_encode(["success" => "true"]);
                $this->pusher->trigger('inquiry', 'update', ["success" => "true"]);
                return $delete;
            }

            echo json_encode(["success" => "false", "message" => "Something went wrong, please contact the administrator."]);
            return $delete;
        }
    }

    public function confidential_document()
    {
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        $list = $this->confidentialDocumentsModel->getAll();
        $partners = $this->partnerModel->getAllPartners();

        loadView('head');
        loadView('admin/confidential_document', ['documents' => $list, "partners" => $partners]);
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
        if ($this->role != 'admin') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->confidentialDocumentsModel->getRequestFilesAdmin();
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
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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
        if ($this->role != 'admin') {
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
