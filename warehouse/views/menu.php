<?php

	// Require the functions
	require_once('includes/functions.php');
	
	// Check if the user is logged in
	if(isset($_SESSION['username']))
	{
		// Check if the user has a user level in the session
		if(!isset($_SESSION['level']))
		{
			// If no user level, set it to 3
			$level = 3;
		}
		else
		{
			// Get the user level from the SESSION. 
			$level = htmlspecialchars($_SESSION['level']);
		}
		
		$user = htmlspecialchars($_SESSION['username']);
		// Create a database object and clean up the user value
		$db = createDatabaseObject();
		$user = $db->cleanInfo($user);
		// Get the users first name and last name from the users table
		$fname = $db->getUserValue( 'first_name', $user);
		$lname = $db->getUserValue( 'last_name', $user);
		// End connection to the database
		$db->endConnection($db->getLink());
	}

	// Put toegether the menu and the links
	$menu = '<h3>' . 'Hello ' . htmlentities($fname) . ' ' . htmlentities($lname) . '<br/>' . ' Please choose an option: ' . '</h3>' . '<ul class="menuU">' . PHP_EOL;
	
	// Have check to only add this if the user has level 1 or 2
	if($level == 1)
	{
		$menu .= '<li class="menuL">' . '<a href="index.php?type=addProduct">' . 'Add New Product' . '</a>' .  '</li>' . PHP_EOL;
	}
	
	$menu .= '<li class="menuL">' . '<a href="index.php?type=deliveries">' . 'Deliveries'. '</a>' . '</li>' . PHP_EOL;
	
	$menu .= '<li class="menuL">' . '<a href="index.php?type=returns">' . 'Returns'. '</a>' . '</li>' . PHP_EOL;
	
	$menu .= '<li class="menuL">' . '<a href="index.php?type=titleCheck">' . 'Title Check' . '</a>' . '</li>' . PHP_EOL;
	
	$menu .= '<li class="menuL">' . '<a href="index.php?type=enquiries">' . 'Enquiries'. '</a>' . '</li>' . PHP_EOL;
	
	if($level == 3)
	{
		$menu .= '<li class="menuLast">' . '<a href="index.php?type=transfer">' . 'Transfer Stock'. '</a>' . '</li>' .  PHP_EOL;
	}
	else
	{
		$menu .= '<li class="menuL">' . '<a href="index.php?type=transfer">' . 'Transfer Stock'. '</a>' . '</li>' .  PHP_EOL;
	}
	
	// Have check to only add this if the user has level 1 or 2
	if(($level == 1) || ($level == 2))
	{
		if($level == 2)
		{
			$menu .= '<li class="menuLast">' . '<a href="index.php?type=modify">' . 'Modify Stock/Products'. '</a>' .'</li>'.PHP_EOL;
		}
		else
		{
			$menu .= '<li class="menuL">' . '<a href="index.php?type=modify">' . 'Modify Stock/Products'. '</a>' .  '</li>' .  PHP_EOL;
		}
		
	}
	
	// Have check to only add this if the user has level 1
	if($level == 1)
	{
		$menu .= '<li class="menuLast">' . '<a href="index.php?type=adminTools">' . 'Admin Tools'. '</a>' . '</li>' . PHP_EOL;
	}
	
	$menu .= '</ul>' .  PHP_EOL;
	
	// Return the menu to the screen
	return $menu;
	
?>
