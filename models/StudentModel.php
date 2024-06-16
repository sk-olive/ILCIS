<?php
class StudentModel extends BaseModel
{
    protected $table = 'tbl_students';

    public function getByUserID($user_id)
    {
        $query = "SELECT u.user_email, s.* FROM $this->table s INNER JOIN tbl_users u ON s.user_id = u.user_id WHERE s.user_id = ?";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getByStudentID($student_id)
    {
        $query = "SELECT * FROM $this->table WHERE student_id = ?";
        $params = array("i", $student_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getStudents()
    {
        $query = "SELECT u.user_email, s.* FROM $this->table s INNER JOIN tbl_users u ON s.user_id = u.user_id WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllStudents()
    {
        $query = "SELECT u.user_id, u.user_email, s.student_number, CONCAT(s.student_fname, ' ', s.student_lname) as student_name FROM $this->table s INNER JOIN tbl_users u ON s.user_id = u.user_id WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalStudents()
    {
        $query = "SELECT COUNT(*) as total_students FROM $this->table WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc()['total_students'];
    }

    public function createStudent($data, $user_id)
    {
        extract($data);
        $query = "INSERT INTO $this->table (user_id, student_fname, student_lname, student_number, student_birthday, student_gender, student_course) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array("issssss", $user_id, $student_fname, $student_lname, $student_number, $student_birthday, $student_gender, $student_course);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateStudent($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET student_fname = ?, student_lname = ?, student_number = ?, student_birthday = ?, student_gender = ?, student_course = ? WHERE user_id = ?";
        $params = array("ssssssi", $student_fname, $student_lname, $student_number, $student_birthday, $student_gender, $student_course, $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
    public function deleteStudent($user_id)
    {
        $query = "DELETE FROM $this->table WHERE user_id = ?";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateProfile($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET student_photo = ?, student_fname = ?, student_lname = ?, student_number = ?, student_birthday = ?, student_gender = ?, student_course = ? WHERE user_id = ?";
        $params = array("sssssssi", $student_photo, $student_fname, $student_lname, $student_number, $student_birthday, $student_gender, $student_course, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
