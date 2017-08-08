<?php
	require_once('User.php');
	require_once('Issue.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
?>
<div id="issue-list-box">
<div id="issue-list">
	<table>
		<tr>
			<th>
				Number
			</th>
			<th>
				Issue
			</th>
			<th>
				Creator
			</th>
			<th>
				Creation
			</th>
			<th>
				Modification
			</th>
			<th>
				Assigned
			</th>
			<th>
				Options
			</th>
		</tr>
<?php

	$d = dir(getcwd() ."/issues");
	$files = array();
	while (($file = $d->read()) !== false){
		array_push( $files, $file );
	}
	$d->close();
	sort($files);

	foreach($files as $f) {
		if($f===".") continue;
		if($f==="..") continue;
		$issuenumber = getcwd() ."/issues/".$f;
		if( !is_dir( $issuenumber) ) continue;
		if( !file_exists($issuenumber."/issue-steps.md")) continue;
		if( !file_exists($issuenumber."/issue-expected.md")) continue;
		if( !file_exists($issuenumber."/issue-saw.md")) continue;

		$issue = new Issue( $f );

		if( isset( $_GET['filter'] ) ) {
			if ( $_GET['filter'] !== $issue->assigned ) continue;
		}
?>
	<tr>
		<td>
			<?php echo $issue->number ?>
		</td>
		<td>
			<?php echo $issue->sawShort() ?>
		</td>
		<td>
			<?php echo $issue->creator ?>
		</td>
		<td>
			<?php echo $issue->creationToString() ?>
		</td>
		<td>
			<?php echo $issue->modificationToString() ?>
		</td>
		<td>
			<?php echo $issue->assigned ?>
		</td>
		<td>
			<a href="edit.php?issue=<?php echo $issue->number; ?>">edit</a>
		</td>
	</tr>
<?php
	}
?>
</table>
</div>
</div>
