<?php
class AppointmentModel extends BaseModel
{
    protected $table = 'tbl_appointments';

    public function getAll()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY appointment_id DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll1()
    {
        $query = "SELECT * FROM $this->table WHERE ? ORDER BY appointment_date_time DESC";
        $params = array("i", 1);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll2()
    {
        $query = "SELECT * FROM $this->table WHERE appointment_contact_person = ? ORDER BY appointment_date_time DESC";
        $params = array("s", $_SESSION['partner_person']);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByID($appointment_id)
    {
        $query = "SELECT * FROM $this->table WHERE appointment_id = ?";
        $params = array("i", $appointment_id);
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function createAppointment($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (appointment_contact_person, appointment_position, appointment_company_name, appointment_company_address, appointment_phone_number, appointment_email, appointment_date_time, appointment_message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array("ssssssss", $appointment_contact_person, $appointment_position, $appointment_company_name, $appointment_company_address, $appointment_phone_number, $appointment_email, $appointment_date_time, $appointment_message);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateAppointment($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET appointment_contact_person = ?, appointment_position = ?, appointment_company_name = ?, appointment_company_address = ?, appointment_phone_number = ?, appointment_email = ?, appointment_date_time = ?, appointment_message = ? WHERE appointment_id = ?";
        $params = array("ssssssssi", $appointment_contact_person, $appointment_position, $appointment_company_name, $appointment_company_address, $appointment_phone_number, $appointment_email, $appointment_date_time, $appointment_message, $appointment_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteAppointment($data)
    {
        extract($data);
        $query = "DELETE FROM $this->table WHERE appointment_id = ?";
        $params = array("i", $appointment_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updateStatus($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET appointment_status = ? WHERE appointment_id = ?";
        $params = array("si", $appointment_status, $appointment_id);
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
