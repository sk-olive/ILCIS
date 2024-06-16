<?php
class InquiryModel extends BaseModel
{
    protected $table = 'tbl_inquiry', $table1 = 'tbl_inquiry1';

    public function getAll()
    {
        $query = "SELECT u.user_email, COALESCE(p.partner_name, CONCAT(s.student_fname, ' ', s.student_lname)) AS inquiry_name, i.inquiry_id, i.inquiry_subject, i.inquiry_message FROM tbl_inquiry i LEFT JOIN tbl_users u ON u.user_id = i.user_id LEFT JOIN tbl_partners p ON p.user_id = i.user_id LEFT JOIN tbl_students s ON s.user_id = i.user_id WHERE ?;";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll1()
    {
        $query = "SELECT * FROM $this->table1 WHERE ?;";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUserID($user_id)
    {
        $query = "SELECT u.user_email, COALESCE(p.partner_name, CONCAT(s.student_fname, ' ', s.student_lname)) AS inquiry_name, i.inquiry_id, i.inquiry_subject, i.inquiry_message FROM tbl_inquiry i LEFT JOIN tbl_users u ON u.user_id = i.user_id LEFT JOIN tbl_partners p ON p.user_id = i.user_id LEFT JOIN tbl_students s ON s.user_id = i.user_id WHERE u.user_id = ?;";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createInquiry($user_id, $inquiry_subject, $inquiry_message)
    {
        $query = "INSERT INTO $this->table (user_id, inquiry_subject, inquiry_message) VALUES (?, ?, ?)";
        $params = array("iss", $user_id, $inquiry_subject, $inquiry_message);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function createInquiry1($inquiry_name, $inquiry_email, $inquiry_subject, $inquiry_message)
    {
        $query = "INSERT INTO $this->table1 (inquiry_name, inquiry_email, inquiry_subject, inquiry_message) VALUES (?, ?, ?, ?)";
        $params = array("ssss", $inquiry_name, $inquiry_email, $inquiry_subject, $inquiry_message);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteInquiry($inquiry_id)
    {
        $query = "DELETE FROM $this->table WHERE inquiry_id = ?";
        $params = array("i", $inquiry_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteInquiry1($inquiry_id)
    {
        $query = "DELETE FROM $this->table1 WHERE inquiry_id = ?";
        $params = array("i", $inquiry_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
