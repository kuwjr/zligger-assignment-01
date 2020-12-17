<!-- using a seperate file for logout, so we can log out from anywhere -->
<?php
    session_start();
    session_destroy();
    header('Location: admin-login.php');
    exit;
?>