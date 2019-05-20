<?php

// Initialize the footer
	$footer = '';
	
	// Check to see if their exists a Session username
	if(isset($_SESSION['username']))
	{
		// Checks to see if there is a type value in the url 
		if (!isset($_GET['type'])) 
		{
			$footer = '<ul>' .'<li class="exit">' . '<a href="includes/exit.php">' .  'Log Off'. '</a>'  . '</li>' . '</ul>'; 
		} 
		// Checks to see if a number has been entered into the type value
		elseif(is_numeric($_GET['type']))
		{
			$footer = '<ul>' .'<li class="exit">'. '<a href="includes/exit.php">' .  'Log Off'. '</a>'  . '</li>' . '</ul>';
		}
		else
		{
			// Create a variable to store the get type value
			$cleanTypeFooter = htmlspecialchars($_GET['type']);
			
			// Create a basic footer variable, to use for most pages
			$basicFooter = '<ul>' . PHP_EOL .  '<li class="exit">'.'<a href="includes/exit.php">' .  'Log Off'. '</a>'  . '</li>'
				. PHP_EOL  .'<li class="back">'. '<a href="index.php?type=menu">' .  'Back' . '</a>' . '</li>' .
				 PHP_EOL . '</ul>' . PHP_EOL;
			
			// Here it compares the $pageType with the views/pages of the app
			if($cleanTypeFooter == 'menu')
			{
				$footer = '<ul>'  .'<li class="exit">'. '<a href="includes/exit.php">'  . 'Log Off'. '</a>'  . '</li>' . '</ul>';
			}
			else if($cleanTypeFooter == 'addProduct')
			{
				$footer = $basicFooter;
			}
			else if($cleanTypeFooter == 'deliveries')
			{
				$footer = $basicFooter; 
			}
			else if($cleanTypeFooter == 'returns')
			{
				$footer = $basicFooter; 
			}
			else if($cleanTypeFooter == 'titleCheck')
			{
				$footer = $basicFooter; 
			}
			else if($cleanTypeFooter == 'enquiries')
			{
				$footer = $basicFooter;
			}
			else if($cleanTypeFooter == 'transfer')
			{
				$footer = $basicFooter;
			}
			else if($cleanTypeFooter == 'modify')
			{
				$footer = $basicFooter;
			}
			else if($cleanTypeFooter == 'adminTools')
			{
				$footer = $basicFooter;
				// Check to see if the user has accessed the all users enquiry
				if (isset($_GET['enquiry'])) 
				{
					$cleanEnquiryFooter = htmlspecialchars($_GET['enquiry']);
					// If the user is currently on the all users enquiry page, then change the back button, to take the 
					// user back to the adminTools page
					if($cleanEnquiryFooter == 'allUsers')
					{
						$footer = '<ul>' . PHP_EOL  .  '<li class="exit">'.'<a href="includes/exit.php">' .  'Log Off'. '</a>' .
						 '</li>' . PHP_EOL  .'<li class="back">'. '<a href="index.php?type=adminTools">' .
						 'Back'. '</a>'   . '</li>'. PHP_EOL . '</ul>' . PHP_EOL;
					}
				} 
			}
			else if($cleanTypeFooter == 'process')
			{
				// Need to alter the footer, because all the enquiries links, link to the process page, so need to change the back
				// button to go back to enquiries page
				$footer = '<ul>' . PHP_EOL  .  '<li class="exit">'.'<a href="includes/exit.php">' .  'Log Off'. '</a>'  . '</li>' .
				 PHP_EOL  .'<li class="back">'. '<a href="index.php?type=enquiries">' .  'Back'. '</a>'  .
				  '</li>' . PHP_EOL . '</ul>' . PHP_EOL;
			}
			else
			{
				$footer = '<ul>' . PHP_EOL  .  '<li class="exit">'.'<a href="index.php?type=menu">' .  'Return to menu/login screen' 
				.'</a>' . '</li>' . PHP_EOL . '</ul>' . PHP_EOL;
			}
		}
	}
	// To exit the app, when on the login screen
	else
	{
		$footer = '<ul>'  .'<li class="exit">'. '<a href="#" onclick="closeWin();">' .  'Exit'. '</a>'  . '</li>' . '</ul>';  
	}
	
	// Retunrn the footer to be outputted to the screen
	return $footer;

?>