<?php

	// Require functions
	require_once('includes/functions.php');
	
	// variables
	$clean = array();
	$content = '';
	$error = '';
	$complete = '';
	$headings = '<h3>' . 'Input returns, one product at a time' . '</h3>' . PHP_EOL .
		 '<p>' . 'Need to enter a valid 15 digit Barcode, then select the location from which you are returning the stock from and finally enter the quantity that you are returning for that location.' . '<br/>' . 'Once entered everything correctly, press the "Confirm Return" button' . '</p>';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
	
	// To store the Url to submit form to same page
	$self = htmlspecialchars($_SERVER["PHP_SELF"]) . "?type=returns";
	
	// Get the content and complete and errors from the url and display to user
	if(isset($_GET['content'])) 
	{
		$content = '<p>' . nl2br(htmlentities($_GET['content'])) . '</p>';
	} 
	if(isset($_GET['complete'])) 
	{
		$complete = '<p>' . nl2br(htmlentities($_GET['complete'])) . '</p>';
	} 
	if(isset($_GET['error'])) 
	{
		$error = '<p>' . nl2br(htmlentities($_GET['error'])) . '</p>';
	} 
	
	// Set variables to use with form
	$barcode = '';
	$quantity = '';
	// Then this it to gather the form inputs and keep them written inside the form so the user can see them
	if($_POST)
	{
		$barcode = $_POST['barcode'];
		$quantity = $_POST['quantity'];
	}
	
	// To check if their is a record in the returns table with the same barcode, issue and return_date that is todays date
	// To decide whether to insert a new record if false, or update the existing record if true
	$todaysDateCheck = false;	
		
	// Form data
	$returnsForm = '<form action="' . $self . '" method="post" id="addReturnsForm">' . PHP_EOL .
					'<fieldset>' . PHP_EOL .
					'<legend>Enter details of the returns, one at a time: </legend>' . PHP_EOL . 
					'<div>' . PHP_EOL . 
					'<label for="returnsBar">Barcode: </label>' . PHP_EOL . 
					'<input type="text" name="barcode" id="returnsBar" value="' . $barcode . '" onblur="JSvalidateReturnsBar()"/>' . PHP_EOL . 
					'<a href="#" onclick="helpReturnsBarcode()" class="helpButton">' . '?' . '</a>' .
					'<span id="returnsFormBarError" class="errorJS">' . '</span>' . PHP_EOL . 
					'</div>' . PHP_EOL . 
					'<br/>' . PHP_EOL . 
					'<div id="returnsSelect">' . PHP_EOL . 
					'<label for="returnsLocation">Return from location: </label>' . PHP_EOL . 
					'<select name="location" id="returnsLocation">' . PHP_EOL . 
					   '<option value="Warehouse">Warehouse</option>' . PHP_EOL . 
					   '<option value="Shop1">Shop1</option>' . PHP_EOL . 
					   '<option value="Shop2">Shop2</option>' . PHP_EOL . 
					'</select>' . PHP_EOL . 
					'<a href="#" onclick="helpReturnsLocation()" class="helpButton">' . '?' . '</a>' . PHP_EOL . 
					'</div>' . PHP_EOL . 
					'<br/>' . 
					'<div>' . PHP_EOL . 
					'<label for="returnedQuantity">Return Quantity: </label>' . PHP_EOL . 
					'<input type="text" name="quantity" id="returnedQuantity" value="' . $quantity . '" onblur="JSvalidateReturnsQuantity()"/>' . PHP_EOL . 
					'<a href="#" onclick="helpReturnsQuantity()" class="helpButton">' . '?' . '</a>' .
					'<span id="returnsFormQuantityError" class="errorJS">' . '</span>' . PHP_EOL . 
					'</div>' . PHP_EOL . 
					'<br/>' . PHP_EOL . 
					'<input type="submit" name="addReturnsToTable" value="Confirm Return" />' . PHP_EOL . 
					'</fieldset>' . PHP_EOL . 
					'</form>' . PHP_EOL;
					
	// Put together to content
	$final = $headings . $returnsForm;
	
	// First check if form is submitted
	if(isset($_POST['addReturnsToTable']))
	{
		// Clean up inputs and get the current date
		$clean['date'] = getCurrentDate();
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$clean['quantity'] = htmlspecialchars($_POST['quantity']);
		$clean['location'] = htmlspecialchars($_POST['location']);
		$clean['issue'] = '';
		
		// Check if barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if the barcode is a negative number
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Barcode needs to not be a negative number' . '</p>';
				}
				// Check if the barcode is 15 digits long
				if(strlen($clean['barcode']) == 15)
				{
					// Need to get issue number first from barcode
					$clean['issue'] = substr($clean['barcode'],13,15);
					// Then cut barcode down to 13 digits
					$clean['barcode'] = substr($clean['barcode'],0, 13);
				}
				else
				{
					$error .= '<p>' . 'Barcode needs to be 15 digits long' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode neeeds to be all numbers' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Barcode can not be empty' . '</p>';
		}
		
		// Check if quantity is not empty
		if(!empty($clean['quantity']))
		{
			// Check if quantity is numeric
			if(is_numeric($clean['quantity']))
			{
				// Check if quantity is a negative number
				if($clean['quantity'] <= 0)
				{
					$error .= '<p>' . 'Quantity can not be a negative number or zero' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Quantity needs to be numeric'. '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Quantity can not be empty' . '</p>';
		}
		
		// Check if the location selected is not empty
		if(!empty($clean['location']))
		{
			// Check to make sure location is not different to the three available to select
			$locationCheck = 0;
			if($clean['location'] == "Shop1")
			{
				$locationCheck ++;
			}
			else if($clean['location'] == "Shop2")
			{
				$locationCheck ++;
			}
			else if($clean['location'] == "Warehouse")
			{
				$locationCheck ++;
			}
			
			if($locationCheck != 1)
			{
				$error .= '<p>' . 'Location has to be either Shop1, Shop2, Warehouse' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Location can not be empty for this form' . '</p>';
		}
		
		// If no errors, proceed
		if(empty($error))
		{
			// Create database object
			$returnsDb = createDatabaseObject();
			$con = $returnsDb->getLink();
			// Clean up the values to be used with the database
			$clean['barcode'] = $returnsDb->cleanInfo($clean['barcode']);
			$clean['issue'] = $returnsDb->cleanInfo($clean['issue']);
			$clean['quantity'] = $returnsDb->cleanInfo($clean['quantity']);
			$clean['date'] = $returnsDb->cleanInfo($clean['date']);
			// Get the correct location value for use in the database
			$clean['location'] = getCorrectLocation($clean['location']);
			$clean['location'] = $returnsDb->cleanInfo($clean['location']);
			
			// Check if a product exists with the barcode in products table
			if($returnsDb->checkDuplicate('Products', 'barcode', $clean['barcode']))
			{
				// Check if the stock does not exist in the stock table
				if(!$returnsDb->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
				{
					$error .= '<p>' . 'That product has no stock in the database' . '</p>';
				}
				else
				{
					// Get the quantity of the stock for that barcode, at the specified location
					$stockCurrent = $returnsDb->getStock($clean['location'], $clean['barcode'], $clean['issue'], 'Stock');
					
					// Check if it failed to get stock for that product at that location 
					if($stockCurrent == false)
					{
						$error .= '<p>' . 'That product has no stock in ' . htmlentities($clean['location']) . '</p>';
					}
					// If it did manage to get the stock quantity, then see if that is less than the quantity being returned if it is
					// not less than the quantity being returned, current stock will become a negative number so produce an error
					else if($stockCurrent < $clean['quantity'])
					{
						$error .= '<p>' . 'That product has ' . htmlentities($stockCurrent) . ' in ' . htmlentities($clean['location']) .
						 ' therefore the quantity of ' . htmlentities($clean['quantity']) .
						 ' can not be returned, you have to return either all or less than the stock that exists' . '</p>';
					}
				}
			}
			else
			{
				$error .= '<p>' . 'That product does not exist on database, add it to database first' . '</p>';
			}
		
			// Check to see if the stocks return date is less than the current date, so the stock should be returned
			if(!$returnsDb->checkCurrentToReturnDate('Stock', 'return_date', $clean['date'], $clean['barcode'], $clean['issue']))
			{
				$content .= 'This product is being returned early.' . '%0A';
			}
			// Checks to see if a record already exists in the returns table for all the values given
			if($returnsDb->checkDuplicateIssueDate('Returns', 'return_date', $clean['barcode'], $clean['issue'], $clean['date']))
			{
				// This means that a record does exist for today, so should update this record instead of adding a new record
				$todaysDateCheck = true;
			}
			
			// If still no errors, continue to add the returns to the returns table and take the quantity away from the stock table
			if(empty($error))
			{
				// Check to see if a record already exists for todays date
				if($todaysDateCheck == true)
				{
					// Then update the table instead of insert a new record
					if($returns = $returnsDb->updateReturns($clean['barcode'], $clean['issue'], $clean['quantity'], $clean['date']))
					{
						// Update was successful, save a message to display to user
						$complete .= 'Returns has been updated for barcode "' . htmlentities($clean['barcode']) . htmlentities($clean['issue']) .
					  '" and quantity "' . htmlentities($clean['quantity']) . '" has now been added to the returns from "' .
					   htmlentities($_POST['location']) . '".' . '%0A';
					 	// need to take off from stock table as well
						if($stock = $returnsDb->removeStock($clean['barcode'], $clean['issue'],
						 $clean['location'], $clean['quantity']))
						 {
							 $content .= 'Stock successfully changed' . '%0A';
						 }
						 else
						 {
							 $error .= '<p>'.'Failed to remove from stock' . '</p>';
						 }
					}
					else
					{
						$error .= '<p>'.'Failed to update record and remove from stock' . '</p>';
					}
				}
				else
				{
					// If a record does not already exist for todays date, then insert it into the table
					if($returns =  $returnsDb->addReturns($clean['barcode'], $clean['issue'], $clean['quantity'], $clean['date']))
					{
						$complete .= 'Return has been added with barcode "' . htmlentities($clean['barcode']) . htmlentities($clean['issue']) .
					 '" and Return quantity is now "' . htmlentities($clean['quantity']) . '" from location "' . htmlentities($_POST['location']) .
					  '".' . '%0A';
						// need to take off from stock table as well
						if($stock = $returnsDb->removeStock($clean['barcode'], $clean['issue'],
						 $clean['location'], $clean['quantity']))
						 {
							 
							 $content .= 'Stock successfully changed' . '%0A';
						 }
						 else
						 {
							 $error .= '<p>'.'Failed to remove from stock' . '</p>';
						 }
					}
					else
					{
						$error .= '<p>' .'Failed to insert new record and remove from stock' . '</p>';
					}
				}
				// Check if everything succeeded without errors, if so redirect to page with no errors
				if(empty($error))
				{
					// end connection
					$returnsDb->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&complete=" . $complete . "&&content=" . $content;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// end connection
			$returnsDb->endConnection($con);
		}
	}
	
// Prepare the output to be displayed to the screen
	// If there is errors, display the erros
	if(!empty($error))
	{
		if(!empty($complete))
		{
			return $final . $complete . $content . $errorStart . $error;
		}
		return $final . $errorStart . $error;
	}
	// If the product was successfully added, then tell the user it was added
	else if(!empty($complete))
	{
		return $final . $complete . $content;
	}
	// The usual output
	else
	{
		return $final;
	}
	
?>