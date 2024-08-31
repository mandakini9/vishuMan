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
    $sql = "UPDATE users u INNER JOIN teachers t ON u.UserId = t.UserId SET u.Status ='3' WHERE u.UserId='$userid'";
    $db->query($sql);

    $msg = "<h1>SORRY</h1>";
    $msg .= "<p>Dear Teacher, Your account has been reject.</p>";
    sendEmail($email, $first_name, "Account Rejected", $msg);
  }
  $content = ob_get_clean();
  include '../layouts.php';
?>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Account Rejected',
                text: 'The teacher\'s account has been rejected.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'manage.php';
            });
        });
    </script>
