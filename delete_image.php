<?php include('database.php'); ?>
<?php
if (isset($_POST['id']) && $_POST['id'] != "")
{
	if ($_SESSION['id'] == "-42")
	{
		echo "log";
		exit;
	}
	$req = $bdd->prepare('SELECT id FROM images WHERE id = ? AND creator = ?');
	$req->execute(array($_POST['id'], $_SESSION['id']));
	if ($req->rowCount() != 1)
	{
		echo "error";
		exit;
	}
	$req = $bdd->prepare('DELETE FROM images WHERE id = ?');
	$req->execute(array($_POST['id']));
	$req = $bdd->prepare('DELETE FROM likes WHERE image = ?');
	$req->execute(array($_POST['id']));
	$req = $bdd->prepare('DELETE FROM comments WHERE image = ?');
	$req->execute(array($_POST['id']));
	unlink("pictures/".$_POST['id'].".png");
	echo "ok";
	exit;
}
else
	echo "error";
?>
