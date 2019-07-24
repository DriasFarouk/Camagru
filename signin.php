<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] != '-42')
{
	header('Location: signed_in.php');
	exit;
}
if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] != "" && $_POST['password'] != "")
{
	$hash = hash('whirlpool', $_POST['password']);
	$req = $bdd->prepare('SELECT id, confirmed FROM users WHERE login = ? AND password = ?');
	$req->execute(array($_POST["login"], $hash));
	if($req->rowCount() == 1)
	{
		$data = $req->fetch();
		if ($data['confirmed'] == 0)
			echo "<style>#not_confirmed { display: block; } </style>";
		else
		{
			$_SESSION['id'] = $data['id'];
			header('Location: index.php');
			exit;
		}
	}
	else
		echo "<style>#wrong_log_pass { display: block; } </style>";
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
	<div class="login_box">
		<span id="wrong_log_pass" class="error_msg">Wrong login and/or password</span>
		<span id="not_confirmed" class="error_msg">This account isn't confirmed</span>
		<form action="signin.php" method="post">
			<input class="login" type="text" name="login" placeholder="Login" required />
			<br />
			<input class="login" type="password" name="password" placeholder="Password" required />
			<br />
			<br />
			<input class="submit" type="submit" value="Sign In" />
		</form>
		<a style="color: #2090FF; font-size: 14px; float: left; margin-top: 10px;" href="forgot.php">Password Forgot</a>
		<a style="color: #2090FF; font-size: 14px; float: right; margin-top: 10px;" href="register.php">Register</a>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>
