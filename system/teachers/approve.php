<?php
ob_start();
include_once '../init.php';
include_once '../../mail.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();

    $sql_email = "SELECT * FROM users u "
            . "INNER JOIN teachers a ON a.UserId=u.UserId "
            . "WHERE u.UserId='$userid'";

    $result_email = $db->query($sql_email);
    $row_email = $result_email->fetch_assoc();

    $first_name = $row_email['FirstName'];
    $email = $row_email['Email'];
    $db = dbConn();
    $sql = "UPDATE users u INNER JOIN teachers t ON u.UserId = t.UserId SET u.Status ='1' WHERE u.UserId='$userid'";
    $db->query($sql);

    $msg = "<h1>SUCCESS</h1>";
    $msg .= "<h2>Congratulations</h2>";
    $msg .= "<p>Dear Teacher, Your account has been approved. You can now log in and start using our services.</p>";
    $msg .= "<a href='http://localhost/IMS/system/teacher_login.php'>Click here to Login your account</a>";
    sendEmail($email, $first_name, "Account Approved", $msg);
  }
  $content = ob_get_clean();
  include '../layouts.php';
?>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Account Approved',
                text: 'The teacher\'s account has been successfully approved.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'manage.php';
            });
        });
    </script>
