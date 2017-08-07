<?php
	require_once('user.php');
	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( !isset($_GET['id'] ) ) {
		header( "Location: index.php" );
		exit;
	}
	require_once('issue.php');
	$fileid = $_GET['id'];
	$filename = explode(".",$fileid);
	unset($filename[0]);
	unset($filename[1]);
	unset($filename[2]);
	$filename = implode(".",$filename);
	header( 'Content-disposition: attachment; filename=' . $filename );
	readfile( Issue::attachsPath . $fileid );
?>