<?php
    session_start();
	if (!isset($_SESSION["role"])){
		header("Location: login.php");
        session_unset();
		session_destroy();
        die();
    }
	if (isset($_GET["logout"])){
		session_unset();
		session_destroy();
		echo "<script>document.location.href = 'login.php';</script>";
	}
?>