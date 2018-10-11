<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!empty($_SESSION['ApiToken'])) {
	header('Location: dashboard');
} else {
	header('Location: ../login');
}

?>