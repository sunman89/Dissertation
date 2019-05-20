<?php
	
	// Require functions
	require_once('includes/functions.php');
	
	// Initiliase variables
	$clean = array();
	$output = '';
	$error = '';
	$errorHeading = '';
	$headings = '<h3>' . 'Select what you would like to modify: ' . '</h3>'. PHP_EOL;
	$errorStart = '<h5>' . 'Errors:' . '</h5>';
	
	$self = htmlspecialchars($_SERVER["PHP_SELF"]) . "?type=modify";
	
	// Get the content and complete and errors from the url and display to user
	if(isset($_GET['output'])) 
	{
		$output = '<p>' . nl2br(htmlentities($_GET['output'])) . '</p>';
	} 
	if(isset($_GET['errorHeading'])) 
	{
		$errorHeading = '<h4>' . nl2br(htmlentities($_GET['errorHeading'])) . '</h4>';
	} 
	
	// A select input used with JavaScript to display the form selected
	$selectModify = '<select id="modifySelect" onchange="showModify()">' . PHP_EOL . 
					'<option value="shopStock">Modify Shop Stock' . '</option>' . PHP_EOL .
					'<option value="returns">Modify Returns' . '</option>' . PHP_EOL .
					'<option value="delivery">Modify Delivery' . '</option>' . PHP_EOL .
					'<option value="stock">Modify Stock' . '</option>' . PHP_EOL .
					'<option value="delete">Delete Record' . '</option>' . PHP_EOL .
					'</select>' . PHP_EOL; 
	
	// Modify Stock In Shops form
	$updateStockForm = '<form action="' . $self . '" method="post" id="stockShopForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify Stock in Shops: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the barcode of product you want to modify on this side</p>' . 
				   '<div>' . 
				   '<label for="modifyStockBar">Barcode:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyStockBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockBarcode()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '<div>' . 
				   '<label for="modifyStockLocation">Shop select: </label>' . PHP_EOL . 
				   '<select name="location" id="modifyStockLocation">' . PHP_EOL . 
					   '<option value="Shop1">Shop1</option>' . PHP_EOL . 
					   '<option value="Shop2">Shop2</option>' . PHP_EOL . 
				   '</select>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockLocation()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' .  PHP_EOL .
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' .  
					'<div>' . 
				   '<label for="modifyStockQuantityChange" class="modifyStockQuantity">Quantity to be changed by: </label>' 
				   . PHP_EOL . 
				   '<input type="text" name="quantityStockChange" id="modifyStockQuantityChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockQuantityChange()" class="helpButton">' . '?' . '</a>' . '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="modifyUpdateStock" value="Modify Shop Stock" />' . PHP_EOL .
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Modify Returns Form
	$updateReturnsForm = '<form action="' . $self . '" method="post" id="returnsForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify Returns: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the barcode of product you want to modify on this side</p>' . 
				   '<div>' . 
				   '<label for="modifyReturnsBar">Barcode:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyReturnsBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyReturnsBarcode()" class="helpButton">' . '?' . '</a>' . '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
				   '<p>Enter the date the returns were entered onto the system</p>' . 
				   '<div>' . 
				   '<label for="modifyReturnsOrigDate">Returned Date:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="date" name="originalDate" id="modifyReturnsOrigDate" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyReturnsOrigDate()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' . 
					'<div>' . 
				   '<label for="modifyReturnsBarChange">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcodeChange" id="modifyReturnsBarChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyReturnsBarcodeChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				   '<label for="modifyReturnsQuantityChange" class="modifyStockQuantity">Quantity to be changed by:</label>' 
				   . PHP_EOL . 
				   '<input type="text" name="quantityChange" id="modifyReturnsQuantityChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyReturnsQuantityChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL .
				   '<div>' . 
				   '<label for="modifyReturnsDateChange">Returned Date: </label>' . PHP_EOL . 
				   '<input type="text" name="dateChange" id="modifyReturnsDateChange" value="" />' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyReturnsDateChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL .
				   '<input type="submit" name="modifyUpdateReturns" value="Modify Returns" />' . PHP_EOL .  
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Modify Delivery Form
	$updateDeliveryForm = '<form action="' . $self . '" method="post" id="deliveryForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify Delivery: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the barcode of product you want to modify on this side</p>' . 
				   '<div>' . 
				   '<label for="modifyDeliveryBar">Barcode:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyDeliveryBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeliveryBarcode()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '<p>Enter the date the delivery was entered onto the system</p>' . 
				   '<div>' . 
				   '<label for="modifyDeliveryOrigDate">Delivered Date:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="date" name="originalDate" id="modifyDeliveryOrigDate" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeliveryOrigDate()" class="helpButton">' . '?' . '</a>' . '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' . 
					 '<div>' .
					'<label for="modifyDeliveryBarChange">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcodeChange" id="modifyDeliveryBarChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeliveryBarcodeChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
					'<div>' . 
				   '<label for="modifyDeliveryQuantityChange">Quantity to change by: </label>' . PHP_EOL . 
				   '<input type="text" name="quantityChange" id="modifyDeliveryQuantityChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeliveryQuantityChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<div>' . 
				   '<label for="modifyDeliveryReceivedDateChange">Received Date: </label>' . PHP_EOL . 
				   '<input type="text" name="receivedDateChange" id="modifyDeliveryReceivedDateChange" value="" />' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeliveryReceivedDateChange()" class="helpButton">' . '?' . '</a>'. '</div>' 
				   . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   	 '<input type="submit" name="modifyUpdateDelivery" value="Modify Delivery" />' . PHP_EOL . 
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Main Modify Stock Form
	$updateStockFullForm = '<form action="' . $self . '" method="post" id="stockFullForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify Stock: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the barcode of product you want to modify on this side</p>' . 
				   '<div>' . 
				   '<label for="modifyStockFullBar">Barcode<span class="required">*</span>: </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyStockFullBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockFullBarcode()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' .  
					'<div>' . 
					'<label for="modifyStockFullBarChange">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcodeChange" id="modifyStockFullBarChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockFullBarcodeChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
					'<div>' . 
				   '<label for="modifyStockFullQuantityChange">Quantity to change by: </label>' . PHP_EOL . 
				   '<input type="text" name="quantityChange" id="modifyStockFullQuantityChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockFullQuantityChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<div>' . 
				   '<label for="modifyStockFullReceivedDateChange">Received Date: </label>' . PHP_EOL . 
				   '<input type="text" name="receivedDateChange" id="modifyStockFullReceivedDateChange" value="" />' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockFullReceivedDateChange()" class="helpButton">' . '?' . '</a>'. '</div>' 
				   . PHP_EOL .
				   '<br/>' . PHP_EOL . 
				   '<div>' . 
				   '<label for="modifyStockFullReturnsDateChange">Return Date: </label>' . PHP_EOL . 
				   '<input type="text" name="returnsDateChange" id="modifyStockFullReturnsDateChange" value="" />' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyStockFullReturnsDateChange()" class="helpButton">' . '?' . '</a>'. '</div>' 
				   . PHP_EOL .  
				   '<br/>' . PHP_EOL .
				   '<input type="submit" name="modifyUpdateStockFull" value="Modify Stock" />' . PHP_EOL . 
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Delete Record Form, can delete record from Stock, Delivery, Returns table
	$deleteRecordsForm = '<form action="' . $self . '" method="post" id="deleteRecordForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Delete Record: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the product barcode and from which table you wish to delete the record</p>' .
				   '<div>' .  
				   '<label for="modifyDeleteBar">Barcode:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyDeleteBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeleteBarcode()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   
				   '<p>Enter the date the delivery/returns were entered onto the system, if deleting a record from Delivery/Returns table</p>' . 
				   '<div>' . 
				   '<label for="modifyDeleteOrigDate">Date: </label>' . PHP_EOL . 
				   '<input type="date" name="originalDate" id="modifyDeleteOrigDate" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeleteOrigDate()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
				   '<div>' . 
				   '<label for="modifyDeleteLocation">Table select: </label>' . PHP_EOL . 
				   '<select name="location" id="modifyDeleteLocation">' . PHP_EOL . 
					   '<option value="Stock">Stock</option>' . PHP_EOL . 
					   '<option value="Returns">Returns</option>' . PHP_EOL . 
					   '<option value="Deliveries">Deliveries</option>' . PHP_EOL . 
				   '</select>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeleteLocation()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' .  PHP_EOL .
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Tick the checkbox to confirm that you wish to delete this record</p>' .  
					'<div>' . 
				   '<label for="modifyDeleteCheck">Confirm</label>' . PHP_EOL . 
				   '<input type="checkbox" name="deleteCheck" id="modifyDeleteCheck" value="Yes"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyDeleteCheck()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="modifyDeleteRecord" value="Delete Record" />' . PHP_EOL . 
				   '</div>' . PHP_EOL .
		
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	$required = "<p class=\"adminCenter\">All required fields marked with <span class=\"required\">*</span></p>";
	
	// A variable to collect all the main parts of the output
	$forms = $headings . $selectModify . $required . $updateStockForm . $updateReturnsForm . $updateDeliveryForm . $updateStockFullForm .
	 $deleteRecordsForm;
	
	// To check if Modify Returns form has been submitted
	if(isset($_POST['modifyUpdateReturns']))
	{
		// Gather the inputs from user
		$clean['barcode'] = htmlentities($_POST['barcode']); // Original barcode
		$clean['originalDate'] = htmlentities($_POST['originalDate']); // Original Date
		$clean['barcodeChange'] = htmlentities($_POST['barcodeChange']); // To change that barcode, mainly to 
		//change the issue number
		$clean['quantityChange'] = htmlentities($_POST['quantityChange']); // To change the quantity, allow 
		// negative and positive values
		$clean['dateChange'] = htmlentities($_POST['dateChange']); // Make sure it is a valid date. 
		
		// Set up variables for each check
		$barcodeCheck = false;
		$quantityCheck = false;
		$dateCheck = false;
		
		$errorHeading = "Modify Returns Result";
		
		// Checks if barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if it is below zero, a negative number
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Original barcode has to be  positive' . '</p>';
				}
				// Checks to see if the barcode is 15 digits
				if(strlen($clean['barcode'])== 15)
				{
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Original barcode must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Original barcode has to be numeric and positive' . '</p>';
			}
			
			
		}
		else
		{
			$error .= '<p>' . 'Original barcode can not be empty for this form' . '</p>';
		}
		
		// Checks to see if the original date input is not empty
		if(!empty($clean['originalDate']))
		{
			// Checks to see if the date inputted, is a valid date and in the correct format
			if(!checkTheDate($clean['originalDate']))
			{
				$error .= '<p>' . 'The returns date needs to be format YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original date can not be empty for this form' . '</p>';
		}
		
		// Checks to see if the barcode to change to is not empty
		if(!empty($clean['barcodeChange']))
		{
			// Checks to see if the barcode is numeric
			if(is_numeric($clean['barcodeChange']))
			{
				// Checks to see if it is a negative number
				if($clean['barcodeChange'] < 0)
				{
					$error .= '<p>' . 'Barcode to change has to be  positive' . '</p>';
				}
				// Checks to see if the barcode is 15 digits long
				if(strlen($clean['barcodeChange'])== 15)
				{
					$clean['issueChange'] = getIssueNumber($clean['barcodeChange']);
					$clean['barcodeChange'] = cutBarcode($clean['barcodeChange']);
					// If passes all checks, then assign true to $barcodeCheck to signify that is what the user wants to change
					$barcodeCheck = true;
				}
				else
				{
					$error .= '<p>' . 'Barcode to change must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode to change must be numeric and positive' . '</p>';
			}
		}
		
		// Checks to see if the quantity to change by is not empty
		if(!empty($clean['quantityChange']))
		{
			// Checks to see if the quantity is numeric, allow negative numbers
			if(is_numeric($clean['quantityChange']))
			{
				// Set $quantityCheck to true, to signify this is what the user wants to change
				$quantityCheck = true;
			}
			else
			{
				$error .= '<p>' . 'Quantity must be numeric' . '</p>';
			}
		}
		
		// Checks to see if the dateChange is not empty
		if(!empty($clean['dateChange']))
		{
			// Check the date to make sure it is a valid date and the correct format
			if(!checkTheDate($clean['dateChange']))
			{
				$error .= '<p>' . 'The return date to change , needs to be format YYYY-MM-DD' . '</p>';
			}
			else
			{
				// Set $dateCheck to true, to signify that is what the user wants to change
				$dateCheck = true;
			}
		}
		
		// Checks to see if the user has filled out at least one of the modify inputs to change the table
		if(($barcodeCheck == true) || ($quantityCheck == true) || ($dateCheck == true))
		{
			// If error is empty and one of the checks is true, continue 
			if(empty($error))
			{
				// Create a database object
				$db = createDatabaseObject();
				$con = $db->getLink();
				// Clean up the inputs, to use with the database
				$clean['barcode'] = $db->cleanInfo($clean['barcode']);
				$clean['issue'] = $db->cleanInfo($clean['issue']);
				$clean['originalDate'] = $db->cleanInfo($clean['originalDate']);
				
				// First check if the user wants to change the barcode
				if($barcodeCheck == true)
				{
					// Clean up the inputs to use with the database
					$clean['barcodeChange'] = $db->cleanInfo($clean['barcodeChange']);
					$clean['issueChange'] = $db->cleanInfo($clean['issueChange']);
					
					
					// Check if the barcode exists inside the Returns table
					if($db->checkStockExist('Returns', $clean['barcode'], $clean['issue']))
					{
						// Then check if a record exists, that has the same barcode, issue and date.
						if(!$db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the returns table but not with the date selected' . '</p>';
						}
					}
					else
					{
						$error .= '<p>'.'The original barcode does not exist in the Returns Table' . '</p>';
					}
					
					// Need to check if the barcode to change to, already exists inside the reurns table
					if($db->checkStockExist('Returns', $clean['barcodeChange'], $clean['issueChange']))
					{
						if($dateCheck == true)
						{
							$clean['dateChange'] = $db->cleanInfo($clean['dateChange']);
							// Then check if a record exists that we will be changing it to, that has the same barcode, 
							// issue and date
							if($db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcodeChange'],
								 $clean['issueChange'], $clean['dateChange']))
							{
								$error .= '<p>' .'The barcode to change to already exists in the returns table
								with the date to be changed to' . '</p>';
							}
						}
						else
						{
							$clean['originalDate'] = $db->cleanInfo($clean['originalDate']);
							// Then check if a record exists that we will be changing it to, that has the same barcode, 
							// issue and date
							if($db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcodeChange'],
								 $clean['issueChange'], $clean['originalDate']))
							{
								$error .= '<p>'.'The barcode to change to already exists in the returns table with the
								 date selected' . '</p>';
							}
						}
					}
					
					// Need to check if the first 13 digits of the original barcode and the barcode to change to, are the same
					// otherwise it is a different product, needs to be same product
					if(!($clean['barcode'] === $clean['barcodeChange']))
					{
						$error .= '<p>'.'The first 13 digits of the barcodes are not the same, need to be same product 
						but different issues (last two digits).' . '</p>';
					}
					
					// If there is still no errors, continue to modify the table
					if(empty($error))
					{
						// Try changing the barcode, if it succeeds, then put together an output to tell the user
						if($db->changeBarcode('Returns', $clean['barcode'], $clean['issue'],
						 $clean['barcodeChange'], $clean['issueChange'], "return_date", $clean['originalDate']))
						{
							$output .= 'The barcode has been changed from ' . $clean['barcode'] . displayIssue($clean['issue']) .
							' to ' . $clean['barcodeChange'] . displayIssue($clean['issueChange']) . '. With the date = '
							. $clean['originalDate'] . '%0A';
							
							// if successful, then set the variable of the barcode and issue number, to the changed barcode and
							// issue number, so that if the user is trying to modify another thing from the same form submitted,
							//it will not be an error because the barcode variable is now the same as the one that matches the table
							$clean['barcode'] = $clean['barcodeChange'];
							$clean['issue'] = $clean['issueChange'];
						}
						else
						{
							$error .= '<p>'.'The barcode has not been changed' . '</p>';
	
						}
					}
				}
				
				// Check to see if the user wanted to change the quantity
				if($quantityCheck == true)
				{
					// Clean up the quantity to change to, to use with the database
					$clean['quantityChange'] = $db->cleanInfo($clean['quantityChange']);
					
					// Check if a record exists in the returns table with the same barcode and issue
					if($db->checkStockExist('Returns', $clean['barcode'], $clean['issue']))
					{
						// Check to see if the record exists in the table with the same barcode, issue and original date
						if(!$db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the returns table but not with the date selected' . '</p>';
						}
					}
					else
					{
						$error .= '<p>' . 'The barcode does not exist in the Returns Table for the quantity change to happen'.'</p>';
					}
					
					// Get the stock for that barcode, issue number, and the original date
					$returnStock = $db->getStockDate('return_quantity', $clean['barcode'], $clean['issue'], 'Returns', "return_date",
					$clean['originalDate']);
					
					// Check to see if the quantity to change to is a negative number
					if($clean['quantityChange'] < 0)
					{
						// Check to see if quantity to change to is added to the return stock will become less than zero
						if(($returnStock + $clean['quantityChange']) < 0)
						{
							$error .= '<p>'.'The quantity "' . $clean['quantityChange'] .  '" change will make returns "' .
							 $returnStock .  '" become negative = ' . ($returnStock + $clean['quantityChange']) . '</p>';
						}
					}
					
					// if no errors, continue to change the quantity
					if(empty($error))
					{
						// Check to see if the change in quantity is successfully added/taken away from the returned quantity
						if($db->changeQuantityDate('Returns', 'return_quantity', $clean['barcode'], $clean['issue'],
						 $clean['quantityChange'], "return_date", $clean['originalDate']))
						{
							$output .= 'The quantity has been changed from ' . $returnStock . ' to ' .
							($returnStock + $clean['quantityChange']) . '%0A';
						}
						else
						{
							$error .= '<p>'.'The quantity has not been changed' . '</p>';
						}
					}
				}
				
				// If the user wants to change the date
				if($dateCheck == true)
				{
					// Clean up the input for use with the database
					$clean['dateChange'] = $db->cleanInfo($clean['dateChange']);
					
					// Checks to see if the stock exists for that barcode and issue
					if($db->checkStockExist('Returns', $clean['barcode'], $clean['issue']))
					{
						// Checks to see if the record exists in the returns table but doesnt have the orginal date
						if(!$db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the returns table but not with the original date selected' .
							 '</p>';
						}
						// Checks to see a record exists in the returns table, with barcode, issue, and the date to change to
						if($db->checkDuplicateIssueDate("Returns", "return_date", $clean['barcode'],
							 $clean['issue'], $clean['dateChange']))
						{
							$error .= '<p>'.'The barcode and the date being changed to already exists in the returns table' . '</p>';
						}
					}
					else
					{
						$error .= '<p>' .'The barcode does not exist in the Returns Table for the date change to happen' . '</p>';
					}
		
					// if no errors, then continue to change the date
					if(empty($error))
					{
						// try changing the date
						if($db->changeDateOriginal('Returns', 'return_date', $clean['barcode'], $clean['issue'], $clean['dateChange'],
						$clean['originalDate']))
						{
							$output .= 'The date has been changed from "' . $clean['originalDate'] .
							 '" to "' . $clean['dateChange']. '"%0A'; 
						}
						else
						{
							$error .= '<p>'.'The date has not been changed' . '</p>';
						}
					}
				}
				// end the connection to the database
				$db->endConnection($con);
				if(empty($error))
				{
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
		}
		else
		{
			$error .= '<p>' . 'Need to have inputted values into at least one of the fields on the right (to change) side' . '</p>';
		}	
	}
	// For the modify stock in shops form
	else if(isset($_POST['modifyUpdateStock']))
	{
		// Clean up user inputs
		$clean['barcode'] = htmlentities($_POST['barcode']);
		$clean['location'] = htmlentities($_POST['location']); 
		$clean['quantityStockChange'] = htmlentities($_POST['quantityStockChange']);
		// Get the proper value of the location to use with the database
		$clean['correctLocation'] = getCorrectLocation($clean['location']);
		
		$errorHeading = "Modify Stock in Shops Result";
		
		// Check if barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if barcode is negative
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Original barcode has to be  positive' . '</p>';
				}
				// Check if barcode is 15 digits long
				if(strlen($clean['barcode'])== 15)
				{
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Original barcode must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Original barcode has to be numeric and positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original barcode can not be empty for this form' . '</p>';
		}
		
		// Check if quantity to check stock by is not empty
		if(!empty($clean['quantityStockChange']))
		{
			// Check if quantity is not numeric, neagative or positive
			if(!is_numeric($clean['quantityStockChange']))
			{
				$error .= '<p>' . 'Quantity must be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Quantity can not be empty for this form' . '</p>';
		}
		
		// Check if location is equal to either shop 1 or shop 2
		if(($clean['location'] != 'Shop1') && ($clean['location'] != 'Shop2'))
		{
			$error .= '<p>' . 'Location has to be either Shop1 or Shop2' . '</p>';
		}
		// Check if location is empty
		if(empty($clean['location']))
		{
			$error .= '<p>' . 'Location can not be empty for this form' . '</p>';
		}
		
		// Check if there is no errors so far
		if(empty($error))
		{
			// Create database object
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean up values for use with database
			$clean['barcode'] = $db->cleanInfo($clean['barcode']);
			$clean['issue'] = $db->cleanInfo($clean['issue']);
			$clean['location'] = $db->cleanInfo($clean['location']);
			$clean['quantityStockChange'] = $db->cleanInfo($clean['quantityStockChange']);
			$clean['correctLocation'] = $db->cleanInfo($clean['correctLocation']);
			
			// Check fi the barcode does not exist in the Stock table
			if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
			{
				$error .= '<p>' . 'The original barcode does not exist in the Stock Table' . '</p>';
			}
			// Get the stock quantity for that product and for the location
			$getStock = $db->getStock($clean['correctLocation'], $clean['barcode'], $clean['issue'], 'Stock');
			// Check if there exists any stock for that product in that shop
			if($getStock == false)
			{
				$error .= '<p>' . 'There is no stock for that product in "' . $clean['location'] . '" </p>';
			}
			// Check if the quantity to change by is a negative number
			if($clean['quantityStockChange'] < 0)
			{
				// Check if the stock currently in the location will become a negative number if minus quantity
				if(($getStock + $clean['quantityStockChange']) < 0)
				{
					$error .= '<p>' . 'The quantity "' . $clean['quantityStockChange'] .  '" change will make stock "' . $getStock .
				'" for "' . $clean['location'] .   '" become negative = ' . ($getStock + $clean['quantityStockChange']) . '</p>';
				}
			}
			
			// Check if still no errors, if so continue to change data in the table
			if(empty($error))
			{
				// Check if the changeQuantity happens or not, if it does, display an appropriate message
				if($db->changeQuantity('Stock', $clean['correctLocation'], $clean['barcode'], $clean['issue'],
				 $clean['quantityStockChange']))
				{
					$output .= 'The quantity has been changed from ' . $getStock . ' to ' .
					 ($getStock + $clean['quantityStockChange']) . ', for ' . $clean['location'] . '. For the barcode =' .
					  $clean['barcode'] . displayIssue($clean['issue']) . '%0A'; 
				}
				else
				{
					$error .= '<p>'.'The quantity has not been changed' . '</p>';
				}
					
				// Redirect to avoid refresh form submit
				if(empty($error))
				{
					// End connection
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// End connection
			$db->endConnection($con);	
		}
		else
		{
			$error .= '<p>' . 'Need to input values into all input fields' . '</p>';
		}	
	}
	// For the modify deliveries form
	else if(isset($_POST['modifyUpdateDelivery']))
	{
		// barcodes should be the same, but issue should be different so just change the issue numbers
		$clean['barcode'] = htmlentities($_POST['barcode']); // Original barcode
		$clean['originalDate'] = htmlentities($_POST['originalDate']); // Original date of delivery
		$clean['barcodeChange'] = htmlentities($_POST['barcodeChange']); // Barcode to compare and change to, only issue number
		$clean['quantityChange'] = htmlentities($_POST['quantityChange']); // To change the quantity, allow negative and positive values
		$clean['receivedDateChange'] = htmlentities($_POST['receivedDateChange']); // Change received date
		
		$errorHeading = "Modify Delivery Result";
		
		$barcodeCheck = false;
		$quantityCheck = false;
		$receivedCheck = false;
	
		// Check if barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if barcode is negative
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Original barcode has to be  positive' . '</p>';
				}
				// Check if barcode is 15 digits long
				if(strlen($clean['barcode'])== 15)
				{
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Original barcode must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Original barcode has to be numeric and positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original barcode can not be empty for this form' . '</p>';
		}
		
		// Check if originalDate is not empty
		if(!empty($clean['originalDate']))
		{
			// Check if the original date is not a valid date, and in the correct format
			if(!checkTheDate($clean['originalDate']))
			{
				$error .= '<p>' . 'The delivered date needs to be format YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original date can not be empty for this form' . '</p>';
		}
		
		// Check if the barcode to change to is not empty
		if(!empty($clean['barcodeChange']))
		{
			// Check if the barcode to change to is numeric
			if(is_numeric($clean['barcodeChange']))
			{
				// Check to see if the barcode to change is negative
				if($clean['barcodeChange'] < 0)
				{
					$error .= '<p>' . 'Barcode to change has to be  positive' . '</p>';
				}
				// Check to see if the barcode to change is 15 digits long
				if(strlen($clean['barcodeChange'])== 15)
				{
					$clean['issueChange'] = getIssueNumber($clean['barcodeChange']);
					$clean['barcodeChange'] = cutBarcode($clean['barcodeChange']);
					$barcodeCheck = true;
				}
				else
				{
					$error .= '<p>' . 'Barcode to change must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode to change must be numeric and positive' . '</p>';
			}
		}
		
		// Check if the quantity to change to is not empty
		if(!empty($clean['quantityChange']))
		{
			// Check if the quantity is numeric
			if(is_numeric($clean['quantityChange']))
			{
				$quantityCheck = true;
			}
			else
			{
				$error .= '<p>' . 'Quantity must be numeric' . '</p>';
			}
		}
		
		// Check if the received date to change to is not empty
		if(!empty($clean['receivedDateChange']))
		{
			// Check if the date is a valid date, and is in correct format
			if(!checkTheDate($clean['receivedDateChange']))
			{
				$error .= '<p>' . 'The received date to change , needs to be format YYYY-MM-DD' . '</p>';
			}
			else
			{
				$receivedCheck = true;
			}
		}
		
		// Check if the user has inputted valid information into the change part of the form
		if(($barcodeCheck == true) || ($quantityCheck == true) || ($receivedCheck == true))
		{	
			// if there is still no errors
			if(empty($error))
			{
				// Create the database object
				$db = createDatabaseObject();
				$con = $db->getLink();
				// Clean up the values to use with the database
				$clean['barcode'] = $db->cleanInfo($clean['barcode']);
				$clean['issue'] = $db->cleanInfo($clean['issue']);
				$clean['originalDate'] = $db->cleanInfo($clean['originalDate']);
				
				// Check if the user wants to change the barcode
				if($barcodeCheck == true)
				{
					// Clean up values to use with the database
					$clean['barcodeChange'] = $db->cleanInfo($clean['barcodeChange']);
					$clean['issueChange'] = $db->cleanInfo($clean['issueChange']);
					
					// Check if the barcode exists in the deliveries table
					if($db->checkStockExist('Deliveries', $clean['barcode'], $clean['issue']))
					{
						// Check if the barcode and issue exist in the deliveries table with the original date
						if(!$db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the deliveries table but not with the date selected' . '</p>';
						}
					}
					else
					{
						$error .= '<p>'.'The original barcode does not exist in the deliveries Table' . '</p>';
					}
					
					// Check if the new barcode to change to, already exists in the table with the original date
					if($db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcodeChange'],
							 $clean['issueChange'], $clean['originalDate']))
					{
						$error .= '<p>'.'The new barcode does exist in the deliveries table with the same original date' . '</p>';
					}
					// Check if the user wants to change the received date of the barcode as well as change the barcode
					if($receivedCheck == true)
					{
						// Check to see if the new barcode to change to already has a record with the new date to change to
						if($db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcodeChange'],
							 $clean['issueChange'], $clean['receivedDateChange']))
						{
							$error .= '<p>'.'The new barcode does exist in the deliveries table with the same date selected
							 for change' . '</p>';
						}
					}
					// Check if the first 13 digits of the original barcode is equal to the first 13 digits of the barcode
					//  to change to
					if(!($clean['barcode'] === $clean['barcodeChange']))
					{
						$error .= '<p>'.'The first 13 digits of the barcodes are not the same, need to be same product 
						but different issues (last two digits).' . '</p>';
					}
					
					// Check if there is still no errors
					if(empty($error))
					{
						// Check to see if the barcode is changed
						if($db->changeBarcode('Deliveries', $clean['barcode'], $clean['issue'],$clean['barcodeChange'],
						 $clean['issueChange'], "delivered_date", $clean['originalDate']))
						{
							$output .= 'The barcode has been changed from ' . $clean['barcode'] . displayIssue($clean['issue']) .
							' to ' . $clean['barcodeChange'] . displayIssue($clean['issueChange']) . '%0A';
							// Save the new barcode and issue numbers to be used later if the user has input values to change other
							// values in the table
							$clean['barcode'] = $clean['barcodeChange'];
							$clean['issue'] = $clean['issueChange'];
						}
						else
						{
							$error .= '<p>'.'The barcode has not been changed' . '</p>';
	
						}
					}
				}
				// Check if the user wants to change the quantity
				if($quantityCheck == true)
				{
					// Clean up the quantity to change, to use with the database
					$clean['quantityChange'] = $db->cleanInfo($clean['quantityChange']);
					
					// Check to see if the barcode exists in the deliveries table
					if($db->checkStockExist('Deliveries', $clean['barcode'], $clean['issue']))
					{
						// Check to see if the barcode exists and with the original date
						if(!$db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the deliveries table but not with the date selected' .'</p>';
						}
					}
					else
					{
						$error .= '<p>'.'The original barcode does not exist in the deliveries Table' . '</p>';
					}
					// get the stock for that product 
					$getStock = $db->getStockDate('delivered_quantity', $clean['barcode'], $clean['issue'], 'Deliveries',
					 "delivered_date", $clean['originalDate']);
					// Check to see if the quantity to change is a negative number
					if($clean['quantityChange'] < 0)
					{
						// If the stock minus the quantity to change by, is a negative number, then don't let the user change it
						if(($getStock + $clean['quantityChange']) < 0)
						{
							$error .= '<p>'.'The quantity "' . $clean['quantityChange'] .  '" change will make delivered stock "' 
							. $getStock . '" become negative = ' . ($getStock + $clean['quantityChange']) . '</p>';
						}
					}
					// Check if there is still no errors
					if(empty($error))
					{
						// Check if the user changed the quantity successfully
						if($db->changeQuantityDate('Deliveries', 'delivered_quantity', $clean['barcode'], $clean['issue'],
						 $clean['quantityChange'], "delivered_date", $clean['originalDate']))
						{
							$output .= 'The quantity has been changed from '.$getStock.' to '.
							($getStock + $clean['quantityChange']).', for barcode = '.$clean['barcode'] .
							 displayIssue($clean['issue']) .  '%0A';
						}
						else
						{
							$error .= '<p>'.'The quantity has not been changed' . '</p>';
						}
					}
				}
				// Check if the user wants to change the received date
				if($receivedCheck == true)
				{
					// Clean up the value to used with the database
					$clean['receivedDateChange'] = $db->cleanInfo($clean['receivedDateChange']);
					// Check if the product exists inside the deliveries table
					if($db->checkStockExist('Deliveries', $clean['barcode'], $clean['issue']))
					{
						// Check if the product exists with the original date
						if(!$db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcode'],
							 $clean['issue'], $clean['originalDate']))
						{
							$error .= '<p>'.'The barcode does exist in the deliveries table but not with the original date selected'
							.'</p>';
						}
						// Check if the barcode exists in the deliveries table with the date to change to
						if($db->checkDuplicateIssueDate("Deliveries", "delivered_date", $clean['barcode'],
							 $clean['issue'], $clean['receivedDateChange']))
						{
							$error .= '<p>'. 'The barcode with the date being changed to, already exists in the deliveries table' .
							 '</p>';
						}
					}
					else
					{
						$error .= '<p>'.'The original barcode does not exist in the deliveries Table' . '</p>';
					}
					// Check if there is still no errors
					if(empty($error))
					{
						// Check if the the date has successfully been changed
						if($db->changeDateOriginal('Deliveries', 'delivered_date', $clean['barcode'], $clean['issue'],
						 $clean['receivedDateChange'], $clean['originalDate']))
						{
							$output .= 'The date has been changed from "' . $clean['originalDate'] . '" to "' .
							 $clean['receivedDateChange']. '"%0A'; 
						}
						else
						{
							$error .= '<p>'.'The received date has not been changed' . '</p>';
						}
					}
				}
				// end connection to database
				$db->endConnection($con);
				// Redirect to avoid refresh form submit
				if(empty($error))
				{
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
		}
		else
		{
			$error .= '<p>' . 'Need to have inputted values into at least one of the fields on the right (to change) side' . '</p>';
		}
	}
	// For the delete records form
	else if(isset($_POST['modifyDeleteRecord']))
	{
		// Clean up the user inputs
		$clean['barcode'] = htmlentities($_POST['barcode']); // Original barcode
		$clean['location'] = htmlentities($_POST['location']); // Location, table to delete record from. Either Stock or Returns
		$clean['originalDate'] = htmlentities($_POST['originalDate']); // Original date of entered record
		
		$errorHeading = "Delete Records Result";
		
		// Check if the checkbox is not empty
		if(!empty($_POST['deleteCheck']))
		{
			$clean['deleteCheck'] = htmlentities($_POST['deleteCheck']);
			// Check if the checkbox value is equal to Yes
			if(!$clean['deleteCheck'] == 'Yes')
			{
				$error .= '<p>' . 'Delete checkbox not correct value has to be  positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Delete confirmation not ticked' . '</p>';
		}
		
		// Check if the barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if the barcode is negative
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Original barcode has to be  positive' . '</p>';
				}
				// Check if the barcode is 15 digits long
				if(strlen($clean['barcode'])== 15)
				{
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Original barcode must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Original barcode has to be numeric and positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original barcode can not be empty for this form' . '</p>';
		}
		
		// Check if the location selected is a valid location
		if(($clean['location'] != 'Stock') && ($clean['location'] != 'Returns')&& ($clean['location'] != 'Deliveries'))
		{
			$error .= '<p>' . 'Table select has to be either Stock, Returns or Deliveries' . '</p>';
		}
		// Check if the location is empty
		if(empty($clean['location']))
		{
			$error .= '<p>' . 'Table select can not be empty for this form' . '</p>';
		}
		// Check if the location does not equal to Stock
		if($clean['location'] != 'Stock')
		{
			// Check if the original date is not empty
			if(!empty($clean['originalDate']))
			{
				// Check if the original date is a valid date, in the correct format
				if(!checkTheDate($clean['originalDate']))
				{
					$error .= '<p>' . 'The date entered needs to be format YYYY-MM-DD' . '</p>';
				}
			}
		}
		// If no errors, and if the delete checkbox is ticked
		if((empty($error)) && ($clean['deleteCheck'] == 'Yes'))
		{
			// Create a database object
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean up the values for use with the database
			$clean['barcode'] = $db->cleanInfo($clean['barcode']);
			$clean['issue'] = $db->cleanInfo($clean['issue']);
			$clean['location'] = $db->cleanInfo($clean['location']);
			$clean['originalDate'] = $db->cleanInfo($clean['originalDate']);
			
			// Check if the location is deliveries, then store the correct column to use with the deliveries table
			if($clean['location'] == "Deliveries")
			{
				$clean['columnDate'] = "delivered_date";
			}
			// Check if the location is returns, then store the correct column to use with the returns table
			else if($clean['location'] == "Returns")
			{
				$clean['columnDate'] = "return_date";
			}
			
			// Check to see if the product exists in the location
			if($db->checkStockExist($clean['location'], $clean['barcode'], $clean['issue']))
			{
				// Check to see if the location value is not stock
				if($clean['location'] != "Stock" && !empty($clean['originalDate']))
				{
					// Check if a record with the values inputted exist in the table with the original date
					if(!$db->checkDuplicateIssueDate($clean['location'], $clean['columnDate'], $clean['barcode'],
					 $clean['issue'], $clean['originalDate']))
					{
						$error .= '<p>' . 'The barcode does exist in the ' . $clean['location'] .
						 ' table but not with the date selected' . '</p>';
					}
				}
			}
			else
			{
				$error .= '<p>' . 'The original barcode does not exist in the' . $clean['location'] .  'Table' . '</p>';
			}
			
			// Check if there is still no errors
			if(empty($error))
			{
				// Check if the location is equal to Stock
				if($clean['location'] == "Stock")
				{
					// Try to delete the record from the Stock table with the barcode and issue number the user inputted
					if($db->deleteRecord($clean['location'], $clean['barcode'], $clean['issue']))
					{
						$output .= 'The product record with barcode "' . $clean['barcode'] . displayIssue($clean['issue']) .
						'" has been deleted from the "' . $clean['location'] . '" table.' . '%0A';
					}
					else
					{
						$error .= '<p>'.'The record has not been changed' . '</p>';
					}
				}
				else
				{
					if(!empty($clean['originalDate']))
					{
						// Try to delete the record that has the barcode, issue and original date inputted
						if($db->deleteRecordDate($clean['location'], $clean['barcode'], $clean['issue'], 
						$clean['columnDate'], $clean['originalDate']))
						{
							$output .= 'The product record with barcode "' . $clean['barcode'] . displayIssue($clean['issue']) .
							'", with date "' . $clean['originalDate'] . '" has been deleted from the "' .
							 $clean['location'] . '" table.' . '%0A';
	
						}
						else
						{
							$error .= '<p>'.'The record has not been changed' . '</p>';
						}	
					}
					else
					{
						if($db->deleteRecord($clean['location'], $clean['barcode'], $clean['issue']))
						{
							$output .= 'The product record with barcode "' . $clean['barcode'] . displayIssue($clean['issue']) .
							'" has been deleted from the "' . $clean['location'] . '" table.' . '%0A';
						}
						else
						{
							$error .= '<p>'.'The record has not been changed' . '</p>';
						}
					}
					
				}
				
				// Redirect to avoid refresh form submit
				if(empty($error))
				{
					// end connection to database
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
		// end connection to database
		$db->endConnection($con);
		}
		else
		{
			$error .= '<p>' . 'Need to input values into all input fields and checkbox must be ticked' . '</p>';
		}
	}
	// Modify the Stock table
	else if(isset($_POST['modifyUpdateStockFull']))
	{
		// barcodes should be the same, but issue should be different so just change the issue numbers
		$clean['barcode'] = htmlentities($_POST['barcode']); // Original barcode
		$clean['barcodeChange'] = htmlentities($_POST['barcodeChange']); // Barcode to compare and change to, only issue number
		$clean['quantityChange'] = htmlentities($_POST['quantityChange']); // To change the quantity, allow negative and positive values
		$clean['receivedDateChange'] = htmlentities($_POST['receivedDateChange']); // Change received date
		$clean['returnsDateChange'] = htmlentities($_POST['returnsDateChange']); // Change date to be returned
		
		$errorHeading = "Modify Stock Result";
		
		$barcodeCheck = false;
		$quantityCheck = false;
		$receivedCheck = false;
		$returnCheck = false;
	
		// Check if the barcode is not empty
		if(!empty($clean['barcode']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check if the barcode is negative
				if($clean['barcode'] < 0)
				{
					$error .= '<p>' . 'Original barcode has to be  positive' . '</p>';
				}
				// Check if the barcode is 15 digits long
				if(strlen($clean['barcode'])== 15)
				{
					$clean['issue'] = getIssueNumber($clean['barcode']);
					$clean['barcode'] = cutBarcode($clean['barcode']);
				}
				else
				{
					$error .= '<p>' . 'Original barcode must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Original barcode has to be numeric and positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Original barcode can not be empty for this form' . '</p>';
		}
		// Check if the barcode to change to is not empty
		if(!empty($clean['barcodeChange']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcodeChange']))
			{
				// Check if the barcode is negative
				if($clean['barcodeChange'] < 0)
				{
					$error .= '<p>' . 'Barcode to change has to be  positive' . '</p>';
				}
				// Check if the barcode to change to is 15 digits long
				if(strlen($clean['barcodeChange'])== 15)
				{
					$clean['issueChange'] = getIssueNumber($clean['barcodeChange']);
					$clean['barcodeChange'] = cutBarcode($clean['barcodeChange']);
					$barcodeCheck = true;
				}
				else
				{
					$error .= '<p>' . 'Barcode to change must be 15 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode to change must be numeric and positive' . '</p>';
			}
		}
		// Check if the quantity to change by, is not empty
		if(!empty($clean['quantityChange']))
		{
			// Check if the quantity is numeric
			if(is_numeric($clean['quantityChange']))
			{
				$quantityCheck = true;
			}
			else
			{
				$error .= '<p>' . 'Quantity must be numeric' . '</p>';
			}
		}
		// Check if the reeceived date to change is not empty
		if(!empty($clean['receivedDateChange']))
		{
			// Check if the received date to change to, is a valid date in the correct format
			if(!checkTheDate($clean['receivedDateChange']))
			{
				$error .= '<p>' . 'The received date to change , needs to be format YYYY-MM-DD' . '</p>';
			}
			else
			{
				$receivedCheck = true;
			}
		}
		// Check if the returns date to change to, is not empty
		if(!empty($clean['returnsDateChange']))
		{
			// Check if the returns date to change to, is a valid date in the correct format
			if(!checkTheDate($clean['returnsDateChange']))
			{
				$error .= '<p>' . 'The return date to change , needs to be format YYYY-MM-DD' . '</p>';
			}
			else
			{
				$returnCheck = true;
			}
		}
		// Check to see if the user has entered values into the changes part of the form
		if(($barcodeCheck == true) || ($quantityCheck == true) || ($receivedCheck == true) || ($returnCheck == true))
		{	
			// check if there is still no errors 
			if(empty($error))
			{
				// Create a database object
				$db = createDatabaseObject();
				$con = $db->getLink();
				// Clean up the values to use with the database
				$clean['barcode'] = $db->cleanInfo($clean['barcode']);
				$clean['issue'] = $db->cleanInfo($clean['issue']);
				
				// Check if the user is trying to change the barcode
				if($barcodeCheck == true)
				{
					// Clean up the values for use with the database
					$clean['barcodeChange'] = $db->cleanInfo($clean['barcodeChange']);
					$clean['issueChange'] = $db->cleanInfo($clean['issueChange']);
					
					// Check if the stock exists with that barcode
					if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
					{
						$error .= '<p>' .'The original barcode does not exist in the Stock Table' . '</p>';
					}
					// Check to see if the stock exists with the barcode to change to
					if($db->checkStockExist('Stock', $clean['barcodeChange'], $clean['issueChange']))
					{
						$error .= '<p>' . 'The barcode to change to, already exists in the Stock Table,
						 delete this record first' . '</p>';
					}
					// Check to see if the first 13 digits of both the original barcode and barcode to change to are the same
					if(!($clean['barcode'] === $clean['barcodeChange']))
					{
						$error .= '<p>' .'The first 13 digits of the barcodes are not the same, need to be same product 
						but different issues (last two digits).' . '</p>';
					}
					// If still no errors, then change the barcode
					if(empty($error))
					{
						// Try to change the barcode
						if($db->changeBarcode('Stock', $clean['barcode'], $clean['issue'],
						 $clean['barcodeChange'], $clean['issueChange']))
						{
							$output .= 'The barcode has been changed from ' . $clean['barcode'] . displayIssue($clean['issue']) .
							' to ' . $clean['barcodeChange'] . displayIssue($clean['issueChange']) . '%0A';
							$clean['barcode'] = $clean['barcodeChange'];
							$clean['issue'] = $clean['issueChange'];
						}
						else
						{
							$error .= '<p>' .'The barcode has not been changed' . '</p>';
	
						}
					}
				}
				// Check to see if the user wants change the quantity
				if($quantityCheck == true)
				{
					// Clean up the value to use with the database
					$clean['quantityChange'] = $db->cleanInfo($clean['quantityChange']);
					// Check to see if the product exists
					if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
					{
						$error .= '<p>' . 'The barcode does not exist in the Stock Table for the quantity change to happen' . '</p>';
					}
					// get the stock for that product
					$getStock = $db->getStock('warehouse_stock', $clean['barcode'], $clean['issue'], 'Stock');
					// Check to see if the quantity to change by, is a negative number
					if($clean['quantityChange'] < 0)
					{
						// Check to see if the stock minus the quantity to change by, will be negative
						if(($getStock + $clean['quantityChange']) < 0)
						{
							$error .= '<p>' . 'The quantity "' . $clean['quantityChange'] .  '" change will make stock "' .
							 $getStock . '" become negative = ' . ($getStock + $clean['quantityChange']) . '</p>';
						}
					}
					// Check if no errors
					if(empty($error))
					{
						// Try to change the quantity
						if($db->changeQuantity('Stock', 'warehouse_stock', $clean['barcode'], $clean['issue'],
						 $clean['quantityChange']))
						{
							$output .= 'The quantity has been changed from ' . $getStock . ' to ' .
							 ($getStock + $clean['quantityChange']) . ', for barcode = ' . $clean['barcode'] .
								displayIssue($clean['issue']) .  '%0A'; 
						}
						else
						{
							$error .= '<p>' .'The quantity has not been changed' . '</p>';
	
						}
					}
				}
				// Check to see if the user wants to change the received date
				if($receivedCheck == true)
				{
					// Clean up the value to use with the database
					$clean['receivedDateChange'] = $db->cleanInfo($clean['receivedDateChange']);
					// Check to see if the product exists
					if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
					{
						$error .= '<p>' .'The barcode does not exist in the Stock Table for the received date change to happen' .
						 '</p>';
					}
					// Get the received date
					$getReceivedDate = $db->getDate('Stock', 'received_date', $clean['barcode'], $clean['issue']);
					// Check to see if there was no received date for that product
					if($getReceivedDate == false)
					{
						$error .= '<p>' .'The received date does not exist in the Stock Table for that barcode' . '</p>';
					}
					// Check if there is still no errors
					if(empty($error))
					{
						// Try and change the date
						if($db->changeDate('Stock', 'received_date', $clean['barcode'], $clean['issue'], $clean['receivedDateChange']))
						{
							$output .= 'The date has been changed from "' . $getReceivedDate . '" to "' .
							 $clean['receivedDateChange']. '"%0A'; 
						}
						else
						{
							$error .= '<p>' . 'The received date has not been changed' . '</p>';
						}
					}
				}
				// Check to see if the user wants to try and change the return date
				if($returnCheck == true)
				{
					// Clean up the value to use with the database
					$clean['returnsDateChange'] = $db->cleanInfo($clean['returnsDateChange']);
					// Check to see if the product exists
					if(!$db->checkStockExist('Stock', $clean['barcode'], $clean['issue']))
					{
						$error .= '<p>' . 'The barcode does not exist in the Stock Table for the return date change to happen' .
						 '</p>';
					}
					// get the return date
					$getReturnDate = $db->getDate('Stock', 'return_date', $clean['barcode'], $clean['issue']);
					// Check if a return date exists for that product
					if($getReturnDate == false)
					{
						$error .= '<p>' . 'The return date does not exist in the Stock Table for that barcode' . '</p>';
					}
					// Check to see if there is still no errors
					if(empty($error))
					{
						// try and change the date
						if($db->changeDate('Stock', 'return_date', $clean['barcode'], $clean['issue'], $clean['returnsDateChange']))
						{
							$output .= 'The date has been changed from "' . $getReturnDate . '" to "' .
							 $clean['returnsDateChange']. '"%0A'; 
						}
						else
						{
							$error .= '<p>' . 'The return date has not been changed' . '</p>';
						}
					}
				}
				// end the connection
				$db->endConnection($con);
				// Redirect to avoid refresh form submit
				if(empty($error))
				{
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
		}
		else
		{
			$error .= '<p>' . 'Need to have inputted values into at least one of the fields on the right (to change) side' . '</p>';
		}
	}
	
	// Display the content
	if(!empty($output))
	{
		if(empty($error))
		{
			// With output
			$final = $errorHeading . $output . $forms;
			return $final;
		}
		else
		{
			// With output and errors
			$final = $errorHeading . $output . $errorStart . $error . $forms;
			return $final;
		}
	}
	else if(!empty($error))
	{
		// With errors
		$final = $errorHeading . $errorStart . $error . $forms;
		return $final;
	}
	else
	{
		// Without errors and output
		$final = $forms;
		return $final;
	}
	
?>