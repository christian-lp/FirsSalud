<?php
session_start();
// if(isset($_SESSION['usr_rol'])) {
// 	session_destroy();
// 	unset($_SESSION['usr_rol']);
// 	unset($_SESSION['email']);
// 			echo'<script type="text/javascript"> ;
// 			window.location.href="login.php";</script>';
// } else {

// 		echo'<script type="text/javascript"> ;
// 		window.location.href="login.php";</script>';
// }
	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}

	session_destroy();

	// redirecting the user to the login page
	header('Location: login.php?action=logout');

 
?>