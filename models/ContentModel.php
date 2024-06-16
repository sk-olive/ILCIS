<?php
class ContentModel extends BaseModel
{
    protected $table = 'tbl_content';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY content_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($content_id)
    {
        $query = "SELECT * FROM $this->table WHERE content_id = ?";
        $params = array("i", $content_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getByID1($content_id)
    {
        $query = "SELECT * FROM $this->table WHERE content_id = ? AND content_status = 'published'";
        $params = array("i", $content_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getAnnouncements()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status <> ? ORDER BY content_date DESC";
        $params = array("ss", "announcement", "for approval");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEvents()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status <> ? ORDER BY content_date DESC";
        $params = array("ss", "events", "for approval");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNews()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status <> ? ORDER BY content_date DESC";
        $params = array("ss", "news", "for approval");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDashboardAnnouncements()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status = ? ORDER BY content_date DESC LIMIT 3";
        $params = array("ss", "announcement", "published");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDashboardEvents()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status = ? ORDER BY content_date DESC LIMIT 3";
        $params = array("ss", "events", "published");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDashboardNews()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_status = ? ORDER BY content_date DESC LIMIT 3";
        $params = array("ss", "news", "published");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAnnouncementsPartner()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_author = '" . $_SESSION['partner_name'] . "'";
        $params = array("s", "announcement");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventsPartner()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_author = '" . $_SESSION['partner_name'] . "'";
        $params = array("s", "events");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNewsPartner()
    {
        $query = "SELECT * FROM $this->table WHERE content_type = ? AND content_author = '" . $_SESSION['partner_name'] . "'";
        $params = array("s", "news");
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getForApprovals()
    {
        $query = "SELECT * FROM $this->table WHERE content_status = ?";
        $params = array("s", 'for approval');
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createContent($data)
    {
        extract($data);
        if($_SESSION['user_role'] == 'partner') {
            $content_status = 'for approval';
            $content_author = $_SESSION['partner_name'];
        } else {
            $content_author = 'Admin';
        }
        $query = "INSERT INTO $this->table (content_author, content_title, content_content, content_date, content_type, content_status, content_photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array("sssssss", $content_author, $content_title, $content_content, $content_date, $content_type, $content_status, $content_photo);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateContent($data)
    {
        extract($data);
        if ($content_photo != '') {
            if(isset($content_status)) {
                $x = "content_status = ?, content_photo = ?";
                $params = array("sssssi", $content_title, $content_content, $content_date, $content_status, $content_photo, $content_id);
            } else {
                $x = "content_status = content_status, content_photo = ?";
                $params = array("ssssi", $content_title, $content_content, $content_date, $content_photo, $content_id);
            }
            
        } else {
            if(isset($content_status)) {
                $x = "content_status = ?, content_photo = content_photo";
                $params = array("ssssi", $content_title, $content_content, $content_date, $content_status, $content_id);
            } else {
                $x = "content_status = content_status, content_photo = content_photo";
                $params = array("sssi", $content_title, $content_content, $content_date, $content_id);
            }
        }
        $query = "UPDATE $this->table SET content_title = ?, content_content = ?, content_date = ?, " . $x . " WHERE content_id = ?";
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteContent($content_id)
    {
        $query = "DELETE FROM $this->table WHERE content_id = ?";
        $params = array("i", $content_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function approveContent($content_id)
    {
        $query = "UPDATE $this->table SET content_status = 'published' WHERE content_id = ?";
        $params = array("i", $content_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
