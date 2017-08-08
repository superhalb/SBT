<?php
	date_default_timezone_set("UTC");
	require_once('User.php');
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
			<li class="li-right">
				<a <?php
					if( ! isset( $_GET['filter'] ) ) {
						echo ' class="selected" ';
					}
				?>href="index.php">all</a>
			</li>
<?php
	foreach ( User::$credentials as $u => $p ) {
		$selected = "";
		if( isset( $_GET['filter'] ) && $_GET['filter'] === $u ) {
			$selected = "selected";
		}
		echo '<li class="li-right"><a class="' . $selected . '" href="index.php?filter=' . $u . '">' . $u . '</a></li>';
	}
?>
		</ul>
	</div>
<?php
	include('buglist.php');
?>
	</body>
</html>
