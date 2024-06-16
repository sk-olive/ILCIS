<?php
class PartnerModel extends BaseModel
{
    protected $table = 'tbl_partners';

    public function getByUserID($user_id)
    {
        $query = "SELECT u.user_email, p.* FROM $this->table p INNER JOIN tbl_users u ON p.user_id = u.user_id WHERE p.user_id = ?";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getAllPartners()
    {
        $query = "SELECT u.user_id, u.user_email, p.partner_name, p.partner_address FROM $this->table p INNER JOIN tbl_users u ON p.user_id = u.user_id WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByPartnerID($partner_id)
    {
        $query = "SELECT p.*, u.user_email FROM $this->table p INNER JOIN tbl_users u ON p.user_id = u.user_id WHERE p.partner_id = ?";
        $params = array("i", $partner_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getPartners()
    {
        $query = "SELECT u.user_email, p.* FROM $this->table p INNER JOIN tbl_users u ON p.user_id = u.user_id WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalPartners()
    {
        $query = "SELECT COUNT(*) as total_partners FROM $this->table WHERE ?";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc()['total_partners'];
    }

    public function createPartner($data, $user_id)
    {
        extract($data);
        $query = "INSERT INTO $this->table (user_id, partner_name, partner_address, partner_contact, partner_position, partner_telephone, partner_person) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array("issssss", $user_id, $partner_name, $partner_address, $partner_contact, $partner_position, $partner_telephone, $partner_person);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updatePartner($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET partner_telephone = ?, partner_person = ? partner_name = ?, partner_address = ?, partner_contact = ?, partner_position = ? WHERE user_id = ?";
        $params = array("ssssssi", $partner_telephone, $partner_person, $partner_name, $partner_address, $partner_contact, $partner_position, $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
    public function deletePartner($user_id)
    {
        $query = "DELETE FROM $this->table WHERE user_id = ?";
        $params = array("i", $user_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateProfile($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET partner_person = ?, partner_photo = ?, partner_name = ?, partner_address = ?, partner_contact = ?, partner_position = ?, partner_telephone = ? WHERE user_id = ?";
        $params = array("sssssssi", $partner_person, $partner_photo, $partner_name, $partner_address, $partner_contact, $partner_position, $partner_telephone, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
