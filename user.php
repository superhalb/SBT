<?php

	session_start();

	class User {
		static public $name;
		static public $credentials = array (
			"dev" => "pwd",
			"prod" => "pwd",
			"closed" => NULL
		);
		
		static public function isLogged() {
			if (isset( $_SESSION['user'] ) ) {
				User::$name = $_SESSION['user'];
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		static public function logout() {
			unset( $_SESSION['user'] );
			header( "Location: index.php" );
		}
		
		static public function login() {
			if ( User::isLogged() ) {
				return;
			}
			$user = $_POST['user'];
			$pass = $_POST['password'];
			if ( $user !== "closed" ) {
				if ( isset( User::$credentials[$user] ) ) {
					if ( User::$credentials[$user] === $pass ) {
						$_SESSION['user'] = $user;
						User::$name = $_SESSION['user'];
					}
				}
			}
		}
	}
?>
