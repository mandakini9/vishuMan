<?php
ob_start();
include_once '../../init.php';

  $content = ob_get_clean();
  include '../../layouts.php';
?>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Enrollment Successfully',
                text: 'The Students\'s Class Enrollment is successfully.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = '../registerstudents.php';
            });
        });
    </script>