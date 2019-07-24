<div class="header">
	<div class="section">
		<ul class="section">
			<li class="section">
				<a class="section" href="index.php">Home</a>
			</li>
			<?php
			if ($_SESSION['id'] != "-42")
			{
				?>
				<li class="section">
					<a class="section" href="studio.php">Studio</a>
				</li>
				<li class="section">
					<a class="section" href="account.php">Account</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	<div class="right">
		<ul class="section">
			<li class="section">
				<?php
				if ($_SESSION['id'] == "-42")
					echo "<a class=\"section\" href=\"signin.php\">Sign In</a>";
				else
					echo "<a class=\"section\" href=\"logout.php\">Logout</a>";
				?>
			</li>
		</ul>
	</div>
</div>
