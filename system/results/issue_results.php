<?php
ob_start();
include_once '../init.php';
$db = dbConn();
extract($_POST);

foreach ($student_result as $key => $res) {
    $student_result = $res;
    $reg_no = $sregno[$key];
    $first_name = $fname[$key];
    $last_name = $lname[$key];
    
    $sql = "INSERT INTO `studentresults`( `ClassName`, `ExamName`, `SRegNo`, `FirstName`, `LastName`, `ExamMarks`) "
            . "VALUES ('$classname','$examname','$reg_no','$first_name','$last_name','$student_result')";
    $db->query($sql);
}

header("Location:resultadd.php");


?> 