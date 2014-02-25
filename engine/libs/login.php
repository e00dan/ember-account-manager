<?php

function sec_session_start() {
	$session_name = 'acc'; // Set a custom session name
	$secure = false; // Set to true if using https.
	$httponly = true; // This stops javascript being able to access the session id. 

	ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
	$cookieParams = session_get_cookie_params(); // Gets current cookies params.
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
	session_name($session_name); // Sets the session name to the one set above.
	session_start(); // Start the php session
	session_regenerate_id(true); // regenerated the session, delete the old one.     
}

function login($name, $password, $mysqli) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT `id`, `name`, `password` FROM `accounts` WHERE `name` = ? LIMIT 1")) { 
      $stmt->bind_param('s', $name); // Bind "$user" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
	  $acc = array();
      $stmt->bind_result($acc['id'], $acc['name'], $acc['password']); // get variables from result.
      $stmt->fetch();
      $password = sha1($password);
 
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts
         if($acc['password'] == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!

               $user_browser 			= $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
               $acc['id'] 				= preg_replace("/[^0-9]+/", "", $acc['id']); // XSS protection as we might print this value
               $acc['name'] 			= preg_replace("/[^a-zA-Z0-9_\-]+/", "", $acc['name']); // XSS protection as we might print this value
               $_SESSION['acc_id'] 		= $acc['id']; 
			   $_SESSION['acc_name'] 	= $acc['name'];
               $_SESSION['logged'] 		= true;
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            return false;
         }
      } else {
         // No user exists. 
         return false;
      }
   }
}

?>