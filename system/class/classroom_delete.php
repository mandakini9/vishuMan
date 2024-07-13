<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE * FROM halls  WHERE halls.Id = '$hallid'";
    $db->query($sql); 
    header("Location:classhall_manage.php");
}
