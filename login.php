<?php
	User::login();
	if(User::isLogged()) {
?>
		<a href="logout.php" id="logout">logout ( <?php echo User::$name; ?> )</a>
<?php
	} else {
?>
<html>
	<head>
		<link href='reset.css' rel='stylesheet' type='text/css'>
		<link href='styles.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form id="loginform" action="index.php" method="post">
			<label>User:</label>
			<input type="text" name="user" />
			<label>Password:</label>
			<input type="text" name="password" />
			<br><br>
			<button onclick="form.submit()" class="button">Log in</button>
		</form>
	</body>
</html>
<?php
		exit;
	}
