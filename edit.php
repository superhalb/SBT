<?php
	date_default_timezone_set("UTC");
	require_once('user.php');
	require_once('login.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
		exit;
	}
	if ( !isset($_GET['issue'] ) ) {
		header( "Location: index.php" );
		exit;
	}
	require_once('issue.php');
	$issue = new Issue($_GET['issue']);
	if ( isset($_POST['add-issue-comment']) && isset($_POST['add-issue-assign'] ) ) {
		$msg = $_POST['add-issue-comment'];
		$assign = $_POST['add-issue-assign'];
		$now = time();
		file_put_contents( $issue->dir . "/" .  $now . "." . User::$name . "." . $assign . ".php", "<?php exit; ?>" . $msg );
	}
	$issue->readEdits();
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<ul>
			<li>
				<a href="index.php">Back</a>
			</li>
		</ul>

		<form id="form" action="edit.php?issue=<?php echo $_GET['issue'];?>" method="post">
			<label>Steps to reproduce:</label>
			<div id="add-issue-steps" class="textarea"><?php echo $issue->steps; ?></div>
			<label>What you expected to see:</label>
			<div id="add-issue-expected" class="textarea"><?php echo $issue->expected; ?></div>
			<label>What you saw instead:</label>
			<div id="add-issue-saw" class="textarea"><?php echo $issue->saw; ?></div>
			<label>Assigned to:</label>
			<div id="add-issue-assigned-to" class="textarea"><?php echo $issue->assigned; ?></div>
			<br><br>
<?php
	foreach( $issue->edits as $edit ) {
?>
			<div class="textarea">
				<div class="msg">
					<?php echo $edit->msg; ?>
				</div>
				<div class="by info">By <span class="mark"><?php echo $edit->who; ?></span></div>
				<div class="assigned-to info">Assigned to <span class="mark"><?php echo $edit->assign; ?></span></div>
				<div class="edit-time info">At <span class="mark"><?php echo $edit->timeStr; ?></span></div>
			</div>
<?php
	}
?>
			<br><br>
			<label>New comment:</label>
			<textarea name="add-issue-comment" ></textarea>
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
