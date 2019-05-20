<?php
// Require functions
	require_once('includes/functions.php');
// Variables
	$clean = array();
	$output = '';
	$error = '';
	$headings = '<h3>' . 'Transfer stock from warehouse to one of the shops' . '</h3>' . PHP_EOL .
	 '<p>' . 'Need to enter a valid 15 digit Barcode, then select the shop that you are moving the stock to and then enter the quantity being moved' . '<br/>' . 'Once entered everything correctly, press the "Confirm Transfer" button' . '</p>';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
	
	// To store the Url to submit form to same page
	$self = htmlspecialchars($_SERVER["PHP_SELF"]) . "?type=transfer";
	
	// Get the content and complete and errors from the url and display to user
	if(isset($_GET['output'])) 
	{
		$output = '<p>' . nl2br(htmlentities($_GET['output'])) . '</p>';
	}  
	if(isset($_GET['error'])) 
	{
		$error = '<p>' . nl2br(htmlentities($_GET['error'])) . '</p>';
	} 
	
	// Set the variables to use with the form
	$barcode = '';
	$quantity = '';
	// Then this it to gather the form inputs and keep them written inside the form so the user can see them
	if($_POST)
	{
		$barcode = $_POST['barcode'];
		$quantity = $_POST['quantity'];
	}

	// The transfer form to be displayed
	$transferForm = '<form action="' . $self . '" method="post" id="transferStockForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Enter the details to transfer stock from warehouse: </legend>' . PHP_EOL . 
				   
				   '<div>' . PHP_EOL . 
				   '<label for="transferBar">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="transferBar" value="' . $barcode . '" onblur="JSvalidateTransferBar()"
				   onchange="gatherBarcodeInfo(this.value)"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpTransferBarcode()" class="helpButton">' . '?' . '</a>' .
				   '<span id="transferFormBarError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . 
			
				   '<div id="transferLocationSelect">' . PHP_EOL . 
				   '<label for="transferLocation">Transfer to: </label>' . PHP_EOL . 
				   '<select name="location" id="transferLocation">' . PHP_EOL . 
					   '<option value="Shop1">Shop1</option>' . PHP_EOL . 
					   '<option value="Shop2">Shop2</option>' . PHP_EOL . 
				   '</select>' . PHP_EOL . 
				   '<a href="#" onclick="helpTransferLocation()" class="helpButton">' . '?' . '</a>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . 
				   
				   '<div>' . PHP_EOL . 
				   '<label for="transferQuantity">Quantity: </label>' . PHP_EOL . 
				   '<input type="text" name="quantity" id="transferQuantity" value="' . $quantity . '" onblur="JSvalidateTransferQuantity()"/>' .
				    PHP_EOL . 
				   '<a href="#" onclick="helpTransferQuantity()" class="helpButton">' . '?' . '</a>' .
				   '<span id="transferFormQuantityError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   
				   '<input type="submit" name="addTransferToTable" value="Confirm Transfer" />' . PHP_EOL . 
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	$jSDisplay = '<div id="transferProductInformation"></div>';
	// Main content put together
	$final = $headings . $transferForm;
			  
			   
	// Check if the user has pressed the submit button on the form
	// If yes then test the inputs
	if(isset($_POST['addTransferToTable']))
	{
		// Clean up the inputted values and store them into the $clean array
		$clean['location'] = htmlspecialchars($_POST['location']);
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$clean['quantity'] = htmlspecialchars($_POST['quantity']);
		
		// Check if the barcode input is not empty, if it is, then save the error
		if(!empty($clean['barcode']))
		{
			// Check if barcode is numeric, if not then save the error
			if(is_numeric($clean['barcode']))
			{
				// Check if the barcode is 15 characters length, if not save the error
				if(strlen($clean['barcode'])== 15)
				{
					// If the barcode is 15 digits long, then get the issue number from it, which is the last two digits
					// and store them into the $clean array as 'issue'
					$clean['issue'] = getIssueNumber($clean['barcode']);
					// Then save the first 13 digits of the barcode as the main barcode, the first 13 digits represent the
					// product code
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Barcode must be 15 digits long' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode must be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Can not have empty barcode' . '</p>';
		}
		
		// Checks to see if the quantity input is not empty, if it is, then save the error
		if(!empty($clean['quantity']))
		{
			// Checks to see if quantity is not numeric, if it is, then save the error
			if(!is_numeric($clean['quantity']))
			{
				$error .= '<p>' . 'Quantity must be numeric' . '</p>';
			}
			// Checks to see if the number inputted, is a positive number, this is to stop negative inputs
			if($clean['quantity'] < 0)
			{
				$error .= '<p>' . 'Quantity must be a positive number' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Can not have quantity empty' . '</p>';
		}
		
		// Checks to see what location the user selected, and then saves the correct value to use with the database queries
		if($clean['location'] == 'Shop1')
		{
			$clean['location'] = 'shop1_stock';
		}
		else if($clean['location'] == 'Shop2')
		{
			$clean['location'] = 'shop2_stock';
		}
		else
		{
			$error .= '<p>' . 'Invalid location to transfer to' . '</p>';
		}
		
		// If no errors so far with the inputs, continue to the next part and test with the database
		if(empty($error))
		{
			// Now create a database object, to connect to the database and access the database class methods
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean the values, ready to use with the database
			$clean['location'] = $db->cleanInfo($clean['location']);
			$clean['barcode'] = $db->cleanInfo($clean['barcode']);
			$clean['quantity'] = $db->cleanInfo($clean['quantity']);
			$clean['issue'] = $db->cleanInfo($clean['issue']);
			
			// Check if the product exists in the products table by checking if the barcode exists
			if(!$db->checkDuplicate('Products', 'barcode', $clean['barcode']))
			{
				$error .= '<p>' . 'That product does not exist in the database, add it to database first' . '</p>';
			}
			else
			{
				// Check if stock exists in the Stock table to be able to transfer using the barcode and issue number
				if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
				{
					$error .= '<p>' . 'Stock does not exist for that barcode, add stock first using add delivery' . '</p>';
				}
				else
				{
					// Make a variable to store the stock quantity for stock in the warehouse 
					$clean['stock'] = $db->getStock('warehouse_stock', $clean['barcode'], $clean['issue'], 'Stock');
					if($clean['stock'] == false)
					{
						$error .= '<p>' . 'That product has no stock in warehouse' . '</p>';
					}
					else if($clean['stock'] == 0)
					{
						$error .= '<p>' . 'That product has no stock in warehouse' . '</p>';
					}
					
					// Check to see if the quantity being transferred is more than available
					// in the warehouse, so warehouse stock will become negative
					if($clean['quantity'] > $clean['stock'])
					{
						$error .= '<p>' . 'Quantity of ' . htmlentities($clean['quantity']) .
						 '. Is more than the quantity available in the warehouse, which is ' . htmlentities($clean['stock']) .
						  '. For the product with barcode = ' . htmlentities($clean['barcode']) . htmlentities(displayIssue($clean['issue'])) . '.' . '</p>';
					}
				}	
			}
			
			// If there has been no errors so far, then continue and try to transfer the stock to the shop selected
			if(empty($error))
			{
				// Try transferring the stock to the shop chosen, with the quantity chosen, for the barcode and issue number
				if($db->transferStock($clean['barcode'], $clean['issue'], $clean['location'], $clean['quantity']))
				{
					// Put together a results output to display to the user, telling them the transfer was successful
					$output = 'Successfully Transferred Product with barcode = ' . htmlentities($clean['barcode']) .
					 htmlentities(displayIssue($clean['issue'])) . ' , from Warehouse to ' . htmlentities($_POST['location']) .
					  ' , with quantity of ' . htmlentities($clean['quantity']) . '.';
				}
				else
				{
					// Transfer failed, save the error to display
					$error .= '<p>' . 'Could not transfer stock' . '</p>';
				}
				
				if(empty($error))
				{
					// End connection to the database
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// End connection to the database
			$db->endConnection($con);
		}
	}
	
// To output everything
	// If has a good result
	if(!empty($output))
	{
		return $final . $output . $jSDisplay;
	}
	// If has errors
	else if(!empty($error))
	{
		return $final . $errorStart . $error .  $jSDisplay;
	}
	// Normal display
	else
	{
		return $final . $jSDisplay;
	}
	
?>