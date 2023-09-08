<?php
session_start();
if(isset($_SESSION['usr_rol'])) {
	session_destroy();
	unset($_SESSION['usr_rol']);
	unset($_SESSION['email']);
			echo'<script type="text/javascript"> ;
			window.location.href="login.php";</script>';
} else {

		echo'<script type="text/javascript"> ;
		window.location.href="login.php";</script>';
}
?>