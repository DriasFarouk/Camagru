<?php include('database.php'); ?>
<?php
if (isset($_POST['limit']) && $_POST['limit'] != "")
{
	header('Content-Type: text/plain');
	$start = intval($_POST['limit']);
	$req = $bdd->prepare('SELECT * FROM images ORDER BY creation DESC LIMIT ?, 5');
	$req->bindParam(1, $start, PDO::PARAM_INT);
	$req->execute();
	while ($el = $req->fetch())
	{
		$reqb = $bdd->prepare('SELECT id FROM likes WHERE image = ?');
		$reqb->execute(array($el['id']));
		$likes = $reqb->rowCount();
		$reqb = $bdd->prepare('SELECT id FROM comments WHERE image = ?');
		$reqb->execute(array($el['id']));
		$comments = $reqb->rowCount();
		$reqb = $bdd->prepare('SELECT id FROM likes WHERE image = ? AND creator = ?');
		$reqb->execute(array($el['id'], $_SESSION['id']));
		$me = $reqb->rowCount();
		$src = "imgs/like.svg";
		if ($me == 1)
			$src = "imgs/liked.svg";
		?>
		<div class="photo">
			<img class="galery" src="pictures/<?php echo $el['id'] ?>.png">
			<div class="interaction">
				<img onclick="likeImage(<?php echo $el['id'] ?>);" id="like<?php echo $el['id'] ?>" class="likes" src="<?php echo $src ?>">
				<span id="nbr_likes<?php echo $el['id'] ?>" class="likes"><?php echo $likes ?></span>
				<img class="comments" src="imgs/chat.svg">
				<span id="nbr_comments<?php echo $el['id'] ?>" class="comments"><?php echo $comments ?></span>
			</div>
			<div class="comments" id="comments<?php echo $el['id'] ?>">
				<?php
				$reqb = $bdd->prepare('SELECT * FROM comments WHERE image = ? ORDER BY creation DESC');
				$reqb->execute(array($el['id']));
				while ($data = $reqb->fetch())
				{
					$reqc = $bdd->prepare('SELECT login FROM users WHERE id = ?');
					$reqc->execute(array($data['creator']));
					$datab = $reqc->fetch();
					?>
					<div class="comment" id="comment<?php echo $data['id'] ?>">
						<?php echo $datab['login']." :<br />".$data['comment'] ?>
						<?php
						if ($data['creator'] == $_SESSION['id'])
						{
							?>
							<span onclick="deleteComment(<?php echo $data['id'] ?>, <?php echo $el['id'] ?>)" class="delete_comment">delete</span>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="new_comment">
				<textarea placeholder="Your comment" class="new_comment" id="new_comment<?php echo $el['id'] ?>"></textarea>
				<div onclick="postComment(<?php echo $el['id'] ?>);" class="post">POST</div>
			</div>
		</div>
		<?php
	}
}
else
	echo "error";
?>
