<?php

// Requires

	//Gets the config file, which stores the Database info
	require_once('config.inc.php');

	// Require the class Db - for creating and using the database connection as an object
	require_once 'classes/Db.php';
		
		
// State variables

	// $selfDir gets the full directory of the current URL
	$selfDir = htmlspecialchars($_SERVER['REQUEST_URI']);
		

	// The login form, ready to be outputted when necessary
	$logForm = '<form action="' . $selfDir . '" method="post" id="logForm">' . PHP_EOL .
			   '<fieldset class="logField">' . PHP_EOL .
			   '<legend>Log In</legend>' . PHP_EOL . 
			   '<div>' . PHP_EOL . 
			   '<label for="user">User ID: </label>' . PHP_EOL . 
			   '<input type="text" name="username" id="user" value="" onblur="JSvalidateLogUser()"/>' . PHP_EOL . 
			   '<a href="#" onclick="helpLogUser();" class="helpButton">' . '?' . '</a>' . '<br/>' . 
			    '<span id="logFormUserError" class="errorJS">' . '</span>' . PHP_EOL . 
			   '</div>' . PHP_EOL . 
			   '<br/>' . 
			   '<div>' . PHP_EOL . 
			   '<label for="pass">Password: </label>' . PHP_EOL . 
			   '<input type="password" name="password" id="pass" value="" onblur="JSvalidateLogPass()" />' . PHP_EOL . 
			   '<a href="#" onclick="helpLogPass();" class="helpButton">' . '?' . '</a>' .  '<br/>'  .
			    '<span id="logFormPassError" class="errorJS">' . '</span>' . PHP_EOL . 
			   '</div>' . PHP_EOL . 
			   '<br/>' . PHP_EOL . 
			   '<input type="submit" name="logInDetails" value="Log In" class="logBut" />' . PHP_EOL . 
			   '</fieldset>' . PHP_EOL . 
			   '</form>' . PHP_EOL;
	
	// Array to store the cleaned inputs from the user
	$clean = array();
	
	// A variable to collect error message
	$error = '';
	
// The login code

	// Test to see if the login form has been submitted
	if (isset($_POST['logInDetails'])) 
	{
		// Gather user inputs and clean them up with htmlentities
		$username = ($_POST['username']);
		$password = ($_POST['password']);
		$clean['username'] = htmlspecialchars($username);
		$clean['password'] = htmlspecialchars($password);
		
		// Check if the username is not empty
		if(!empty($clean['username']))
		{
			// Check if the username is not numeric
			if(!is_numeric($clean['username']))
			{
				$error .= '<p class="logError">' . 'Username must be numeric' . '</p>' . PHP_EOL;
			}
		}
		else
		{
			$error .= '<p class="logError">' . 'Username must not be empty' . '</p>' . PHP_EOL;
		}
		// Check if the password is not empty
		if(!empty($clean['password']))
		{
			// Check if the password is not numeric
			if(!is_numeric($clean['password']))
			{
				$error .= '<p class="logError">' . 'Password must be numeric' . '</p>' . PHP_EOL;
			}
		}
		else
		{
			$error .= '<p class="logError">' . 'Password must not be empty' . '</p>' . PHP_EOL;
		}
		
		// If no errors, continue on
		if(empty($error))
		{
			// Test if the length of the username and password is equal to 4 characters
			if ((strlen($clean['username'])== 4) && (strlen($clean['password'])== 4))
			{
				// To connect to the database and create a database object by constructing the object with these parameters
				$hostDb = $config['db_host'];
				$userDb = $config['db_user'];
				$passDb = $config['db_pass'];
				$dbnameDb = $config['db_name'];
				
				// Instantiase a new Db object
				$db = new Db($hostDb, $userDb, $passDb, $dbnameDb);
				
				// Get the connection from the object, so can use with sql
				$con = $db->getLink();
				
				// Prepare the query
				$sql = "Select username, password, level FROM Users";
					
				// Use a method in the database class to get the result of the query and return it
				$result = $db->getResult($sql);
					
				// If the result is equal to false, gather the outputs and return it to the user
				if($result == false)
				{
					// Gather the error message in a variable
					$error = mysqli_error($con);
					// Free up the query result
					$db->freeResult($result);
					// End the database connection
					$db->endConnection($con);
				}
				// Else if the result is true
				else
				{
					// Loop through all the rows of the result
					while($row = mysqli_fetch_assoc($result))
					{
						// Check to see if the password in the table is less than 4 digits
						// Eg, if the password entered is 0021, in the table it is stored as 21, so need to add the
						// two zeros at the start to make sure it lets the user in
						if(strlen($row['password']) < 4)
						{
							// If the password from the table is less than 4 digits, it loops through adding zeros to the
							// front of the password until the password is 4 digits, eg row[password] is 21(2 digits), but is meant
							// to be 0021. It loops through adding the zeros to the front until it becomes 0021.
							for($i = strlen($row['password']); $i == 4; $i++)
							{
								$row['password'] = '0' . $row['password'];
							}
						}
						// Check to see if the username and password match a row from the Users table
						if(($clean['username'] == $row['username']) && ($clean['password'] == $row['password']))
						{
							// Regenerate the session id, to stop people using the session id maliciously
							session_regenerate_id(true);
							// Add the username to the Session username
							$_SESSION['username'] = $clean['username'];
							$_SESSION['level'] = $db->cleanInfo($row['level']);
							// Free up the result
							$db->freeResult($result);
							// End the connection to the database
							$db->endConnection($con);
							// Redirect the user to the menu view
							header('Location: index.php?type=menu');
							// Exit from the code
							exit();
						}
					}
					// If the username and password do not match one from the database, then free up the result and end connection
					// to the database
					$db->freeResult($result);
					$db->endConnection($con);
					$error = '<p class="logError">' . 'Username or password is incorrect' . '</p>' . PHP_EOL;
				}
			}
			else
			{
				$error = '<p class="logError">' . 'Username and Password must be 4 digits' . '</p>' . PHP_EOL;
			}
		}
	}
		
// Prepare the output to be displayed to the screen
	// If there is errors, display the erros
	if(!empty($error))
	{
		$final = $logForm . $error;
		return $final;
	}
	// The usual output
	else
	{
		$final = $logForm;
		return $final;
	}
		
?>
