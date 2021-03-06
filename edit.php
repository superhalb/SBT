<?php
	require_once('User.php');
	require_once('Issue.php');
	require_once('login.php');

	if ( !User::isLogged() ) {
		header( "Location: index.php" );
		exit;
	}
	if ( !isset($_GET['issue'] ) ) {
		header( "Location: index.php" );
		exit;
	}
	$issue = new Issue( $_GET['issue'] );
	if ( isset($_POST['add-issue-comment']) && isset($_POST['add-issue-assigned'] ) ) {
		$issueNumber = $issue->number;
		$msg = $_POST['add-issue-comment'];
		$assigned = $_POST['add-issue-assigned'];
		$issue->update( $assigned , $msg );
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
			<li class="issue-title">Issue # <?php echo $issue->number; ?></li>
			<li>
				<a href="index.php">Back</a>
			</li>
		</ul>

		<form id="form" action="edit.php?issue=<?php echo $_GET['issue'];?>" method="post" enctype="multipart/form-data">
			<label>Description:</label>
			<div id="add-issue-description" class="textarea"><?php echo $issue->description; ?></div>
			<label>Assigned to:</label>
			<div id="add-issue-assigned-to" class="textarea"><?php echo $issue->assigned; ?></div>
			<br><br>
			<label>History:</label>
<?php
	foreach( $issue->edits as $edit ) {
?>
			<div class="textarea">
				<div class="msg">
					<?php echo $edit->msg; ?>
				</div>
<?php
		if ( count( $edit->attachs ) > 0 ) {
			echo "<div class='attachs'>attached files:<br>";
			foreach( $edit->attachs as $fileid => $attach ) {
?>
					<a href="<?php echo 'getattach.php?id=' . $fileid; ?>" class="attached">
						<?php echo $attach; ?>
					</a>
<?php
			}
			echo "</div>";
		}
?>
				<div class="by info">By <span class="mark"><?php echo $edit->who; ?></span></div>
				<div class="assigned-to info">Assigned to <span class="mark"><?php echo $edit->assigned; ?></span></div>
				<div class="edit-time info">At <span class="mark"><?php echo $edit->timeStr; ?></span></div>
			</div>
<?php
	}
?>
			<br><br>
			<label>New comment:</label>
			<textarea name="add-issue-comment" ></textarea>
			<div id="attachs">
				<script type="text/javascript" src="attach.js"></script>
				<label class="attachbutton">attach file<input type="file" name="attach[]" onchange="javascript:addFile(this)" /></label>
			</div>
			<label>Assign to:</label>
			<select name="add-issue-assigned">
<?php
	foreach( User::$credentials as $user=>$pass) {
		echo '<option value="'. $user .'"'. ($issue->assigned == $user ? " selected" : "") .'>'. $user .'</option>';
	}
?>
			</select>
			<br><br>
			<button onclick="form.submit()" class="button">save</button>
		</form>
	</body>
</html>
