<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_db";
define('Host', $_SERVER['HTTP_HOST'].'/expense-manager/production/');
// jelanucyj@mailinator.com
// Pa$$w0rd!
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
