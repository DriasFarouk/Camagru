<?php include('database.php'); ?>
<?php
if (isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['comment']) && $_POST['comment'])
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
	$req = $bdd->prepare('INSERT INTO comments (creator, creation, image, comment) VALUES (:creator, :creation, :image, :comment)');
	$req->execute(array(
	'creator' => $_SESSION['id'],
	'creation' => time(),
	'image' => $_POST['id'],
	'comment' => $_POST['comment']
	));
	$id = $bdd->lastInsertId();
	$req = $bdd->prepare('SELECT login FROM users WHERE id = ?');
	$req->execute(array($_SESSION['id']));
	$data = $req->fetch();
	$req = $bdd->prepare('SELECT creator FROM images WHERE id = ?');
	$req->execute(array($_POST['id']));
	$datab = $req->fetch();
	$req = $bdd->prepare('SELECT email, notification FROM users WHERE id = ?');
	$req->execute(array($datab['creator']));
	$datab = $req->fetch();
	$msg = $data['login']." commented one of your images.";
	if ($datab['notification'] == 1)
		mail($datab['email'], 'New comment', $msg);
	echo $data['login'].";".$id;
	exit;
}
else
	echo "error";
?>
