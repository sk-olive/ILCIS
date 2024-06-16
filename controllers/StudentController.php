<?php
session_start();
require 'vendor/autoload.php';

class StudentController
{
    private $userModel, $requestMethod, $role, $options, $pusher, $studentModel, $inquiryModel, $linkageModel, $OJTPartnerModel, $institutionalMembershipModel, $contentModel ;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($_SESSION['user_role'])) {
            $this->role = $_SESSION['user_role'];
        }

        $this->studentModel = new StudentModel();
        $this->inquiryModel = new InquiryModel();
        $this->linkageModel = new LinkageModel();
        $this->OJTPartnerModel = new OJTPartnerModel();
        $this->contentModel = new ContentModel();
        $this->institutionalMembershipModel = new InstitutionalMembershipModel();
        
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
        loadView('student/index');
    }

    public function dashboard()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        $events = $this->contentModel->getDashboardEvents();
        $news = $this->contentModel->getDashboardNews();

        $data = ["events" => $events, "news" => $news];

        loadView('head');
        loadView('student/dashboard', $data);
    }
    
    public function profile()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('student/profile');
    }

    public function inquiry()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            $create = $this->inquiryModel->createInquiry($_SESSION['user_id'], $_POST['inquiry_message'], $_POST['inquiry_message']);
            if ($create > 0) {
                $this->pusher->trigger('inquiry', 'update', ["success" => "true"]);
                echo (json_encode(['success' => "true", "message" => 'Inquiry sent successfully']));
            } else {
                echo (json_encode(['success' => "false", "message" => 'Error sending inquiry']));
            }
            return $create;
        }
    }

    public function updateProfile()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        if ($this->requestMethod == "POST") {
            header("Content-Type: application/json");
            $check = $this->userModel->checkDuplicate($_POST['user_email']);
            // die(var_dump($_POST['user_email'] == $_SESSION['user_email']));
            if($check['num_rows'] == 0 || $_POST['user_email'] == $_SESSION['user_email']) {
                if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] != 4) {
                    $file = $_FILES['student_photo'];
    
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
    
                    $maxSize = 10 * 1024 * 1024;
                    if ($file['size'] > $maxSize) {
                        echo (json_encode(["success" => "false", "message" => "The file is too large"]));
                        return false;
                    }
    
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $ext;
    
                    $filename = str_replace(["../", "./"], "", $filename);
    
                    $uploadDir = 'uploads/students/';
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
    
                    $_POST['student_photo'] = $uploadDir . $filename;
                    $this->studentModel->updateProfile($_POST);
                    $user = $this->userModel->updateEmail($_POST['user_email'], $_SESSION['user_id']);
                    $getInfo = $this->studentModel->getByUserID($_SESSION['user_id']);
                    foreach ($getInfo as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
    
                    $this->pusher->trigger('myProfile-' . $_SESSION['user_id'], 'update', [
                        "success" => "student",
                        "student_name" => substr($_SESSION['student_fname'] . " " . $_SESSION['student_lname'], 0, 19) . "<br>" . substr($_SESSION['student_fname'] . " " . $_SESSION['student_lname'], 19),
                        "user_email" => substr($_SESSION['user_email'], 0, 30) . "<br>" . substr($_SESSION['user_email'], 30),
                        "student_name_plain" => $_SESSION['student_fname'] . " " . $_SESSION['student_lname'],
                        "student_photo" => $_SESSION["student_photo"]
                    ]);
                    
                    echo json_encode(["success" => "true"]);
                    return true;
                } else {
                    $_POST['student_photo'] = $_SESSION['student_photo'];
                    $this->studentModel->updateProfile($_POST);
                    $this->userModel->updateEmail($_POST['user_email'], $_SESSION['user_id']);
                    $getInfo = $this->studentModel->getByUserID($_SESSION['user_id']);
                    foreach ($getInfo as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
    
                    $this->pusher->trigger('myProfile-' . $_SESSION['user_id'], 'update', [
                        "success" => "student",
                        "student_name" => substr($_SESSION['student_fname'] . " " . $_SESSION['student_lname'], 0, 19) . "<br>" . substr($_SESSION['student_fname'] . " " . $_SESSION['student_lname'], 19),
                        "student_name_plain" => $_SESSION['student_fname'] . " " . $_SESSION['student_lname'],
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

    public function linkage_and_partners()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('student/linkage_and_partners');
    }

    public function getLinkageAndPartners()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->linkageModel->getAll();

        echo json_encode(["data" => $list]);
    }

    public function institutional_membership()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('student/institutional_membership');
    }

    public function getInstitutionalMemberships()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->institutionalMembershipModel->getAll();

        echo json_encode(["data" => $list]);
    }

    public function ojt_partners()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }
        loadView('head');
        loadView('student/ojt_partners');
    }

    public function getOJTPartners()
    {
        if ($this->role != 'student') {
            header("Location: /logout");
        }

        header("Content-Type: application/json");
        $list = $this->OJTPartnerModel->getAll();

        echo json_encode(["data" => $list]);
    }
}
