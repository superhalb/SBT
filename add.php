<?php
	date_default_timezone_set("UTC");
	require_once('user.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( isset($_POST['add-issue-steps']) && isset($_POST['add-issue-expected'])  && isset($_POST['add-issue-saw']) ) {
		$steps = $_POST['add-issue-steps'];
		$expected = $_POST['add-issue-expected'];
		$saw = $_POST['add-issue-saw'];
		$assign = $_POST['add-issue-assign'];
		$issueId = uniqid();
		$newissue = getcwd() ."/issues/". $issueId;
		mkdir( $newissue );
		$now = time();
		file_put_contents( $newissue . "/issue-steps.md", $steps );
		file_put_contents( $newissue . "/issue-expected.md", $expected );
		file_put_contents( $newissue . "/issue-saw.md", $saw);
		file_put_contents( $newissue . "/issue-creator", User::$name );
		file_put_contents( $newissue . "/issue-creation", $now );
		file_put_contents( $newissue . "/" .  $now . "." . User::$name . "." . $assign , "Created" );
		include("attach.php");
		header( "Location: edit.php?issue=" . $issueId );
	}
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
<?php
	require_once('login.php');
?>
		<ul>
			<li>
				<a href="index.php">back</a>
			</li>
		</ul>
		<form id="add-issue" action="add.php" method="post" enctype="multipart/form-data">
			<label>Steps to reproduce:</label>
			<textarea name="add-issue-steps" ></textarea>
			<label>What you expected to see:</label>
			<textarea name="add-issue-expected" ></textarea>
			<label>What you saw instead:</label>
			<textarea name="add-issue-saw" ></textarea>
			<div id="attachs">
				<script type="text/javascript" src="attach.js"></script>
				<label class="attachbutton">attach file<input type="file" name="attach[]" onchange="javascript:addFile(this)" /></label>
			</div>
			<label>Assign to:</label>
			<select name="add-issue-assign">
<?php
	foreach( User::$credentials as $user=>$pass) {
		echo '<option value="'. $user .'">'. $user .'</option>';
	}
?>
			</select>
			<br><br>
			<button onclick="form.submit()" class="button">save</button>
		</form>
	</body>
</html>
