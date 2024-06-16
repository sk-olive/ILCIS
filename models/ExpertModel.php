<?php
class ExpertModel extends BaseModel
{
    protected $table = 'tbl_experts';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY expert_name DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($expert_id)
    {
        $query = "SELECT * FROM $this->table WHERE expert_id = ?";
        $params = array("i", $expert_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createExpert($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (expert_name, expert_department, expert_position, expert_contact) VALUES (?, ?, ?, ?)";
        $params = array("ssss", $expert_name, $expert_department, $expert_position, $expert_contact);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateExpert($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET expert_name = ?, expert_department = ?, expert_position = ?, expert_contact = ? WHERE expert_id = ?";
        $params = array("ssssi", $expert_name, $expert_department, $expert_position, $expert_contact,  $expert_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteExpert($expert_id)
    {
        $query = "DELETE FROM $this->table WHERE expert_id = ?";
        $params = array("i", $expert_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
