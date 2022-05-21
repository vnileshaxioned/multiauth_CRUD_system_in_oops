<?php
session_start();
require_once('../model/User.php');
require_once('../model/Validate.php');

$name = $email = $phone_num = $gender = '';

if (isset($_POST['user_register'])) {
    $name = $validate->validateInput($_POST['name']);
    $email = $validate->validateInput($_POST['email']);
    $phone_num = $validate->validateInput($_POST['phone_num']);
    $gender = $validate->validateInput($_POST['gender']);
    $pass = $validate->validateInput($_POST['pass']);
    $cpass = $validate->validateInput($_POST['c_pass']);
    $f_name = $validate->validateInput($_FILES['file']['name']);
    $f_size = $validate->validateInput($_FILES['file']['size']);
    $type = $validate->validateInput(strtolower(pathinfo($f_name,PATHINFO_EXTENSION)));
    $temp_name = $validate->validateInput($_FILES['file']['tmp_name']);
    $role = $validate->validateInput('user');
    $path = "../assets/upload/".$f_name;
    
    $name_error = $validate->fieldRequired($name);
    $email_error = $validate->fieldRequired($email);
    $phone_num_error = $validate->fieldRequired($phone_num);
    $gender_error = $validate->fieldRequired($gender);
    $pass_error = $validate->fieldRequired($pass);
    $cpass_error = $validate->fieldRequired($cpass);
    $name_check = $validate->validateFormat("/^[a-zA-Z ]*$/", $name, "only characters are allowed");
    $email_check = $validate->validateFormat("/^[a-z0-9\.]+@[a-z]+\.(\S*[a-z])$/", $email, "Invalid email format");
    $phone_num_check = $validate->phoneNumber($phone_num);
    $check_pass = $validate->checkPass($pass, $cpass);
    $check_file = $validate->checkFile($f_size, $type);
    $password_encrypt = sha1($pass);

    $name_check_error = $name_error ? $name_error : $name_check;
    $email_check_error = $email_error ? $email_error : $email_check;
    $phone_error = $phone_num_error ? $phone_num_error : $phone_num_check;
    $password_error = $pass_error ? $pass_error : $check_pass;
    $confirm_password_error = $cpass_error ? $cpass_error : $check_pass;
    $error = "name=$name_check_error&email=$email_check_error&phone_number=$phone_error&gender=$gender_error&password=$password_error&confirm_password=$confirm_password_error&file=$check_file";
    
    try {
        if (!($name_error
        || $email_error
        || $email_check
        || $phone_num_error
        || $phone_num_check
        || $gender_error
        || $pass_error
        || $cpass_error
        || $check_pass
        || $check_file)) {
            $email_exist = $userData->userDetails('users', 's', 'email', $email);
            if ($email_exist) {
                throw new Exception ("Email already exist");
            } else {
                $values = array($name, $email, $phone_num, $gender, $password_encrypt, $f_name, $role);
                $columns = array('name', 'email', 'phone_number', 'gender', 'password', 'profile_image', 'role');
                $insert_data = $userData->insertQuery('users', 'sssssss', $values, $columns);
                if ($insert_data) {
                    if (!file_exists('../assets/upload/')) {
                        mkdir('../assets/upload/', 0777);
                        $moved = move_uploaded_file($temp_name, $path);
                    } else {
                        $moved = move_uploaded_file($temp_name, $path);
                    }
                    $userData->redirect("Registration successful", "login.php");
                } else {
                    throw new Exception ("User detail not inserted");
                }
            }
        } else {
            throw new Exception ("");
        }
    } catch (Exception $e) {
        $userData->redirect($e->getMessage(), "register.php?$error");
    }
}

if (isset($_POST['user_login'])) {
    $email = $validate->validateInput($_POST['email']);
    $password = $validate->validateInput($_POST['pass']);
    
    $email_error = $validate->fieldRequired($email);
    $pass_error = $validate->fieldRequired($password);
    $error = "email=$email_error&password=$pass_error";
    try {
        if (!($email_error || $pass_error)) {
            $columns = array('email', 'password');
            $values = array($email, sha1($password));
            $user = $userData->userDetails('users', 'ss', $columns, $values);
            if ($user) {
                $_SESSION['id'] = $user['id'];
                if (!empty($validate->validateInput($_POST['remember']))) {
                    setcookie('email', $email, time() + 60 * 60);
                    setcookie('password', $password, time() + 60 * 60);
                    $userData->redirect('', "index.php");
                } else {
                    if (isset($_COOKIE['email'])) {
                        setcookie('email', $email, time() - 60 * 60);
                        if (isset($_COOKIE['password'])) {
                            setcookie('password', $password, time() - 60 * 60);
                        }
                    }
                    $userData->redirect('', "index.php");
                }
            } else {
                throw new Exception("Invalid email and password");
            }
        } else {
            $userData->redirect("", "login.php?$error");
        }
    } catch (Exception $e) {
        $userData->redirect($e->getMessage(), "login.php");
    }
}

if (isset($_POST['user_update'])) {
    $id = $validate->validateInput($_POST['user_id']);
    $name = $validate->validateInput($_POST['name']);
    $email = $validate->validateInput($_POST['email']);
    $phone_num = $validate->validateInput($_POST['phone_number']);
    $gender = $validate->validateInput($_POST['gender']);
    $page = $validate->validateInput($_POST['page']);

    $file_name = $validate->validateInput($_FILES['file']['name']);
    $file_size = $validate->validateInput($_FILES['file']['size']);
    $type = $validate->validateInput(strtolower(pathinfo($file_name,PATHINFO_EXTENSION)));
    $temp_name = $validate->validateInput($_FILES['file']['tmp_name']);
    $path = "../assets/upload/".$file_name;
    try {
        $check_file = $validate->checkFile($file_size, $type);
        $name_error = $validate->fieldRequired($name);
        $email_error = $validate->fieldRequired($email);
        $phone_num_error = $validate->fieldRequired($phone_num);
        $gender_error = $validate->fieldRequired($gender);
        $name_check = $validate->validateFormat("/^[a-zA-Z ]*$/", $name, "only characters are allowed");
        $email_check = $validate->validateFormat("/^[a-z0-9\.]+@[a-z]+\.(\S*[a-z])$/", $email, "Invalid email format");
        $phone_num_check = $validate->phoneNumber($phone_num);
        $name_check_error = $name_error ? $name_error : $name_check;
        $phone_error = $phone_num_error ? $phone_num_error : $phone_num_check;
        $error = "name=$name_check_error&phone_number=$phone_error&gender=$gender_error&file=$check_file";
        if (!($name_error
        || $name_check
        || $email_error
        || $email_check
        || $phone_num_error
        || $phone_num_check
        || $gender_error
        || $check_file)) {

            $email_exist = $userData->userDetails('users', 's', 'email', $email);
            $f_name = $email_exist['profile_image'];

            if ($email_exist) {
                if ($file_name != '') {
                    if ($userData->updateUser('users', '', '',$name, $email, $phone_num, $gender, $file_name, $id)) {
                        if (!file_exists('../assets/upload/')) {
                            mkdir('../assets/upload/', 0777);
                            $moved = move_uploaded_file($temp_name, $path);
                        } else {
                            $moved = move_uploaded_file($temp_name, $path);
                        }
                        if ($page == 'user_list') {
                            $userData->redirect("Update successful", "user_list.php");
                        } else {
                            $userData->redirect("Update successful", "account.php");
                        }
                    } else {
                        throw new Exception ("User detail ok not updated");
                    }
                } else {
                    if ($userData->updateUser('users', '', '',$name, $email, $phone_num, $gender, $f_name, $id)) {
                        if ($page == 'user_list') {
                            $userData->redirect("Update successful", "user_list.php");
                        } else {
                            $userData->redirect("Update successful", "account.php");
                        }
                    } else {
                        throw new Exception ("User detail not updated");
                    }
                }
            } else {
                throw new Exception ("You are not allow to change email");
            }
        } else {
            if ($page == 'user_list') {
                $userData->redirect("", "edit_user.php?id=$id&$error");
            } else {
                $userData->redirect("", "edit_profile.php?id=$id&$error");
            }
        }
    } catch (Exception $e) {
        if ($page == 'user_list') {
            $userData->redirect($e->getMessage(), "edit_user.php?id=$id");
        } else {
            $userData->redirect($e->getMessage(), "edit_profile.php?id=$id");
        }
    }
}

if (isset($_POST['password_update'])) {
    $id = $validate->validateInput($_POST['user_id']);
    $current_password = $validate->validateInput($_POST['current_password']);
    $new_password = $validate->validateInput($_POST['new_password']);
    $confirm_password = $validate->validateInput($_POST['confirm_password']);
    $password_encrypt = sha1($current_password);

    $current_password_error = $validate->fieldRequired($current_password);
    $new_password_error = $validate->fieldRequired($new_password);
    $confirm_password_error = $validate->fieldRequired($confirm_password);
    $check_password = $validate->checkPass($new_password, $confirm_password);
    $new_error = $new_password_error ? $new_password_error : $check_password;
    $confirm_error = $confirm_password_error ? $confirm_password_error : $check_password;
    $error = "current=$current_password_error&new=$new_error&confirm=$confirm_error";
    try {
        if (!($current_password_error
            ||$new_password_error
            ||$confirm_password_error
            ||$check_password)) {
            
            $columns = array('password', 'id');
            $values = array($password_encrypt, $id);
            $password_exist = $userData->userDetails('users', 'si', $columns, $values);
            
            if ($password_exist) {
                if ($userData->updateUser('users', $id, $new_password, '')) {
                    if (session_destroy()) {
                        $userData->redirect("Login again with new password", "login.php");
                    }
                } else {
                    throw new Exception ("User password not updated");
                }
            } else {
                throw new Exception ("Current password is wrong");
            }
        } else {
            $userData->redirect("", "edit_password.php?id=$id&$error");
        }
    } catch (Exception $e) {
        $userData->redirect($e->getMessage(), "edit_password.php?id=$id");
    }
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        if ($userData->deleteQuery('users', $id)) {
            $userData->redirect("User deleted successful", "user_list.php");
        } else {
            throw new Exception ("User not deleted");
        }
    } catch (Exception $e) {
        $userData->redirect($e->getMessage(), "user_list.php");
    }
}

if (isset($_POST['user_logout'])) {
    session_destroy();
    $userData->redirect("Logout Successful", "login.php");
}

?>