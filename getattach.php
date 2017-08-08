<?php
	require_once('User.php');
	require_once('Issue.php');

	if ( !User::isLogged() ) {
		header( "Location: index.php" );
	}
	if ( !isset($_GET['id'] ) ) {
		header( "Location: index.php" );
		exit;
	}
	$fileid = $_GET['id'];
	$filename = explode(".",$fileid);
	unset($filename[0]);
	unset($filename[1]);
	unset($filename[2]);
	$filename = implode(".",$filename);
	header( 'Content-disposition: attachment; filename=' . $filename );
	readfile( Issue::attachsPath . $fileid );
