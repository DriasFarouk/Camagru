<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] != '-42')
{
	header('Location: signed_in.php');
	exit;
}
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_conf']) && isset($_POST['email']) && $_POST['login'] != "" && $_POST['password'] != "" && $_POST['password_conf'] != "" && $_POST['email'] != "")
{
	if ($_POST['password'] != $_POST['password_conf'])
		echo "<style>#pass_match { display: block; } </style>";
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		echo "<style>#email_format { display: block; } </style>";
	else if (strlen($_POST['password']) < 8)
		echo "<style>#short_pass { display: block; } </style>";
	else if (!preg_match("#[0-9]+#", $_POST['password']))
		echo "<style>#number_pass { display: block; } </style>";
	else if (!preg_match("#[a-zA-Z]+#", $_POST['password']))
		echo "<style>#letter_pass { display: block; } </style>";
	else
	{
		$req = $bdd->prepare('SELECT id FROM users WHERE login = ?');
		$req->execute(array($_POST["login"]));
		$reqb = $bdd->prepare('SELECT id FROM users WHERE email = ?');
		$reqb->execute(array($_POST["email"]));
		if ($req->rowCount() > 0)
			echo "<style>#login_used { display: block; } </style>";
		else if ($reqb->rowCount() > 0)
			echo "<style>#email_used { display: block; } </style>";
		else
		{
			$hash = hash('whirlpool', $_POST['password']);
			$req = $bdd->prepare('INSERT INTO users (login, password, email, confirmed, notification) VALUES (:login, :password, :email, 0, 1)');
			$req->execute(array(
			'login' => $_POST['login'],
			'password' => $hash,
			'email' => $_POST['email']
			));
			$req = $bdd->prepare('SELECT id FROM users WHERE login = ?');
			$req->execute(array($_POST["login"]));
			$data = $req->fetch();
			$msg = 'To validate your account please click on the following link : http://localhost:8080/confirmation.php?r='.$data['id'];
			mail($_POST['email'], 'Account confirmation', $msg);
			header('Location: register_redirect.php');
			exit;
		}
	}
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
		<span id="login_used" class="error_msg">Login already used</span>
		<span id="email_used" class="error_msg">Email already used</span>
		<span id="pass_match" class="error_msg">Passwords don't match</span>
		<span id="email_format" class="error_msg">Not a valid email</span>
		<span id="short_pass" class="error_msg">Password too short</span>
		<span id="number_pass" class="error_msg">Password must include a number</span>
		<span id="letter_pass" class="error_msg">Password must include a letter</span>
		<form action="register.php" method="post">
			<input class="login" type="email" name="email" placeholder="Email" required />
			<br />
			<input class="login" type="text" name="login" placeholder="Login" required />
			<br />
			<input class="login" type="password" name="password" placeholder="Password" required />
			<br />
			<input class="login" type="password" name="password_conf" placeholder="Confirmation" required />
			<br />
			<br />
			<input class="submit" type="submit" value="Register" />
		</form>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>
