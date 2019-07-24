<?php include('database.php'); ?>
<?php
if (isset($_POST['id']) && $_POST['id'] != "")
{
	if ($_SESSION['id'] == "-42")
	{
		echo "log";
		exit;
	}
	$req = $bdd->prepare('SELECT id FROM images WHERE id = ?');
	$req->execute(array($_POST['id']));
	if ($req->rowCount() != 1)
	{
		echo "error";
		exit;
	}
	$req = $bdd->prepare('SELECT id FROM likes WHERE image = ? AND creator = ?');
	$req->execute(array($_POST['id'], $_SESSION['id']));
	if ($req->rowCount() == 0)
	{
		$req = $bdd->prepare('INSERT INTO likes (creator, image) VALUES (:creator, :image)');
		$req->execute(array(
		'creator' => $_SESSION['id'],
		'image' => $_POST['id']
		));
		echo "add";
		exit;
	}
	else
	{
		$req = $bdd->prepare('DELETE FROM likes WHERE image = ? AND creator = ?');
		$req->execute(array($_POST['id'], $_SESSION['id']));
		echo "remove";
		exit;
	}
}
else
	echo "error";
?>
