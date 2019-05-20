<?php

	// Initialize the header
	$header = '';
	
	// Javascript message for if javascript is turned off
	$javaDisclaimer = '<noscript>' . '<p>' . 
	 'For full functionality of this site it is necessary to enable JavaScript.
	 Here are the' .  '<a href="http://www.enable-javascript.com/">' . '
	 instructions how to enable JavaScript in your web browser' . '</a>' . '</p>' . '</noscript>' . PHP_EOL;

	// Check if user is logged in
	if(isset($_SESSION['username']))
	{
		// Checks to make sure that a value is typed inside the url that is 'type'
		if (!isset($_GET['type'])) 
		{
			// Here have default main menu
			$header = '<h1>' . 'Main Menu' . '</h1>' . PHP_EOL;  
		} 
		// Checks to see if a number has been entered into the get type value
		elseif(is_numeric($_GET['type']))
		{
			// Here have default main menu
			$header = '<h1>' . 'Main Menu' . '</h1>' . PHP_EOL;  
		}
		else
		{
			// Clean up the GET type
			$cleanTypeHeader = htmlspecialchars($_GET['type']);
			
			// Checks to see what the variable pageType value is, and outputs the correct header for that page/view
			if($cleanTypeHeader == 'menu')
			{
				$header = '<h1>' . 'Main Menu' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'addProduct')
			{
				$header = '<h1>' . 'Add Product' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'deliveries')
			{
				$header = '<h1>' . 'Add Deliveries' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'returns')
			{
				$header = '<h1>' . 'Add returns' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'titleCheck')
			{
				$header = '<h1>' . 'Title Check' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'enquiries')
			{
				$header = '<h1>' . 'Enquiries' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'transfer')
			{
				$header = '<h1>' . 'Transfer Products' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'modify')
			{
				$header = '<h1>' . 'Modify' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'adminTools')
			{
				$header = '<h1>' . 'Admin Tools' . '</h1>' . PHP_EOL; 
			}
			else if($cleanTypeHeader == 'process')
			{
				$header = '<h1>' . 'Here is the information you requested' . '</h1>' . PHP_EOL; 
			}
			else
			{
				$header = '<h1>' . 'Sorry but the URL is not recognised' . '</h1>' . PHP_EOL; 
			}
		}
	}
	else
	{
		$header = '<h1>' . 'Log In' . '</h1>'; 
	}
	
	// Returns the header to the function call to be displayed on the screen
	return $javaDisclaimer . $header;

?>