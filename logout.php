<?php
		session_start();
		$_SESSION['loggedIn'] = false;
		$_SESSION['username'] = "";
		$_SESSION['error'] = NULL;
		$_SESSION['student'] = "";
		header('Location: /?#');
?>
