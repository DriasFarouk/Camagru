<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] != '-42')
	header('Location: signed_in.php');
$text = "This account could not be confirmed.";
if (isset($_GET['r']) && $_GET['r'] != "")
{
	$req = $bdd->prepare('SELECT id FROM users WHERE id = ? AND confirmed = 0');
	$req->execute(array($_GET['r']));
	if($req->rowCount() == 1)
	{
		$req = $bdd->prepare('UPDATE users SET confirmed = 1 WHERE id = ?');
		$req->execute(array($_GET['r']));
		$text = "Your account is now confirmed, you may now sign in.";
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
	<div class="box_big_message">
		<?php echo $text; ?>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>
