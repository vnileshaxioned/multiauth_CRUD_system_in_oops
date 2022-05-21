<?php

class Validate
{
    public function validateInput($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    public function fieldRequired($data)
    {
        if (empty($data)) {
            return "Field is required";
        }
    }

    public function validateFormat($pattern, $data, $message)
    {
        if (!preg_match($pattern, $data)) {
            return $message;
        }
    }

    public function checkPass($pass, $cpass)
    {
        if ($pass !== $cpass) {
            return "Password not match";
        } elseif (!preg_match("/^\S*(?=\S*[A-Z])(?=\S*[a-z])(?=\S*[0-9])(?=\S*[@$])\S*$/", $pass)) {
            return "Uppercase, lowercase, numbers and @, $ characters needed";
        } else {
            if (strlen($pass) <= 6) {
                return "Password must be greater than 6 characters";
            }
        }
    }

    public function phoneNumber($data)
    {
        if (!preg_match("/^[6-9]+[0-9]*$/", $data)) {
            return "Only numbers are allowed and start with 6,7,8 and 9";
        } else {
            if (strlen($data) != 10) {
                return "maximum 10 digits are allowed";
            }
        }
    }

    public function checkFile($size, $type)
    {
        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png' && $type != '') {
            return "File should be in jpg, jpeg and png format allowed";
        } else {
            if ($size > 1000000) {
                return "File is less than or equal to 1mb are allowed";
            }
        }
    }
}

$validate = new Validate;

?>