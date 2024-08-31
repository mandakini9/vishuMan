<?php
ob_start();
include_once '../init.php';

  $content = ob_get_clean();
  include '../layouts.php';
?>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Payment Successfully',
                text: 'The Students\'s Class Payment is successfully.',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'manage.php';
            });
        });
    </script>