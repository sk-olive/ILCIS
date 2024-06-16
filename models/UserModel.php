<?php
class UserModel extends BaseModel
{
    protected $table = 'tbl_users';

    public function getUser($id)
    {
        $query = "SELECT * FROM $this->table WHERE user_id = ?";
        $params = array("i", $id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function checkUserEmail($user_email, $user_role)
    {
        $query = "SELECT * FROM $this->table WHERE user_email = ? AND user_role = ?";
        $params = array("ss", $user_email, $user_role);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function checkUserEmail1($user_email)
    {
        $query = "SELECT * FROM $this->table WHERE user_email = ?";
        $params = array("s", $user_email);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getTotalAdmin()
    {
        $query = "SELECT COUNT(*) as total_admin FROM $this->table WHERE user_role = ?";
        $params = array("s", 'admin');
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc()['total_admin'];
    }

    public function register($data)
    {
        extract($data);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $query = "INSERT INTO $this->table (user_email, user_password, user_role) VALUES (?, ?, ?)";
        $params = array("sss", $user_email, $user_password, $user_role);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function checkDuplicate($user_email)
    {
        $query = "SELECT COUNT(*) as num_rows FROM $this->table WHERE user_email = ?";
        $params = array("s", $user_email);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function updateEmail($user_email, $user_id)
    {
        $query = "UPDATE $this->table SET user_email = ? WHERE user_id = ?";
        $params = array("si", $user_email, $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteUser($user_id)
    {
        $query = "DELETE FROM $this->table WHERE user_id = ?";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
