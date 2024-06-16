<?php
class BaseModel
{
    protected $db;
    protected $transactionStarted;

    public function __construct()
    {
        $this->db = $this->connect();
        $this->transactionStarted = false;
    }

    private function connect()
    {
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbname = "db_ilcis";

        $db = new mysqli($host, $user, $password, $dbname);

        if ($db->connect_error) {
            error_log("Connection failed: " . $db->connect_error);
            throw new Exception("Database connection failed");
        }

        return $db;
    }

    public function startTransaction()
    {
        if (!$this->transactionStarted) {
            $this->db->begin_transaction();
            $this->transactionStarted = true;
        }
    }

    public function commit()
    {
        if ($this->transactionStarted) {
            if (!$this->db->commit()) {
                throw new Exception("Failed to commit transaction");
            }
            $this->transactionStarted = false;
        }
    }

    public function rollback()
    {
        if ($this->transactionStarted) {
            $this->db->rollback();
            $this->transactionStarted = false;
        }
    }

    public function __destruct()
    {
        if ($this->db) {
            if ($this->transactionStarted) {
                $this->rollback();
            }
            $this->db->close();
        }
    }

    public function queryBuilderMultiple($query, $params)
    {
        $this->startTransaction();
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(...$params);
        if ($stmt->execute()) {
            $this->commit();
            return $stmt->get_result();
        } else {
            $this->rollback();
            throw new Exception("Failed to execute query: " . $stmt->error);
        }
    }

    public function queryBuilder($query, $params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(...$params);
        if ($stmt->execute()) {
            if (strpos($query, 'INSERT') === 0) {
                return $this->db->insert_id;
            } elseif(strpos($query, 'UPDATE') === 0 || strpos($query, 'DELETE') === 0) {
                return $this->db->affected_rows;
            } else {
                return $stmt->get_result();
            }
        } else {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }
    }
}
