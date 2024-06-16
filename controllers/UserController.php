<?php
session_start();

class UserController
{
    private $userModel, $studentModel, $partnerModel, $requestMethod, $role, $contentModel, $expertModel, $forgotPasswordModel, $inquiryModel, $options, $pusher;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->studentModel = new StudentModel();
        $this->partnerModel = new PartnerModel();
        $this->contentModel = new ContentModel();
        $this->expertModel = new ExpertModel();
        $this->inquiryModel = new InquiryModel();
        $this->forgotPasswordModel = new ForgotPasswordModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

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
        loadView('index');
    }

    public function about()
    {
        loadView('head');
        loadView('about');
    }

    public function partnership()
    {
        loadView('head');
        loadView('partnership');
    }

    public function news()
    {
        $data = ["news" => $this->contentModel->getNews()];

        loadView('head');
        loadView('news', $data);
    }

    public function news_content($content_id)
    {
        loadView('head');
        loadView('news_content', ["content" => $this->contentModel->getByID1($content_id)]);
    }

    public function event_content($content_id)
    {
        loadView('head');
        loadView('event_content', ["content" => $this->contentModel->getByID1($content_id)]);
    }

    public function events()
    {
        $data = ["events" => $this->contentModel->getEvents()];

        loadView('head');
        loadView('events', $data);
    }

    public function pool_of_experts()
    {
        $data = ["pool_of_experts" => $this->expertModel->getAll()];

        loadView('head');
        loadView('pool_of_experts', $data);
    }

    public function login()
    {
        if ($this->requestMethod == 'POST') {
            extract($_POST);
            $user = $this->userModel->checkUserEmail($user_email, $user_role);
            // die(print_r($user, true));
            if ($user) {
                if (password_verify($user_password, $user['user_password'])) {
                    $_SESSION['user_role'] = $user['user_role'];

                    if ($user['user_role'] == 'student' || $user['user_role'] == 'partner') {
                        $model = $user['user_role'] == 'student' ? $this->studentModel : $this->partnerModel;
                        $user_info = $model->getByUserID($user['user_id']);
                        foreach ($user_info as $key => $value) {
                            $_SESSION[$key] = $value;
                        }
                    } elseif ($user['user_role'] != 'admin') {
                        echo json_encode(['success' => 'false']);
                        exit;
                    }

                    $_SESSION['user_email'] = $user['user_email'];
                    $_SESSION['user_id'] = $user['user_id'];
                    echo json_encode(['success' => 'true', 'message' => 'Logged in Successfully!']);
                    exit;
                }
            }
            echo json_encode(['success' => 'false', 'message' => 'Invalid username or password']);
            return false;
        } else {
            http_response_code(404);
            die("File not found.");
        }
    }

    public function register()
    {
        if ($this->requestMethod == 'POST') {
            $check = $this->userModel->checkDuplicate($_POST['user_email']);
            
            if($check['num_rows'] == 0) {
                $user = $this->userModel->register($_POST);

                if ($user > 0) {
                    if ($_POST['user_role'] == "student") {
                        $student = $this->studentModel->createStudent($_POST, $user);
                        if ($student > 0) {
                            echo json_encode(['success' => 'true']);
                            return true;
                        }
                    } elseif ($_POST['user_role'] == "partner") {
                        $student = $this->partnerModel->createPartner($_POST, $user);
                        if ($student > 0) {
                            echo json_encode(['success' => 'true']);
                            return true;
                        }
                    }
                }
            } else {
                echo json_encode(['success' => 'false', 'message' => 'Email already exists!']);
                return false;
            }

            echo json_encode(['success' => 'false', 'message' => "An error occurred while registering. Please contact the administrator."]);
            return false;
        } else {
            http_response_code(404);
            die("File not found.");
        }
    }

    public function reset_password()
    {
        if ($this->requestMethod == 'POST') {
            extract($_POST);
            $user = $this->userModel->checkUserEmail1($forgot_email);

            if ($user) {
                $send = $this->forgotPasswordModel->send($forgot_email);

                if($send) {
                    echo json_encode(['success' => 'true']);
                    return $user;
                } else {
                    echo json_encode(['success' => 'false', "message" => "There is an error in sending email."]);
                    return $user;
                }
            }

            echo json_encode(['success' => 'false', "message" => "No user with this email."]);
            return $user;
        }
    }

    public function reset()
    {
        $token = $_GET['token'];
        if($this->forgotPasswordModel->checkToken($token) > 0) {
            loadView('head');
            loadView('reset', ["token" => $token]);
        } else {
            header("Location: /logout");
        }
    }

    public function inquiry()
    {
        if ($this->requestMethod == 'POST') {
            $inquiry = $this->inquiryModel->createInquiry1($_POST['inquiry_name'], $_POST['inquiry_email'], $_POST['inquiry_subject'], $_POST['inquiry_message']);

            if($inquiry > 0) {
                echo json_encode(['success' => 'true']);
                $this->pusher->trigger('inquiry', 'update', ["success" => "true"]);
                return $inquiry;
            }

            echo json_encode(['success' => 'false']);
            return $inquiry;
        }
    }

    public function resetPass()
    {
        if ($this->requestMethod == 'POST') {
            $reset = $this->forgotPasswordModel->changePassword($_POST);

            if($reset) {
                echo json_encode(['success' => 'true']);
                return $reset;
            }

            echo json_encode(['success' => 'false']);
            return $reset;
        }
    }

    public function logout()
    {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params["domain"],
                $params["secure"],
                $params['httpOnly"]']
            );
        }

        session_destroy();
        header("Location: /");
        exit;
    }
}
