<?PHP

// Use this sort of thing for exit.php
// To exit back to login page, destroy session and cookie data
// Found this session destroy code from presentation 11 of the php module.
session_start();
session_regenerate_id(true);

	if (ini_get("session.use_cookies")) 
	{
		$yesterday = time() - (24 * 60 * 60);
		$params = session_get_cookie_params();
		setcookie(session_name(), '', $yesterday,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]); 
	}
	session_destroy();
	header('Location: ../index.php');
	exit();
	
?>