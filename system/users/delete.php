<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE users, employee FROM users INNER JOIN employee ON users.UserId = employee.UserId WHERE users.UserId = '$userid'";
    $db->query($sql); 
    header("Location:manage.php");
}
