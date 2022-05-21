<?php

require_once('DatabaseConnection.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'phpmyadmin');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'multiauth_system');

$db = new DatabaseConnection;

?>