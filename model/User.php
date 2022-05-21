<?php

require_once('../database/config/config.php');

class User
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function notLogin($session)
    {
        if (!isset($_SESSION["$session"])) {
            header('Location: login.php');
        }
    }

    public function isLogin($session)
    {
        if (isset($_SESSION["$session"])) {
            header('Location: index.php');
        }
    }

    public function insertQuery($table, $type, $values, $columns)
    {
        if ($columns) {
            $question_tag = array();
            foreach ($columns as $column) {
                $question_tag[] = "?";
            }
            $columns = implode(", ", $columns);
            $question_tag = implode(", ", $question_tag);
            $query = $this->conn->prepare("INSERT INTO $table ($columns) VALUES ($question_tag)");
            $query->bind_param($type, ...$values);
            return $query->execute();
        } else {
            return false;
        }
    }

    public function updateUser($table, $id = '', $password = '', ...$columns)
    {
        if ($password) {
            $query = $this->conn->prepare("UPDATE $table SET password = ? WHERE id = ?");
            $query->bind_param('si', sha1($password), $id);
            return $query->execute();
        } else {
            $query = $this->conn->prepare("UPDATE $table SET name = ?, email = ?, phone_number = ?, gender = ?, profile_image = ? WHERE id = ?");
            $query->bind_param('sssssi', ...$columns);
            return $query->execute();
        }
    }

    public function userDetails($table, $type = '', $columns = '', $values = '')
    {
        if ($values) {
        if (is_array($columns)) {
            foreach ($columns as $column) {
                $conditions[] = "$column = ?";
            }
            $conditions = implode(" AND ", $conditions);
        } else {
            $conditions = "$columns = ?";
        }
        $query = $this->conn->prepare("SELECT * FROM $table WHERE $conditions");
        if (is_array($values)) {
            $query->bind_param($type, ...$values);
        } else {
            $query->bind_param($type, $values);
        }
        $query->execute();
        return $query->get_result()->fetch_assoc();
        } else {
            $user = $this->conn->query("SELECT * FROM $table");
            if ($user->num_rows >0) {
                return $user;
            } else {
                return false;
            }
        }
    }

    public function deleteQuery($table, $id)
    {
        $query = $this->conn->prepare("DELETE FROM $table WHERE id = ?");
        $query->bind_param('i', $id);
        return $query->execute();
    }

    public function redirect($message = '', $redirectTo)
    {
        $_SESSION['message'] = "$message";
        header("Location: $redirectTo");
        exit(0);
    }
}

$userData = new User;
?>