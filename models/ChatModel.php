<?php
class ChatModel extends BaseModel
{

    public function getRecepient($user_id)
    {
        $query = "SELECT CONCAT(s.student_fname, ' ', s.student_lname) as student_name, p.partner_name, u.user_id, u.user_role FROM tbl_users u LEFT JOIN tbl_students s ON u.user_id = s.user_id LEFT JOIN tbl_partners p ON u.user_id = p.user_id WHERE u.user_id = ? LIMIT 1;";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChat($from, $to)
    {
        $query = "SELECT chat_from, chat_message, chat_attachments FROM tbl_chats WHERE (chat_from = ? AND chat_to = ?) OR (chat_from = ? AND chat_to = ?)";
        $params = array("iiii", $from, $to, $to, $from);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function sendMessage($data)
    {
        extract($data);

        if($chat_attachments == '') {
            $chat_attachments = NULL;
        }

        $query = "INSERT INTO tbl_chats (chat_from, chat_to, chat_message, chat_attachments) VALUES (?, ?, ?, ?)";
        $params = array("iiss", $chat_from, $chat_to, $chat_message, $chat_attachments);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    /* start Partner Actions */

    public function getPartnerRecepients()
    {
        $query = "SELECT s.student_photo, CONCAT(s.student_fname, ' ', s.student_lname) as student_name, u.user_id, u.user_role FROM tbl_users u LEFT JOIN tbl_students s ON u.user_id = s.user_id WHERE u.user_role != 'partner' AND ?;";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPartnerRecepients1($search)
    {
        $query = "SELECT s.student_photo, CONCAT(s.student_fname, ' ', s.student_lname) as student_name, u.user_id, u.user_role FROM tbl_users u LEFT JOIN tbl_students s ON u.user_id = s.user_id WHERE u.user_role != 'partner' AND CONCAT(s.student_fname, ' ', s.student_lname) LIKE ? AND s.student_photo IS NOT NULL;";
        $searchParam = "%" . $search . "%";
        $params = array("s", $searchParam);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* end Partner Actions */

    /* start Admin Actions */

    public function getAdminRecepients()
    {
        $query = "SELECT p.partner_photo, p.partner_name, s.student_photo, CONCAT(s.student_fname, ' ', s.student_lname) as student_name, u.user_id, u.user_role FROM tbl_users u LEFT JOIN tbl_students s ON u.user_id = s.user_id LEFT JOIN tbl_partners p ON u.user_id = p.user_id WHERE u.user_role != 'admin' AND (p.partner_name IS NOT NULL OR CONCAT(s.student_fname, ' ', s.student_lname) IS NOT NULL) AND ?;";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdminRecepients1($search)
    {
        $query = "SELECT p.partner_photo, p.partner_name, s.student_photo, CONCAT(s.student_fname, ' ', s.student_lname) as student_name, u.user_id, u.user_role FROM tbl_users u LEFT JOIN tbl_students s ON u.user_id = s.user_id LEFT JOIN tbl_partners p ON u.user_id = p.user_id WHERE u.user_role != 'admin' AND CONCAT(s.student_fname, ' ', s.student_lname) LIKE ? OR p.partner_name LIKE ? AND (p.partner_name IS NOT NULL OR CONCAT(s.student_fname, ' ', s.student_lname) IS NOT NULL);";
        $searchParam = "%" . $search . "%";
        $params = array("ss", $searchParam, $searchParam);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* end Admin Actions */

    /* start Admin Actions */

    public function getStudentRecepients()
    {
        $query = "SELECT user_id FROM tbl_users WHERE user_role = 'admin' AND ?;";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStudentRecepients1($search)
    {
        $query = "SELECT user_id FROM tbl_users WHERE user_role = ?;";
        // $searchParam = "%" . $search . "%";
        $params = array("s", 'admin');
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* end Admin Actions */
}