<?php include('database.php'); ?>
<?php
session_destroy();
header('Location: index.php');
exit;
?>
