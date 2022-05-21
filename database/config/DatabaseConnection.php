<?php

class DatabaseConnection
{
    public function __construct()
    {
        try {
            $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

            if($conn->connect_error) {
                throw new Exception(die ('Database connection failed ' . $conn->connect_error));
            }
            return $this->conn = $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>