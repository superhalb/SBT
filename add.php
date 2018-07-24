<?php
	require_once('User.php');
	require_once('Issue.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( isset($_POST['add-issue-steps']) && isset($_POST['add-issue-expected'])  && isset($_POST['add-issue-saw']) ) {
		$issueValues = new \stdClass();
		$issueValues->steps = $_POST['add-issue-steps'];
		$issueValues->expected = $_POST['add-issue-expected'];
		$issueValues->saw = $_POST['add-issue-saw'];
		$issueValues->assigned = $_POST['add-issue-assigned'];
		$issue = new Issue( uniqid() , $issueValues );
		header( "Location: edit.php?issue=" . $issue->number );
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
			<label>What you saw:</label>
			<textarea name="add-issue-saw" ></textarea>
			<label>What you expected to see:</label>
			<textarea name="add-issue-expected" ></textarea>
			<label>Steps to reproduce:</label>
			<textarea name="add-issue-steps" ></textarea>
			<div id="attachs">
				<script type="text/javascript" src="attach.js"></script>
				<label class="attachbutton">attach file<input type="file" name="attach[]" onchange="javascript:addFile(this)" /></label>
			</div>
			<label>Assign to:</label>
			<select name="add-issue-assigned">
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
