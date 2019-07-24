<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] == "-42")
{
	echo "log";
	exit;
}
$req = $bdd->prepare('SELECT notification FROM users WHERE id = ?');
$req->execute(array($_SESSION['id']));
$data = $req->fetch();
if ($data['notification'] == 0)
{
	$req = $bdd->prepare('UPDATE users SET notification = 1 WHERE id = ?');
	$req->execute(array($_SESSION['id']));
	echo "on";
	exit;
}
else
{
	$req = $bdd->prepare('UPDATE users SET notification = 0 WHERE id = ?');
	$req->execute(array($_SESSION['id']));
	echo "off";
	exit;
}
?>
