<?php include('database.php'); ?>
<?php
if ($_SESSION['id'] == '-42')
{
	header('Location: not_signed_in.php');
	exit;
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
<body onload="streaming();">
	<?php include('header.php'); ?>
	<div class="big_box">
		<div class="big_left">
			<div class="items">
				<img onclick="selectItem('dog');" id="dog" src="imgs/minibat.png" class="item">
				<img onclick="selectItem('sun');" id="sun" src="imgs/minifire.png" class="item">
				<img onclick="selectItem('glasses');" id="glasses" src="imgs/minivador.png" class="item">
				<input onchange="uploaded(this);" disabled="disabled" id="file" class="upload" type="file" name="file">
			</div>
			<div class="camera">
				<img id="dog_filtre" src="imgs/dog.png" class="filtre">
				<img id="sun_filtre" src="imgs/sun.png" class="filtre">
				<img id="glasses_filtre" src="imgs/glasses.png" class="filtre">
				<video class="camera" id="camera"></video>
				<div onclick="photo();" class="button_photo" id="button_photo">PHOTO !</div>
			</div>
		</div>
		<div class="big_right">
			<span class="title_pictures">Your pictures</span>
			<div class="studio_galery" id="studio_galery">
				<?php
				$req = $bdd->prepare('SELECT * FROM images WHERE creator = ? ORDER BY creation DESC');
				$req->execute(array($_SESSION['id']));
				while ($el = $req->fetch())
				{
					?>
					<div id="image<?php echo $el['id'] ?>" class="studio_pictures">
						<img class="studio_pictures" src="pictures/<?php echo $el['id'] ?>.png">
						<span style="margin-top: -2px" onclick="deleteImage(<?php echo $el['id'] ?>)" class="delete_comment">delete</span>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<canvas id="canvas" style="display: none;"></canvas>
	<?php include('footer.php'); ?>
</body>
</html>
