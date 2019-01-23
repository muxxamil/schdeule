<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!empty($_SESSION['scheduleApiToken'])) {
	header('Location: dashboard');
} else {
	header('Location: ../login');
}

?>