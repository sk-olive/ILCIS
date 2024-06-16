<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordModel extends BaseModel
{
    public function send($email)
    {
        $token = md5(base64_encode(uniqid() . $email . uniqid()));
        $query = "INSERT INTO tbl_forgot_password (email, token) VALUES (?, ?)";
        $params = array("ss", $email, $token);
        $result = $this->queryBuilder($query, $params);
        $message = '
        <p>
        Dear User, <br><br>

        We have received a request to reset your password for your ILINK account. Your account security is important to us, and we are here to assist you in this process.<br><br>

        To reset your password, please follow the steps below: <br><br>

        Click on the following link to reset your password:<br>
        <a href="'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/".'reset?token=' . $token . '">Reset Password</a><br><br>

        If the link does not work, copy and paste it into your web browser\'s address bar.<br><br>

        You will be directed to a page where you can create a new password. <br><br>

        After creating your new password, you can use it to log in to your ILINK account. <br><br>

        If you did not request a password reset, please ignore this email, and your password will remain unchanged. Your account\'s security is important to us, and we take all necessary precautions to protect it. <br><br>

        Thank you for using ILINK!<br><br>

        Best regards,<br><br>

        ILINK System Administrator
        </p>
        ';

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
        $mail->Subject    = "Here is your reset password link!";
        $mail->Body       = $message;
        $mail->AddAddress($email);
        try {
            return $mail->Send();
        } catch (Exception $e) {
            die('Caught exception: ' . $e->getMessage() . "\n");
            return false;
        }
    }

    public function changePassword($data)
    {
        extract($data);
        $user_email = $this->getUserEmail($token);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $query = "UPDATE tbl_users SET user_password = ? WHERE user_email = ?";
        $params = array("ss", $user_password, $user_email);
        $result = $this->queryBuilder($query, $params);
        $this->deleteToken($token);
        return $result;
    }

    public function getUserEmail($token)
    {
        $query = "SELECT email FROM tbl_forgot_password WHERE token = ?";
        $params = array("s", $token);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc()['email'];
    }

    public function deleteToken($token)
    {
        $query = "DELETE FROM tbl_forgot_password WHERE token = ?";
        $params = array("s", $token);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function checkToken($token)
    {
        $query = "SELECT token FROM tbl_forgot_password WHERE token = ?";
        $params = array("s", $token);
        $result = $this->queryBuilder($query, $params);
        return $result->num_rows;
    }
}