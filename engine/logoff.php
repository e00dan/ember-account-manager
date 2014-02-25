<?php
require '../conf.sec.php';
require $conf['loc']['login'];

sec_session_start();

if ($_SESSION['logged']) {
	// Unset all session values
	$_SESSION = array();
	// get session parameters 
	$params = session_get_cookie_params();
	// Delete the actual cookie.
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	// Destroy session
	session_destroy();
	echo json_encode(array('success' => true));
} else {
	echo json_encode(array('success' => false));
}
?>