<?php
	date_default_timezone_set("UTC");
	require_once('user.php');
	require_once('login.php');
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	<div>
		<ul>
			<li>
				<a href="add.php">new issue +</a>
			</li>
		</ul>
	</div>
<?php
	include('buglist.php');
?>
	</body>
</html>
