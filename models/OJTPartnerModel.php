<?php
class OJTPartnerModel extends BaseModel
{
    protected $table = 'tbl_ojt_partners';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY ojt_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($ojt_id)
    {
        $query = "SELECT * FROM $this->table WHERE ojt_id = ?";
        $params = array("i", $ojt_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createOJTPartner($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (ojt_name, ojt_photo, ojt_link) VALUES (?, ?, ?)";
        $params = array("sss", $ojt_name, $ojt_photo, $ojt_link);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateOJTPartner($data)
    {
        extract($data);
        if($ojt_photo != '') {
            $x = "ojt_photo = ?,";
            $params = array("sssi", $ojt_name, $ojt_photo, $ojt_link, $ojt_id);
        } else {
            $x = 'ojt_photo = ojt_photo,';
            $params = array("ssi", $ojt_name, $ojt_link, $ojt_id);
        }
        $query = "UPDATE $this->table SET ojt_name = ?, " . $x . " ojt_link = ? WHERE ojt_id = ?";
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteOJTPartner($ojt_id)
    {
        $query = "DELETE FROM $this->table WHERE ojt_id = ?";
        $params = array("i", $ojt_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
