<?php
	require_once('user.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
?>
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

	require_once('issue.php');
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
		if( !file_exists($issuenumber."/issue-steps.php")) continue;
		if( !file_exists($issuenumber."/issue-expected.php")) continue;
		if( !file_exists($issuenumber."/issue-saw.php")) continue;
		if( !file_exists($issuenumber."/issue-creator.php")) continue;
		
		$issue = new Issue($f);
?>
	<tr>
		<td>
			<?php echo $issue->number ?>
		</td>
		<td>
			<?php echo $issue->saw ?>
		</td>
		<td>
			<?php echo $issue->creator ?>
		</td>
		<td>
			<?php echo $issue->creationStr ?>
		</td>
		<td>
			<?php echo $issue->modificationStr ?>
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