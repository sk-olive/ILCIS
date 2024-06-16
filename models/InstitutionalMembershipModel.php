<?php
class InstitutionalMembershipModel extends BaseModel
{
    protected $table = 'tbl_institutional_membership';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY institutional_membership_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($institutional_membership_id)
    {
        $query = "SELECT * FROM $this->table WHERE institutional_membership_id = ?";
        $params = array("i", $institutional_membership_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createInstitutionalMembership($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (institutional_membership_name, institutional_membership_photo, institutional_membership_link) VALUES (?, ?, ?)";
        $params = array("sss", $institutional_membership_name, $institutional_membership_photo, $institutional_membership_link);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateInstitutionalMembership($data)
    {
        extract($data);
        if($institutional_membership_photo != '') {
            $x = "institutional_membership_photo = ?,";
            $params = array("sssi", $institutional_membership_name, $institutional_membership_photo, $institutional_membership_link, $institutional_membership_id);
        } else {
            $x = 'institutional_membership_photo = institutional_membership_photo,';
            $params = array("ssi", $institutional_membership_name, $institutional_membership_link, $institutional_membership_id);
        }
        $query = "UPDATE $this->table SET institutional_membership_name = ?, " . $x . " institutional_membership_link = ? WHERE institutional_membership_id = ?";
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteInstitutionalMembership($institutional_membership_id)
    {
        $query = "DELETE FROM $this->table WHERE institutional_membership_id = ?";
        $params = array("i", $institutional_membership_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
