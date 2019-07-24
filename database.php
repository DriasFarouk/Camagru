<?php
date_default_timezone_set("Europe/Paris");
try
{
	$bdd = new PDO("mysql:dbname=camagru;host=127.0.0.1", "root", "fdrias");
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
}
catch (Exception $e)
{
	header("Location: error.php");
	exit;
}
session_start();
if (!isset($_SESSION['id']))
	$_SESSION['id'] = "-42";
else if ($_SESSION['id'] != "-42")
{
	$req = $bdd->prepare('SELECT notification FROM users WHERE id = ?');
	$req->execute(array($_SESSION['id']));
	if ($req->rowCount() != 1)
		$_SESSION['id'] = "-42";
}
?>
