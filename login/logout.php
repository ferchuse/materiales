<?php 
	session_start();
	session_destroy();
	unset($_COOKIE['id_turnos']);
	setcookie("id_turnos", "",  time() - 3600, "/");
?>