<?php
	date_default_timezone_set("UTC");
	require_once('user.php');
	require_once('login.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( isset($_POST['add-issue-steps']) && isset($_POST['add-issue-expected'])  && isset($_POST['add-issue-saw']) ) {
		$steps = $_POST['add-issue-steps'];
		$expected = $_POST['add-issue-expected'];
		$saw = $_POST['add-issue-saw'];
		$assign = $_POST['add-issue-assign'];
		$d = dir(getcwd() ."/issues");
		$countFiles = -2; // . & ..
		while (($file = $d->read()) !== false){ 
			$countFiles ++;
		}
		$d->close(); 
		do {
			$newissue = getcwd() ."/issues/". $countFiles;
		} while ( file_exists($newissue) );
		mkdir( $newissue );
		$now = time();
		file_put_contents( $newissue . "/issue-steps.php", "<?php exit; ?>". $steps );
		file_put_contents( $newissue . "/issue-expected.php", "<?php exit; ?>". $expected );
		file_put_contents( $newissue . "/issue-saw.php", "<?php exit; ?>". $saw);
		file_put_contents( $newissue . "/issue-creator.php", "<?php exit; ?>". User::$name );
		file_put_contents( $newissue . "/issue-creation.php", "<?php exit; ?>". $now );
		file_put_contents( $newissue . "/" .  $now . "." . User::$name . "." . $assign . ".php", "<?php exit; ?>Created" );
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		New issue created with number: <?php echo $countFiles; ?>
		<br><br>
		<a href="index.php">back</a>
	</body>
</html>
<?php
		exit;
	}
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<ul>
			<li>
				<a href="index.php">back</a>
			</li>
		</ul>
		<form id="add-issue" action="add.php" method="post">
			<label>Steps to reproduce:</label>
			<textarea name="add-issue-steps" ></textarea>
			<label>What you expected to see:</label>
			<textarea name="add-issue-expected" ></textarea>
			<label>What you saw instead:</label>
			<textarea name="add-issue-saw" ></textarea>
			<label>Assign to:</label>
			<select name="add-issue-assign">
<?php
	foreach( User::$credentials as $user=>$pass) {
		echo '<option value="'. $user .'">'. $user .'</option>';
	}
?>
			</select>
			<br><br>
			<button onclick="form.submit()" class="button">Save</button>
		</form>
	</body>
</html>
