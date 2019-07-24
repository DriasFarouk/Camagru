<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] == '-42')
{
	header('Location: not_signed_in.php');
	exit;
}
$req = $bdd->prepare('SELECT notification FROM users WHERE id = ?');
$req->execute(array($_SESSION['id']));
$data = $req->fetch();
if ($data['notification'] == 0)
{
	$color = "#FF0000";
	$value = "OFF";
}
else
{
	$color = "#00FF00";
	$value = "ON";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<script src="js.js"></script>
	<link rel="stylesheet" type="text/css" href="css.css">
	<link rel="icon" type="image/png" href="imgs/42.png" />
</head>
<body>
	<?php include('header.php'); ?>
	<a href="modify_email.php"><div class="account">Modify email</div></a>
	<a href="modify_login.php"><div class="account">Modify login</div></a>
	<a href="modify_password.php"><div class="account">Modify password</div></a>
	<a href="delete_account.php"><div class="account">Delete Account</div></a>
	<div class="notification">
		<span class="notification">receive an email every new comment</span>
		<div onclick="onOff();" id="on_off" style="background-color: <?php echo $color ?>" class="on_off"><?php echo $value ?></div>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>
