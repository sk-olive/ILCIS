<?php
class LinkageModel extends BaseModel
{
    protected $table = 'tbl_linkages';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY linkage_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($linkage_id)
    {
        $query = "SELECT * FROM $this->table WHERE linkage_id = ?";
        $params = array("i", $linkage_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createLinkage($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (linkage_name, linkage_photo, linkage_link) VALUES (?, ?, ?)";
        $params = array("sss", $linkage_name, $linkage_photo, $linkage_link);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateLinkage($data)
    {
        extract($data);
        if($linkage_photo != '') {
            $x = "linkage_photo = ?,";
            $params = array("sssi", $linkage_name, $linkage_photo, $linkage_link, $linkage_id);
        } else {
            $x = 'linkage_photo = linkage_photo,';
            $params = array("ssi", $linkage_name, $linkage_link, $linkage_id);
        }
        $query = "UPDATE $this->table SET linkage_name = ?, " . $x . " linkage_link = ? WHERE linkage_id = ?";
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteLinkage($linkage_id)
    {
        $query = "DELETE FROM $this->table WHERE linkage_id = ?";
        $params = array("i", $linkage_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
