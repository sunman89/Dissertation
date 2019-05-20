<?php
// Require functions
	require_once('includes/functions.php');
	
// Variables
	$checks = 0;
	$headings = '<h3>' . 'Check for information about a product' . '</h3>' . PHP_EOL . '<p>' .
	 'Only need to enter information into one input field and then press the "Check" button' . '</p>';
	 
	 $printLink = '<button id="printPageButton"  onclick="pagePrint()">' .'Print' . '</button>'. PHP_EOL .
				'<p id="printPageInfo">' . 'To print using Firefox = click options menu and then print.' . '<br/>'
				 . 'To print using Google Chrome, right click and press print, or click on file and then print.' . '</p>';
				 
	$keyIndex = "<p>Key: Bar = Barcode, Iss = Issue Number, WH = Warehouse Stock, Sh1 = Shop1 stock, Sh2 = Shop2 stock, FDR = First Delivery Received, LRD = Latest Return Date.";

	// To start the table for the output
	$outputStart = '<div class="smallScreen">' . PHP_EOL . 
					'<table>' . PHP_EOL . 
					'<tr>' . PHP_EOL .
					'<th colspan="4">' . 'Product info' . '</th>' . PHP_EOL .
					'<th colspan="6">' . 'Stock info' . '</th>' . PHP_EOL .
					'<th colspan="2">' . 'Returns Info' . '</th>' . PHP_EOL .
					'</tr>' . PHP_EOL . 
					'<tr>' . PHP_EOL .
					'<th>' . 'Bar' . '</th>' . PHP_EOL .
					'<th>' . 'Iss' . '</th>' . PHP_EOL .
					'<th>' . 'Title' . '</th>' . PHP_EOL .
					'<th>' . 'Price' . '</th>' . PHP_EOL .
					'<th>' . 'WH' . '</th>' . PHP_EOL .
					'<th>' . 'Sh1' . '</th>' . PHP_EOL .
					'<th>' . 'Sh2' . '</th>' . PHP_EOL .
					'<th>' . 'Stock Received' . '</th>' . PHP_EOL .
					'<th>' . 'FDR' . '</th>' . PHP_EOL .
					'<th>' . 'LRD' . '</th>' . PHP_EOL .
					'<th>' . 'Quantity Returned' . '</th>' . PHP_EOL .
					'<th>' . 'Date of Return' . '</th>' . PHP_EOL .
					'</tr>' . PHP_EOL;
					
	// To attach at the end of the output result
	$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
	
	
	// A link to go back to title check and check for other products
	$backLink = '<ul>' . '<li>' . '<a href="index.php?type=titleCheck">' . 'Back to check a different title' . '</a>' . '</li>' . '</ul>';
	
	
	$clean = array();
	$clean['issue'] = '';
	$error = '';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
	$selfDir = htmlspecialchars($_SERVER['REQUEST_URI']);
	
	// Set the variables to use with the form
	$barcode = '';
	$title = '';
	$price = '';
	// Then this it to gather the form inputs and keep them written inside the form so the user can see them
	if($_POST)
	{
		$barcode = $_POST['barcode'];
		$title = $_POST['title'];
		$price = $_POST['price'];
	}
	
	// The title check form
	$titleCheckForm = '<form action="' . $selfDir . '" method="post" id="titleCheckForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Enter details to check for that product: </legend>' . PHP_EOL .
					 
				   '<div>' . PHP_EOL . 
				   '<label for="checkBar">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="checkBar" value="' . $barcode . '" onblur="JSvalidateTitleCheckBar()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpCheckBarcode()" class="helpButton">' . '?' . '</a>' .
				   '<span id="titleCheckFormBarError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . 
				   
					'<div>' . PHP_EOL . 
				   '<label for="checkTitle">Title: </label>' . PHP_EOL . 
				   '<input type="text" name="title" id="checkTitle" value="' . $title . '" onblur="JSvalidateTitleCheckTitle()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpCheckTitle()" class="helpButton">' . '?' . '</a>' .
				   '<span id="titleCheckFormTitleError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' .
				   
					'<div>' . PHP_EOL . 
				   '<label for="checkPrice">Price: £</label>' . PHP_EOL . 
				   '<input type="text" name="price" id="checkPrice" value="' . $price . '" onblur="JSvalidateTitleCheckPrice()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpCheckPrice()" class="helpButton">' . '?' . '</a>' .
				   '<span id="titleCheckFormPriceError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' .
				   
				   '<input type="submit" name="checkTitle" value="Check" />' . PHP_EOL . 
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Put together the main output for display
	$final = $headings . $titleCheckForm;
	
	// Check if user has submitted the form
	if(isset($_POST['checkTitle']))
	{
		// Gather the inputs the user has input into the form
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$clean['title'] = htmlspecialchars($_POST['title']);
		$clean['price'] = htmlspecialchars($_POST['price']);
		$titleCheckDb = createDatabaseObject();
		$con = $titleCheckDb->getLink();
		
		// Check to see if the barcode was not left empty
		if(!empty($clean['barcode']))
		{
			// Test if the barcode is all numbers
			if(is_numeric($clean['barcode']))
			{
				// Check to see if the barcode is equal to 15 characters long
				if(strlen($clean['barcode']) == 15)
				{
					// If it is 15 characters long, then take off the last 2 digits and save them as issue number
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
					// Clean up the inputs ready to use with the database
					$clean['issue'] = $titleCheckDb->cleanInfo($clean['issue']);
					$clean['barcode'] = $titleCheckDb->cleanInfo($clean['barcode']);
				}
				// Check if it is 13 digits long
				else if(strlen($clean['barcode']) == 13)
				{
					$clean['barcode'] = $titleCheckDb->cleanInfo($clean['barcode']);
				}
				else if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Invalid barcode, can not be negative' . '</p>';
				}
				else
				{
					$error .= '<p>' . 'Invalid barcode' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode neeeds to be all numbers' . '</p>';
			}
			
			// Check to see if there is no errors so far
			if(empty($error))
			{
				// Check to see if the barcode actually exists in the products table
				if($titleCheckDb->checkDuplicate('Products', 'barcode', $clean['barcode']))
				{
					if(!empty($clean['issue']))
					{
						if(!$titleCheckDb->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
						{
							$error .= '<p>' . 'That barcode does not exist on the stock database, add it to delivery first' . '</p>';
						}
					}
					$checks++;
				}
				else
				{
					$error .= '<p>' . 'That barcode does not exist on the database, add it to database first' . '</p>';
				}
			}
		}
		// Check to see if the title input was not empty
		if(!empty($clean['title']))
		{	
			if(is_string($clean['title']))
			{
				$clean['title'] = $titleCheckDb->cleanInfo($clean['title']);
				$checks++;
			}
			else
			{
				$error .= '<p>' . 'The title needs to be text, and can include numbers' . '</p>';
			}
		}
		// Check to see if the price input was not empty
		if(!empty($clean['price']))
		{
			if(is_numeric($clean['price']))
			{
				if($clean['price'] < 0)
				{
					$error .= '<p>' . 'Invalid price, can not be negative' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Price neeeds to be numeric in format &pound;0.00' . '</p>';
			}
			// Clean up price for use in the database
			$clean['price'] = $titleCheckDb->cleanInfo($clean['price']);
			// If no errors so far
			if(empty($error))
			{
				// Check to see if that price exists in the products table
				if(!$titleCheckDb->checkDuplicate('Products', 'price', $clean['price']))
				{
					$error .= '<p>' . 'No product has that price' . '</p>';
				}
				else
				{
					$checks++;
				}	
			}
		}
		
		// If checks is more than 1, then produce an error message, users can only enter one valid input into the form and
		// submit it, otherwise it will fail
		if($checks > 1)
		{
			$error .= '<p>' . 'Only enter a valid value into one input from: Barcode, Title, Price.' . '</p>';
		}
	
		// If checks is equal to 1 and no errors, then proceed to get the product information
		if(($checks == 1) && (empty($error)))
		{
			// Gather all the information for the valid input that the user has entered into the form and store it into a variable
			$outputResult = $titleCheckDb->gatherAllData($clean['barcode'], $clean['issue'], $clean['price'], $clean['title']);
			// Checks to see if the query has returned a result to output
			if($outputResult == false)
			{
				$error .= '<p>' . 'An error occurred trying to gather the info you requested' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Need to enter values into one input field' . '</p>';
		}
	// end connection to database
	$titleCheckDb->endConnection($con);
	}
	
// To display outputs
	// For if there was a result
	if(!empty($outputResult))
	{
		return $backLink . $printLink . $keyIndex . $outputStart . $outputResult . $outputEnd;
	}
	// Display errors
	else if(!empty($error))
	{
		return $final . $errorStart . $error;
	}
	// Display normal page
	else
	{
		return $final;
	}

?>