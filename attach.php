<?php
	require_once('user.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( !isset( $now ) ) {
		header( "Location: index.php" );
	}
	if ( !isset( $issueNumber ) ) {
		header( "Location: index.php" );
	}

	require_once('issue.php');

	if ( isset( $_FILES['attach'] ) ) {
		for( $i=0 ; $i < count( $_FILES['attach']['error'] ) ; ++ $i ) {
			if ( $_FILES["attach"]["error"][$i] > 0) {
				continue;
			}
			$targetfilename = Issue::attachsPath . $issueNumber . "." .  $now . "." . $i . "." . $_FILES["attach"]["name"][$i];
			move_uploaded_file( $_FILES["attach"]["tmp_name"][$i], $targetfilename);
		}
	}
?>
