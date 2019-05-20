<?php

// Initialize the content
	$content = '';
	
	// Check to see if user is logged in, by checking if they have a SESSION username which is assigned when the user logs in
	if(isset($_SESSION['username']))
	{
		// Checks to see if there is a type value in the url 
		if (!isset($_GET['type'])) 
		{
			// If there is not a GET type, then display the menu page
			$content = require ('views/menu.php');
		} 
		// Checks to see if a number has been entered into the type value
		else if(is_numeric($_GET['type']))
		{
			// If the get is a number, return the menu
			$content = require ('views/menu.php');
		}
		else
		{
			// Create a variable to store the get type value and clean it up
			$pageType = htmlspecialchars($_GET['type']);
			
			// Get the session username and clean it up
			$cleanUser = htmlspecialchars($_SESSION['username']);
			
			// Check for session user level, if one does not exist, assign it a value of 3
			if(!isset($_SESSION['level']))
			{
				$cleanLevel = 3;
			}
			else
			{
				// Get the session user level
				$cleanLevel = htmlspecialchars($_SESSION['level']);
			}
			
			// Require the functions.php to use functions
			require_once('includes/functions.php');
			
			// Create a database object
			$db = createDatabaseObject();
			$cleanUser = $db->cleanInfo($cleanUser);
			// Check database for the users level, return the level, assign it to $level
			$level = $db->getLevel($cleanUser);
			// Check the database to see if the user does exist in the users table, returns true or false
			$user = $db->checkUser($cleanUser);
			// End the connection to the database
			$db->endConnection($db->getLink());
			
			// If the user does exist in the database, continue on
			if($user == true)
			{
				// Here it compares the $pageType with the views/pages of the app and outputs the correct content
				if($pageType == 'menu')
				{
					$content = require ('views/menu.php');
				}
				else if($pageType == 'addProduct')
				{
					if(($cleanLevel == $level) && ($level == 1))
					{
						$content = require ('views/addProduct.php');
					}
					else
					{
						$content = '<p>' . 'Current user does not have access to this section' . '</p>' . PHP_EOL;
					}
					
				}
				else if($pageType == 'deliveries')
				{
					$content = require ('views/deliveries.php'); 
				}
				else if($pageType == 'returns')
				{
					$content = require ('views/returns.php');
				}
				else if($pageType == 'titleCheck')
				{
					$content = require ('views/titleCheck.php');
				}
				else if($pageType == 'enquiries')
				{
					$content = require ('views/enquiries.php');
				}
				else if($pageType == 'transfer')
				{
					$content = require ('views/transfer.php');
				}
				else if($pageType == 'modify')
				{
					// Needs to check user level for this, need level 1 or 2 and also test if the session user level matches
					// the same as the user level in the databse for that user
					if(($cleanLevel == $level) && (($level == 1) || ($level == 2)))
					{
						$content = require ('views/modify.php');
					}
					else
					{
						$content = '<p>' . 'Current user does not have access to this section' . '</p>' . PHP_EOL;
					}
					
				}
				else if($pageType == 'adminTools')
				{
					// Needs to check user level for this, need level 1 and also test if the session user level matches
					// the same as the user level in the databse for that user
					if(($cleanLevel == $level) && ($level == 1))
					{
						$content = require ('views/adminTools.php'); 
					}
					else
					{
						$content = '<p>' . 'Current user does not have access to this section' . '</p>' . PHP_EOL;
					}
					
				}
				else if($pageType == 'process')
				{
					$content = require ('views/process.php');
				}
				else
				{
					$content = '<p>' . 'Not recognised page' . '</p>' . PHP_EOL;
				}	
			}
			// If the user does not exist in the database but has a session username, make them login
			else
			{
				$content = '<p>' . 'Not recognised user' . '</p>' . PHP_EOL;
			}
		}
	}
	// If the user is not logged in and has no session username, then output the login form
	else
	{
		$content = require ('includes/logInForm.php'); 
	}
		
	// Return the footer to be outputted to the screen
	return $content;

?>