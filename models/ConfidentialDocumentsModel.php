<?php
class ConfidentialDocumentsModel extends BaseModel
{
    protected $table = 'tbl_confidential_documents';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY document_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($content_id)
    {
        $query = "SELECT * FROM $this->table WHERE document_id = ?";
        $params = array("i", $content_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getRequestFiles()
    {
        $query = "SELECT * FROM $this->table WHERE document_status = ? AND document_company = ?";
        $params = array("si", "Processing", $_SESSION['partner_name']);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRequestFilesAdmin()
    {
        $query = "SELECT * FROM $this->table WHERE document_status = ?";
        $params = array("s", "Processing");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFiles()
    {
        $query = "SELECT * FROM $this->table WHERE (document_status = ? OR document_status = ?)";
        $params = array("ss", "Denied", "Approved");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createRequestFile($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (document_type, document_file, document_status, document_company, document_uploaded_by) VALUES (?, ?, ?, ?, ?)";
        $params = array("ssssi", $document_type, $document_file, 'Processing', $document_company, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteFile($document_id)
    {
        $query = "DELETE FROM $this->table WHERE document_id = ? AND document_uploaded_by = ?";
        $params = array("ii", $document_id, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function approveRequest($document_id)
    {
        $query = "UPDATE $this->table SET document_status = 'Approved' WHERE document_id = ? AND document_uploaded_by <> ?";
        $params = array("ii", $document_id, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function denyRequest($document_id)
    {
        $query = "UPDATE $this->table SET document_status = 'Denied' WHERE document_id = ? AND document_uploaded_by <> ?";
        $params = array("ii", $document_id, $_SESSION['user_id']);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
