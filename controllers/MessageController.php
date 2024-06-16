<?php
session_start();
require 'vendor/autoload.php';

class MessageController
{
    private $requestMethod, $role, $options, $pusher, $userModel, $studentModel, $partnerModel, $chatModel;

    public function __construct()
    {   
        if (isset($_SESSION['user_role'])) {
            $this->role = $_SESSION['user_role'];
        } else {
            header("Location: /logout");
        }

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->userModel = new UserModel();
        $this->studentModel = new StudentModel();
        $this->partnerModel = new PartnerModel();
        $this->chatModel = new ChatModel();

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

    public function getRecepient($user_id)
    {
        $getInfo = $this->chatModel->getRecepient($user_id);
        $chat = $this->chatModel->getChat($_SESSION['user_id'], $user_id);

        if($this->role == 'admin') {
            // loadView('head');
            loadView('admin/chats', ["data" => $getInfo, "chat" => $chat]);
        } elseif($this->role == 'partner') {
            // loadView('head');
            loadView('partner/chats', ["data" => $getInfo, "chat" => $chat]);
        } elseif($this->role == 'student') {
            // loadView('head');
            loadView('student/chats', ["data" => $getInfo, "chat" => $chat]);
        } else {
            header("Location: /logout");
        }
    }

    public function getRecepientInfo($user_id)
    {
        $getInfo = $this->chatModel->getRecepient($user_id);

        return $getInfo[0];
    }

    public function sendMessage()
    {
        if($this->requestMethod == "POST") {
            header("Content-Type: application/json");
            if (isset($_FILES['chat_attachments']) && $_FILES['chat_attachments']['error'] != 4) {
                $file = $_FILES['chat_attachments'];

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo (json_encode(['success' => "false", "message" => 'File upload error: ' . $file['error']]));
                    return false;
                }

                $maxSize = 5 * 1024 * 1024;
                if ($file['size'] > $maxSize) {
                    echo (json_encode(["success" => "false", "message" => "The file is too large"]));
                    return false;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                $filename = str_replace(["../", "./"], "", $filename);

                $uploadDir = 'uploads/attachments/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    echo (json_encode(["success" => "false", "message" => "Failed to move uploaded file"]));
                    return false;
                }

                $_POST['chat_attachments'] = $uploadDir . $filename;
                $create = $this->chatModel->sendMessage($_POST);
                $name = ($this->getRecepientInfo($_SESSION['user_id'])['student_name'] !== NULL) ? $this->getRecepientInfo($_SESSION['user_id'])['student_name'] : (($this->getRecepientInfo($_SESSION['user_id'])['partner_name'] !== NULL) ? $this->getRecepientInfo($_SESSION['user_id'])['partner_name'] : 'Admin');
                $this->pusher->trigger('new_message-'.$this->getRecepientInfo($_POST['chat_to'])['user_id'], 'update', ["from" => $_SESSION['user_id'], "name" => $name, "message" => $_POST['chat_message'], "attachment" => $_POST['chat_attachments']]);
                echo json_encode(['attachment' => $_POST['chat_attachments']]);
            } else {
                $_POST['chat_attachments'] = '';
                $create = $this->chatModel->sendMessage($_POST);
                $name = ($this->getRecepientInfo($_SESSION['user_id'])['student_name'] !== NULL) ? $this->getRecepientInfo($_SESSION['user_id'])['student_name'] : (($this->getRecepientInfo($_SESSION['user_id'])['partner_name'] !== NULL) ? $this->getRecepientInfo($_SESSION['user_id'])['partner_name'] : 'Admin');
                echo json_encode(['attachment' => $_POST['chat_attachments']]);
                $this->pusher->trigger('new_message-'.$this->getRecepientInfo($_POST['chat_to'])['user_id'], 'update', ["from" => $_SESSION['user_id'], "name" => $name, "message" => $_POST['chat_message'], "attachment" => $_POST['chat_attachments']]);
            }

            return $create;
        }
    }

    /* start Partner Actions */

    public function getPartnerRecepients()
    {
        if($this->role != 'partner') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getPartnerRecepients();
        
        echo json_encode(["data" => $get]);
    }

    public function getPartnerRecepients1()
    {
        if($this->role != 'partner') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getPartnerRecepients1($_POST['search']);
        
        echo json_encode(["data" => $get]);
    }

    /* end Partner Actions */

    /* start Admin Actions */

    public function getAdminRecepients()
    {
        if($this->role != 'admin') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getAdminRecepients();
        
        echo json_encode(["data" => $get]);
    }

    public function getAdminRecepients1()
    {
        if($this->role != 'admin') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getAdminRecepients1($_POST['search']);
        
        echo json_encode(["data" => $get]);
    }

    /* end Admin Actions */

    /* start Student Actions */

    public function getStudentRecepients()
    {
        if($this->role != 'student') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getStudentRecepients();
        
        echo json_encode(["data" => $get]);
    }

    public function getStudentRecepients1()
    {
        if($this->role != 'student') {
            header("Location: /logout");
        }

        $get = $this->chatModel->getStudentRecepients1($_POST['search']);
        
        echo json_encode(["data" => $get]);
    }

    /* end Student Actions */

}
