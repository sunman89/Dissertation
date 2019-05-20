<?php
	
	// Require functions
	require_once('includes/functions.php');
	
	// Variables
	$clean = array();
	$error = '';
	$content = '';
	$complete = '';
	// This is to initialise the form inputs at first
	$barcode = '';
	$quantity = '';
	// Then this it to gather the form inputs and keep them written inside the form so the user can see them
	if($_POST)
	{
		$barcode = $_POST['barcode'];
		$quantity = $_POST['quantity'];
	}
	
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
	
	$headings = '<h3>' . 'Add a delivery one product at a time' . '</h3>' . PHP_EOL .
		 '<p>' . 'Need to enter a valid 15 digit Barcode, then enter the quantity that was delivered. Once entered everything correctly, press the "Add Delivery" button' . '</p>';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
	// To store the Url to submit form to same page
	$self = htmlspecialchars($_SERVER["PHP_SELF"]) . "?type=deliveries";
	
	// Check if a record already exists in delivery table for that product for todays date
	$todaysDateCheck = false;
		
	// Form data
	$addDeliveryForm = '<form action="' . $self . '" method="post" id="addDeliveryForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Enter details of the delivery, one at a time: </legend>' . PHP_EOL . 
				   '<div>' . PHP_EOL . 
				   '<label for="deliveryBar">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="deliveryBar" value="'. htmlentities($barcode) .
				   '" onblur="JSvalidateDeliveryBar()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpDeliveryBarcode();" class="helpButton">' . '?' . '</a>' .
				   '<span id="deliveryFormBarError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '<div>' . PHP_EOL . 
				   '<label for="deliveryQuantity">Delivered Quantity: </label>' . PHP_EOL . 
				   '<input type="text" name="quantity" id="deliveryQuantity" value="' . htmlentities($quantity) .
				    '" onblur="JSvalidateDeliveryQuantity()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpDeliveryQuantity();" class="helpButton">' . '?' . '</a>' .
				   '<span id="deliveryFormQuantityError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="addDeliveryToTable" value="Add Delivery" />' . PHP_EOL . 
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Prepare output for display
	$final = $headings . $addDeliveryForm;
	
	// First check if form is submitted
	if(isset($_POST['addDeliveryToTable']))
	{
		// Clean up inputs and get todays date, and get the date for the products stock to be returned
		$clean['date'] = getCurrentDate();
		$clean['return'] = getReturnDate($clean['date']);
		$clean['barcode'] = htmlspecialchars(($_POST['barcode']));
		$clean['quantity'] = htmlspecialchars(($_POST['quantity']));
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
		
		// If no errors then continue
		if(empty($error))
		{
			// Create database object
			$deliveryDb = createDatabaseObject();
			$con = $deliveryDb->getLink();
			// Clean up the values, ready to use with the database
			$clean['barcode'] = $deliveryDb->cleanInfo($clean['barcode']);
			$clean['issue'] = $deliveryDb->cleanInfo($clean['issue']);
			$clean['quantity'] = $deliveryDb->cleanInfo($clean['quantity']);
			$clean['date'] = $deliveryDb->cleanInfo($clean['date']);
			$clean['return'] = $deliveryDb->cleanInfo($clean['return']);
			
			// Check if a product exists with the barcode in products table
			if($deliveryDb->checkDuplicate('Products', 'barcode', $clean['barcode']))
			{
				// Check if the stock return date is before the current date, so should tell the user this
				if($deliveryDb->checkCurrentToReturnDate('Stock', 'return_date', $clean['date'], $clean['barcode'], $clean['issue']))
				{
					$date = $deliveryDb->getDate('Stock', 'return_date', $clean['barcode'], $clean['issue']);
					$content .= 'The product has been delivered past the return date. Which is = ' 
					. htmlentities($date) . '. So please do the returns for this product later today' . '%0A';
				}
				// Check to see if there is a record in the deliveries table, for the barcode and todays date
				if($deliveryDb->checkDuplicateIssueDate('Deliveries', 'delivered_date', $clean['barcode'], $clean['issue'],
				 $clean['date']))
				{
					// A record already exists in the deliveries table with the same barcode and todays date
					$todaysDateCheck = true;
				}
			}
			else
			{
				$error .= '<p>' . 'That product does not exist on database, add it to database first' . '</p>';
			}
			
			// If errors is still empty, continue to add the values into the deliveries table and stock table
			if(empty($error))
			{
				// Check to see if the values are already in the stock table
				if($deliveryDb->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
				{
					// Update the stock table by adding the new quantity
					if($stock = $deliveryDb->updateDelivery($clean['barcode'], $clean['issue'], $clean['quantity']))
					{
						$complete .= 'Stock has been updated for barcode "' . htmlentities($clean['barcode']) . htmlentities($clean['issue']) .
						'" and quantity "' . htmlentities($clean['quantity']) . '" has now been added to Warehouse stock' . '%0A';
					}
					else
					{
						$error .= '<p>'.'Failed to update the stock table' . '</p>';
					}
				}
				else
				{
					// if it doesnt exist, insert it into the table
					if($stock = $deliveryDb->addDelivery($clean['barcode'], $clean['issue'], $clean['quantity'], $clean['date'],
					 $clean['return']))
					 {
						 $complete .= 'Delivery has been added with barcode "' . htmlentities($clean['barcode']) .
						  htmlentities($clean['issue']) . '" and Warehouse quantity is now ' . htmlentities($clean['quantity']) . '%0A';
					 }
					 else
					 {
						 $error .= '<p>'.'Failed to insert values into the stock table' . '</p>';
					 }
				}
				// check if their already exists a record in deliveries table with todays date
				if($todaysDateCheck == true && empty($error))
				{
					// try and update the delivery table
					if($delivery = $deliveryDb->updateDeliveryTable($clean['barcode'], $clean['issue'], $clean['quantity']))
					{
						$content .= 'Deliveries table successfully updated' . '%0A';
					}
					else
					{
						$error .= '<p>'.'Failed to update the deliveries table' . '</p>';
					}
				}
				else
				{
					// Try and add to the delivery table
					if($delivery = $deliveryDb->addDeliveryToTable($clean['barcode'], $clean['issue'], $clean['quantity'],
					 $clean['date']))
					{
						$content .= 'Values successfully added to the deliveries table' .  '%0A';
					}
					else
					{
						$error .= '<p>'.'Failed to add the values to the deliveries table' . '</p>';
					}
				}
			
				if(empty($error))
				{
					// End connection to database
					$deliveryDb->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&complete=" . $complete . "&&content=" . $content;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();
				}
			}
			// End connection to database
			$deliveryDb->endConnection($con);
		}
	}

// Prepare the output to be displayed to the screen
	// If there is errors, display the erros
	if(!empty($error))
	{
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