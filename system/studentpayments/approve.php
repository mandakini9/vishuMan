<?php
ob_start();
include_once '../init.php';
include_once '../../mail.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
//    $db = dbConn();

//    $sql_email = "SELECT * FROM users u "
//            . "INNER JOIN teachers a ON a.UserId=u.UserId "
//            . "WHERE u.UserId='$userid'";
//
//    $result_email = $db->query($sql_email);
//    $row_email = $result_email->fetch_assoc();

//    $first_name = $row_email['FirstName'];
//    $email = $row_email['Email'];
    
    $db = dbConn();
    $sql_student = "SELECT SRegNo, cd.Id As ClassNo FROM students s "
            . "INNER JOIN classdetails cd ON s.GradeId = cd.GradeId "
            . "WHERE s.Id='$studentId' AND cd.ClassName = '$className'";
    $result_student = $db->query($sql_student);
    $row_student = $result_student->fetch_assoc();
    $sregno = $row_student['SRegNo'];
    $classid = $row_student['ClassNo'];
    $sql2 = "UPDATE `students` SET `status`='1' WHERE Id = '$studentId'";
    $db->query($sql2);
    $sql3 = "UPDATE `approvalpayments` SET `status`='1' WHERE ClassName = '$className'";
    $db->query($sql3);
    $sql4 = "INSERT INTO `classfees`(`StudentId`, `SRegNo`, `ClassName`, `PaidDate`, `TotalFee`) "
            . "VALUES ('$studentId','$sregno','$className',CURRENT_DATE,'$totalFee')";
    $db->query($sql4);
    $sql = "INSERT INTO registerstudents (`StudentId`, `SRegNo`, `ClassId`) "
            . "VALUES ('$studentId','$sregno','$classid')";
    $db->query($sql);

//    $msg = "<h1>SUCCESS</h1>";
//    $msg .= "<h2>Congratulations</h2>";
//    $msg .= "<p>Dear Teacher, Your account has been approved. You can now log in and start using our services.</p>";
//    $msg .= "<a href='http://localhost/IMS/system/teacherlogin.php'>Click here to Login your account</a>";
//    sendEmail($email, $first_name, "Account Approved", $msg);
  }
  $content = ob_get_clean();
  include '../layouts.php';
?>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Payment Approved',
                text: 'The Students\'s account has been successfully approved.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'registerstudents.php';
            });
        });
    </script>
