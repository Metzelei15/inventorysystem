<?php
    session_start();
	if (!isset($_SESSION["role"])){
		header("Location: login.php");
        session_unset();
		session_destroy();
        die();
    }
?>