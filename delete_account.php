<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] == '-42')
{
	header('Location: not_signed_in.php');
	exit;
}
if (isset($_POST['password']) && $_POST['password'] != "")
{
	$hash = hash('whirlpool', $_POST['password']);
	$req = $bdd->prepare('SELECT id FROM users WHERE id = ? AND password = ?');
	$req->execute(array($_SESSION["id"], $hash));
	if ($req->rowCount() != 1)
		echo "<style>#wrong_pass { display: block; } </style>";
	else
	{
		$req = $bdd->prepare('SELECT id FROM images WHERE creator = ?');
		$req->execute(array($_SESSION["id"]));
		while ($el = $req->fetch())
		{
			$reqb = $bdd->prepare('DELETE FROM comments WHERE image = ?');
			$reqb->execute(array($el["id"]));
			$reqb = $bdd->prepare('DELETE FROM likes WHERE image = ?');
			$reqb->execute(array($el["id"]));
			unlink("pictures/".$el['id'].".png");
		}
		$reqb = $bdd->prepare('DELETE FROM likes WHERE creator = ?');
		$reqb->execute(array($_SESSION["id"]));
		$reqb = $bdd->prepare('DELETE FROM comments WHERE creator = ?');
		$reqb->execute(array($_SESSION["id"]));
		$reqb = $bdd->prepare('DELETE FROM images WHERE creator = ?');
		$reqb->execute(array($_SESSION["id"]));
		$reqb = $bdd->prepare('DELETE FROM users WHERE id = ?');
		$reqb->execute(array($_SESSION["id"]));
		header('Location: delete_redirect.php');
		exit;
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
		<span id="wrong_pass" class="error_msg">Wrong password</span>
		<form action="delete_account.php" method="post">
			<input class="login" type="password" name="password" placeholder="Password" required />
			<br />
			<br />
			<input class="submit" type="submit" value="Delete" />
		</form>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>
