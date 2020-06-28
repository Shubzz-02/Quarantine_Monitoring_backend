
<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['qqs']);
session_destroy();

header("Location: ../login.php");
exit;
?>
