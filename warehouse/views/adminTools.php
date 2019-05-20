<?php
	// require functions
	require_once('includes/functions.php');
	
	// Variables
	$clean = array();
	$output = '';
	$error = '';
	$errorHeading = '';
	$date = getCurrentDate();
	$headings =  '<h3>' . 'Select an option from below: ' . '</h3>' . PHP_EOL;
	$errorStart = '<h5>' . 'Errors:' . '</h5>';
	$self = htmlspecialchars($_SERVER["PHP_SELF"]) . "?type=adminTools";
	
	$required = "<p class=\"adminCenter\">All required fields marked with <span class=\"required\">*</span></p>";
	// Get the content and complete and errors from the url and display to user
	if(isset($_GET['output'])) 
	{
		$output = '<p>' . nl2br(htmlentities($_GET['output'])) . '</p>';
	} 
	if(isset($_GET['errorHeading'])) 
	{
		$errorHeading = '<h4>' . nl2br(htmlentities($_GET['errorHeading'])) . '</h4>';
	} 
	
	$printLink = '<button id="printPageButton"  onclick="pagePrint()">' .'Print' . '</button>'. PHP_EOL .
				'<p id="printPageInfo">' . 'To print using Firefox = click options menu and then print.' . '<br/>'
				 . 'To print using Google Chrome, right click and press print, or click on file and then print.' . '</p>';
	
	$allUsersLink = '<p class="adminCenter">' . '<a href="index.php?type=adminTools&&enquiry=allUsers">' . 'Display All Users' . '</a>' .  '</p>'. PHP_EOL;
	$deleteAllLink = '<p class="adminCenter">' . '<a href="index.php?type=adminTools&&enquiry=deleteAll">' .
	 'Delete Every Record Where Stock Received is equal to the Stock that has been returned' . '</a>' .  '</p>'. PHP_EOL;

	// have select input for usiing javascript hide and show the other forms
	$selectAdmin = '<select id="adminSelect" onchange="showAdmin()">' . PHP_EOL . 
					'<option value="productModify">Modify Product' . '</option>' . PHP_EOL .
					'<option value="productDelete">Delete Product' . '</option>' . PHP_EOL .
					'<option value="addUser">Add User' . '</option>' . PHP_EOL .
					'<option value="modifyUser">Modify User' . '</option>' . PHP_EOL .
					'<option value="deleteUser">Delete User' . '</option>' . PHP_EOL .
					'</select>' . PHP_EOL; 
					
	// Modify Products form
	$updateProductsForm = '<form action="' . $self . '" method="post" id="productModifyForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify Product: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the barcode of product you want to modify on this side</p>' . 
				   '<div>' . 
				   '<label for="modifyProductBar">Barcode:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="modifyProductBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyProductsBarcode()" class="helpButton">' . '?' . '</a>' . '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' .
					'<div>' .  
				   '<label for="modifyProductsBarChange">Barcode to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="barcodeChange" id="modifyProductsBarChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyProductsBarcodeChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				   '<label for="modifyProductsTitleChange">Title to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="titleChange" id="modifyProductsTitleChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyProductsTitleChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL .
				   '<div>' . 
				   '<label for="modifyProductsPriceChange">Price to change to: &pound;</label>' . PHP_EOL . 
				   '<input type="text" name="priceChange" id="modifyProductsPriceChange" value="" />' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyProductsPriceChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="modifyUpdateProducts" value="Update Product" />' . PHP_EOL .
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
				   
	// Delete product form
	$deleteProductsForm = '<form action="' . $self . '" method="post" id="productDeleteForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Delete Product: </legend>' . PHP_EOL . 
				   
				   '<div>' . PHP_EOL . 
				   '<p>Enter the 13 digit product barcode you wish to delete the records for: </p>' . 
				   '<div>' . 
				   '<label for="productsDeleteBar">Barcode:<span class="required">*</span></label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="productsDeleteBar" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpProductsDeleteBarcode()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				   '<label for="productsDeleteCheck">Confirm</label>' . PHP_EOL . 
				   '<input type="checkbox" name="deleteCheck" id="productsDeleteCheck" value="Yes"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpProductsDeleteCheck()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="productsDeleteRecord" value="Delete Product" />' . PHP_EOL .
				   '</div>' . PHP_EOL . 
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Add user form
	$addUserForm = '<form action="' . $self . '" method="post" id="addUserForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Add User: </legend>' . PHP_EOL . 
				   
				   '<div>' . PHP_EOL .  
				   '<label for="addUserFirst">First name:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="firstName" id="addUserFirst" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddUserFirst()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
					'<div>' . 
				   '<label for="addUserLast">Last name:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="lastName" id="addUserLast" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddUserLast()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				  '<label for="addUserName">Username:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="username" id="addUserName" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddUserName()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   '<div>' . 
				   '<label for="addUserPass">Password:<span class="required">*</span></label>' . PHP_EOL . 
				   '<input type="text" name="password" id="addUserPass" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddUserPass()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   '<div>' .
				   '<label for="addUserLevel">User level:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="level" id="addUserLevel" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddUserLevel()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   
				   '<input type="submit" name="addUser" value="Add User" />' . PHP_EOL . 
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Modify user form
	$modifyUserForm = '<form action="' . $self . '" method="post" id="modifyUserForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Modify User: </legend>' . PHP_EOL . 
				   
				   '<div class="original">' . PHP_EOL . 
				   '<p>Enter the username of the user you want to modify</p>' . 
				   '<div>' . 
				   '<label for="modifyUserName">Username:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="username" id="modifyUserName" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserName()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '</div>' . PHP_EOL .
				   
					'<div class="changes">' . PHP_EOL . 
					'<p>Enter values on this side to modify database, leave blank if you don\'t want to change that value</p>' . 
					'<div>' . 
				   '<label for="modifyUserFirst">First name to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="firstName" id="modifyUserFirst" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserFirst()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .  
					'<div>' . 
				   '<label for="modifyUserLast">Last name to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="lastName" id="modifyUserLast" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserLast()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				  '<label for="modifyUserNameChange">Username to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="usernameChange" id="modifyUserNameChange" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserNameChange()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   '<div>' . 
				   '<label for="modifyUserPass">Password to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="password" id="modifyUserPass" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserPass()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   '<div>' . 
				   '<label for="modifyUserLevel">User level to change to: </label>' . PHP_EOL . 
				   '<input type="text" name="level" id="modifyUserLevel" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpModifyUserLevel()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
				   '<input type="submit" name="modifyUser" value="Modify User" />' . PHP_EOL .
				   '</div>' . PHP_EOL .
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Delete user form
	$deleteUsersForm = '<form action="' . $self . '" method="post" id="deleteUserForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Delete User: </legend>' . PHP_EOL . 
				   
				   '<p>Enter the username you wish to delete the record for: </p>' . 
				   '<div>' . 
				   '<label for="userDelete">Username:<span class="required">*</span> </label>' . PHP_EOL . 
				   '<input type="text" name="username" id="userDelete" value=""/>' . PHP_EOL . 
				   '<a href="#" onclick="helpUserDeleteUsername()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL .
					'<div>' . 
				   '<label for="userDeleteCheck">Confirm</label>' . PHP_EOL . 
				   '<input type="checkbox" name="deleteCheck" id="userDeleteCheck" value="Yes"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpUserDeleteCheck()" class="helpButton">' . '?' . '</a>'. '</div>' . PHP_EOL .  
				   '<br/>' . PHP_EOL . 
				   
				   '<input type="submit" name="deleteUser" value="Delete User" />' . PHP_EOL . 
				   
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Put together all forms to display
	$forms = $headings . $allUsersLink . $deleteAllLink . $selectAdmin . $required . $updateProductsForm . $deleteProductsForm . $addUserForm . $modifyUserForm . $deleteUsersForm;
	
	// Check if the user has pressed display all users
	if(isset($_GET['enquiry']))
	{
		// Clean up the value
		$clean['enquiry'] = htmlspecialchars($_GET['enquiry']);
		// Make sure the enquiry is all users
		if($clean['enquiry'] == 'allUsers')
		{
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
			'<h3>' . 'All users records' . '</h3>' . PHP_EOL .
					'<table>' . PHP_EOL .  
					'<tr>' . PHP_EOL .
					'<th>' . 'First Name' . '</th>' . PHP_EOL .
					'<th>' . 'Last Name' . '</th>' . PHP_EOL .
					'<th>' . 'Username' . '</th>' . PHP_EOL .
					'<th>' . 'Password' . '</th>' . PHP_EOL .
					'<th>' . 'User level' . '</th>' . PHP_EOL .
						'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			
			// Create a database object
			$db = createDatabaseObject();
			// get the output to display the users information
			$output = $db->allUsersShow();
			// end connection
			$db->endConnection($db->getLink());
			// Collect the outputs and display them
			$final = $outputStart . $output . $outputEnd; 
			return $final;
		}
		// Make sure the enquiry is all users
		else if($clean['enquiry'] == 'deleteAll')
		{
			
			$title = '<div>' . '<h3>' . "Records all been deleted today = " . htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
							'<p>' . 'These are all the records that have just been deleted from Stock, Deliveries, Returns tables. Because all the stock that has been received has been returned.' . '<br/>' . 'This information will only be displayed once, should print before refreshing or exiting/going back from this page' . '</p>' . PHP_EOL .
					'<table>' . PHP_EOL .  
					'<tr>' . PHP_EOL .
					'<th>' . 'Barcode' . '</th>' . PHP_EOL .
					'<th>' . 'Issue' . '</th>' . PHP_EOL .
					'<th>' . 'Title' . '</th>' . PHP_EOL .
					'<th>' . 'Warehouse Stock' . '</th>' . PHP_EOL .
					'<th>' . 'Shop One Stock' . '</th>' . PHP_EOL .
					'<th>' . 'Shop Two Stock' . '</th>' . PHP_EOL .
					'<th>' . 'Date to be Returned' . '</th>' . PHP_EOL .
					'<th>' . 'Delivered' . '</th>' . PHP_EOL .
					'<th>' . 'Returned' . '</th>' . PHP_EOL .
					'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			
			// Create a database object
			$db = createDatabaseObject();
			// get the output to display the users information
			$result = $db->gatherAllReturnsReceived();
			
			while($row = mysqli_fetch_assoc($result))
			{
				$output .= '<tr>' . PHP_EOL .
							'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
							'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
							'<td>' . htmlentities($row['title']) . '</td>' . PHP_EOL .
							'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
							'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
							'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
							'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
							'<td>' . $row['delivered_quant'] . '</td>' . PHP_EOL .
							'<td>' . $row['return_sum'] . '</td>' . PHP_EOL .
							'</tr>' . PHP_EOL;
				$db->deleteAllReturnsReceived($row['barcode'], $row['issue']);
			}	
			$db->freeResult($result);
			
			
			// end connection
			$db->endConnection($db->getLink());
			// Collect the outputs and display them
			$final = $title . $printLink .  $outputStart . $output . $outputEnd; 
			return $final;
		}
	}
	
	// Check if the user has submitted the update products form
	if(isset($_POST['modifyUpdateProducts']))
	{
		// Clean up the values
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$clean['barcodeChange'] = htmlspecialchars($_POST['barcodeChange']);
		$clean['titleChange'] = htmlspecialchars($_POST['titleChange']);
		$clean['priceChange'] = htmlspecialchars($_POST['priceChange']);
		$barcodeCheck = false;
		$titleCheck = false;
		$priceCheck = false;
		
		$errorHeading = "Modify Product Result";
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
				// Check if barcode is not 13 digits long
				if(strlen($clean['barcode'])!= 13)
				{
					$error .= '<p>' . 'Original barcode must be 13 digits' . '</p>';
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
		// Check if barcode to change to is not empty
		if(!empty($clean['barcodeChange']))
		{
			// Check if the barcode to change to is numeric
			if(is_numeric($clean['barcodeChange']))
			{
				// Check to see if the barcode to change to is negative
				if($clean['barcodeChange'] < 0)
				{
					$error .= '<p>' . 'Barcode to change has to be  positive' . '</p>';
				}
				// Check to see if the barcode to change to is equal to 13 digits
				if(strlen($clean['barcodeChange'])== 13)
				{
					// Check if the barcode and the barcode to change to is the same
					if(($clean['barcode'] === $clean['barcodeChange']))
					{
						$error .= '<p>' . 'The two barcodes that have been entered are the same' . '</p>';
					}
					else
					{
						$barcodeCheck = true;
					}
				}
				else
				{
					$error .= '<p>' . 'Barcode to change must be 13 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Barcode to change must be numeric and positive' . '</p>';
			}
		}
		// Check if title change is not empty
		if(!empty($clean['titleChange']))
		{
			// Check if title change is a string
			if(is_string($clean['titleChange']))
			{
				$titleCheck = true;
			}
			else
			{
				$error .= '<p>' . 'Title check needs to be text, can include numbers' . '</p>';
			}	
		}
		// Check if price to change to, is not empty
		if(!empty($clean['priceChange']))
		{
			// Check if price change is numeric
			if(is_numeric($clean['priceChange']))
			{
				// Create a variable to store the price entered formatted into the desired format so can compare the two
				$priceFormat = number_format($clean['priceChange'], 2, '.', '');
				// Check to see if the price given by the user is not equal to the desired format, eg, if
				// price entered was 6.9876 then it would produce an error, however if the user enter price as 6, then it will be
				// okay because it is a double so it saves as 6.00
				if($clean['priceChange'] != $priceFormat)
				{
					$error .= '<p>' . 'Price needs to be format "o.oo"' . '</p>';
				}
				// Check to see if the price change is negative
				if($clean['priceChange'] < 0)
				{
					$error .= '<p>' . 'Price to change can not be negative' . '</p>';
				}
				else
				{
					$priceCheck = true;
				}
			}
			else
			{
				$error .= '<p>' . 'Price to change must be numeric and format &pound;0.00' . '</p>';
			}	
		}
		// Check if the user has inputted valid information into the changes part of the form
		if(($barcodeCheck == true) || ($titleCheck == true) || ($priceCheck == true))
		{
			// If no errors, continue
			if(empty($error))
			{
				// Create a database object
				$db = createDatabaseObject();
				$con = $db->getLink();
				// Clean up the values, to use with the database
				$clean['barcode'] = $db->cleanInfo($clean['barcode']);
				// Check if the user wants to change the barcode
				if($barcodeCheck == true)
				{
					// Clean up the value to use with the database
					$clean['barcodeChange'] = $db->cleanInfo($clean['barcodeChange']);
					// Check to see if a product exists with the barcode inputted
					if(!$db->checkDuplicate('Products', 'barcode', $clean['barcode']))
					{
						$error .= '<p>' . 'The original barcode does not exist in the Products Table' . '</p>';
					}
					// Check if a product exists with the barcode to change to
					if($db->checkDuplicate('Products', 'barcode', $clean['barcodeChange']))
					{
						$error .= '<p>' . 'The barcode to change to, already exists in the Products Table,
						 delete this record first' . '</p>';
					}
					// If there is still no errors, then continue
					if(empty($error))
					{
						// try and change the barcode for the product
						if($db->changeProductBarcode('Products', $clean['barcode'], $clean['barcodeChange']))
						{
							$output .= 'The barcode has been changed from "' . htmlentities($clean['barcode']) .
							'" to "' . htmlentities($clean['barcodeChange']) .
							 '" for the Products Table and all tables that contain this product' . '%0A' ; 
							$clean['barcode'] = htmlentities($clean['barcodeChange']);
						}
						else
						{
							$error .= '<p>' . 'The barcode has not been changed' . '</p>';
						}
					}
				}
				// check if the user wants to change the title
				if($titleCheck == true)
				{
					// clean up the value to use with the database
					$clean['titleChange'] = $db->cleanInfo($clean['titleChange']);
					// Check if there is a product with the same barcode
					if(!$db->checkDuplicate('Products', 'barcode', $clean['barcode']))
					{
						$error .= '<p>' . 'The original barcode does not exist in the Products Table for that title' . '</p>';
					}
					// Check if there is a product with the title to change to
					if($db->checkDuplicate('Products', 'title', $clean['titleChange']))
					{
						$error .= '<p>' . 'That title to change already exists in the Products database, delete this record first' 
						. '</p>';
					}
					// get the title for the product
					$getTitle = $db->getProductValue('title', $clean['barcode']);
					
					// Check if the errors is empty
					if(empty($error))
					{
						// Try and change the product title value
						if($db->changeProductValue('title', $clean['barcode'], $clean['titleChange']))
						{
							$output .= 'The title has been changed to "' . htmlentities($clean['titleChange']) . '" from "' .
							htmlentities($getTitle) . '" for the barcode = ' . htmlentities($clean['barcode']) . '%0A'; 
						}
						else
						{
							$error .= '<p>' . 'The title has not been changed' . '</p>';
						}
					}
				}
				// check if the user wants to change the price
				if($priceCheck == true)
				{
					// clean up the value to use with the database
					$clean['priceChange'] = $db->cleanInfo($clean['priceChange']);
					// check if the product exists
					if(!$db->checkDuplicate('Products', 'barcode', $clean['barcode']))
					{
						$error .= '<p>' . 'The original barcode does not exist in the Products Table for that price' . '</p>';
					}
					// check if the product has a price
					if(!$db->getProductValue('price', $clean['barcode']))
					{
						$error .= '<p>' . 'Price is not available for that barcode' . '</p>';
					}
					else
					{
						// get the price of the product
						$getPrice = $db->getProductValue('price', $clean['barcode']);
					}
					// check if there is still no errors
					if(empty($error))
					{
						// try and change the price
						if($db->changeProductValue('price', $clean['barcode'], $clean['priceChange']))
						{
							$output .= 'The price has been changed to "£' . htmlentities($clean['priceChange']) . '" from "£' .
							htmlentities($getPrice) . '" for the barcode = ' . htmlentities($clean['barcode']) . '%0A'; 
						}
						else
						{
							$error .= '<p>' . 'The price has not been changed' . '</p>';
						}
					}
				}
				// end connection to database
				$db->endConnection($con);
				// redirect to same page, to avoid user refreshing
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
	// Check if user submitted the delete product form
	else if(isset($_POST['productsDeleteRecord']))
	{
		// get the values
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$errorHeading = "Delete Product Result";
		
		// Check to see if the checkbox for the delete form is not empty
		if(!empty($_POST['deleteCheck']))
		{
			// clean up the checkbox value
			$clean['deleteCheck'] = htmlspecialchars($_POST['deleteCheck']);
			// check to see if the checkbox value is equal to Yes
			if($clean['deleteCheck'] != 'Yes')
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
				// Check if the barcode is not equal to 13 digits long
				if(strlen($clean['barcode'])!= 13)
				{
					$error .= '<p>' . 'Original barcode must be 13 digits' . '</p>';
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
		
		// Check if no errors and that user has ticked the checkbox
		if((empty($error)) && ($clean['deleteCheck'] == 'Yes'))
		{
			// create a database object
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean up the values to use with the database
			$clean['barcode'] = $db->cleanInfo($clean['barcode']);
			// Check if the product exists
			if(!$db->checkDuplicate('Products', 'barcode', $clean['barcode']))
			{
				$error .= '<p>' . 'That barcode does not exist in the Products Table' . '</p>';
			}
			
			// Check if there is still no errors
			if(empty($error))
			{
				// Try and delete the record
				if($db->deleteRecord('Products', $clean['barcode'], ''))
				{
					$output .= 'The product record with barcode "' . htmlentities($clean['barcode']) .
					'" has been deleted from the product table and corresponding tables containing this product.' . '%0A';
				}
				else
				{
					$error .= '<p>' . 'The record has not been deleted' . '</p>';
				}
				// redirect to same page, to avoid user refreshing
				if(empty($error))
				{
					// end connection
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// end connection
			$db->endConnection($con);	
		}
		else
		{
			$error .= '<p>' . 'Need to input barcode and checkbox must be ticked' . '</p>';
		}	
	}
	// Check if the user has submitted the add user form
	else if(isset($_POST['addUser']))
	{
		// get the values the user has inputted
		$clean['firstName'] = htmlspecialchars($_POST['firstName']);
		$clean['lastName'] = htmlspecialchars($_POST['lastName']);
		$clean['username'] = htmlspecialchars($_POST['username']);
		$clean['password'] = htmlspecialchars($_POST['password']);
		$clean['level'] = htmlspecialchars($_POST['level']);
		
		$errorHeading = "Add User Result";
		// Check if the first name is not empty
		if(!empty($clean['firstName']))
		{
			// Check if the first name is not a string
			if(!is_string($clean['firstName']))
			{
				$error .= '<p>' . 'First name needs to be text' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'First Name can not be empty' . '</p>';
		}
		// Check if the last name is not empty
		if(!empty($clean['lastName']))
		{
			// Check if the last name is not a string
			if(!is_string($clean['lastName']))
			{
				$error .= '<p>' . 'Last name needs to be text' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Last Name can not be empty' . '</p>';
		}
		// Check if the username is not empty
		if(!empty($clean['username']))
		{
			// Check if the username is numeric
			if(is_numeric($clean['username']))
			{
				// Check if the username is a negative number
				if($clean['username'] < 0)
				{
					$error .= '<p>' . 'Username can not be negative' . '</p>';
				}
				// Check if the username is not equal to 4 characters long
				if(strlen($clean['username']) != 4)
				{
					$error .= '<p>' . 'Username has to be 4 digits' . '</p>';
				}
				// Check if the username starts with a zero, it is not allowed
				if(substr($clean['username'],0,1) == 0)
				{
					$error .= '<p>' . 'Username can not start with zero' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Username needs to be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Username can not be empty' . '</p>';
		}
		// Check if the password is not empty
		if(!empty($clean['password']))
		{
			// Check if the password is numeric
			if(is_numeric($clean['password']))
			{
				// Check if the password is not a negative number
				if($clean['password'] < 0)
				{
					$error .= '<p>' . 'Password can not be negative' . '</p>';
				}
				// Check if the password is 4 characters long
				if(strlen($clean['password']) != 4)
				{
					$error .= '<p>' . 'Password has to be 4 digits' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Password needs to be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Password can not be empty' . '</p>';
		}
		
		// Check if the user level is not empty
		if(!empty($clean['level']))
		{
			// Check if the user level is numeric
			if(is_numeric($clean['level']))
			{
				// Check if the user level is below or equal to zero
				if($clean['level'] <= 0)
				{
					$error .= '<p>' . 'User level can not be negative or zero' . '</p>';
				}
				// Check if the user level length is only 1 digit
				if(strlen($clean['level']) != 1)
				{
					$error .= '<p>' . 'User level has to be 1 digit' . '</p>';
				}
				else
				{
					// Check if the user level is more than 3. User Levels can only be one of 1/2/3.
					if($clean['level'] > 3)
					{
						$error .= '<p>' . 'User level has to be either 1,2,3.' . '</p>';
					}
				}
			}
			else
			{
				$error .= '<p>' . 'User level needs to be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'User level can not be empty' . '</p>';
		}
		// Check if there is no errors
		if(empty($error))
		{
			// Create the database object
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean up the values for using with the database
			$clean['firstName'] = $db->cleanInfo($clean['firstName']);
			$clean['lastName'] = $db->cleanInfo($clean['lastName']);
			$clean['username'] = $db->cleanInfo($clean['username']);
			$clean['password'] = $db->cleanInfo($clean['password']);
			$clean['level'] = $db->cleanInfo($clean['level']);
			// CHeck if the username already exists
			if($db->checkDuplicate('Users', 'username', $clean['username']))
			{
				$error .= '<p>' . 'That username already exists' . '</p>';
			}
			
			// Check if still no errors
			if(empty($error))
			{
				// Try and add user
				if($db->addUser($clean['firstName'], $clean['lastName'], $clean['username'], $clean['password'], $clean['level']))
				{
					$output .= 'The user was successfully added to the users table with values: First name= "' 
					. htmlentities($clean['firstName']) . '", Last name = "' . htmlentities($clean['lastName']) . '", Username = "' . 
					htmlentities($clean['username']) . '", Password = "' . htmlentities($clean['password']) . '", User level = "' . 
					htmlentities($clean['level']) . '". %0A';
				}
				else
				{
					$error .= '<p>' . 'The user has not been added' . '</p>';
				}
				
				if(empty($error))
				{
					// end connection
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// end connection
			$db->endConnection($con);	
		}
		else
		{
			$error .= '<p>' . 'Need to input values into every input field for this form' . '</p>';
		}
	}
	// Check to see if user has submiited the modify user form
	else if(isset($_POST['modifyUser']))
	{	
		// Instantialise the variables
		$usernameCheck = false;
		$firstCheck = false;
		$lastCheck = false;
		$passCheck = false;
		$levelCheck = false;
		// Clean up user inputs
		$clean['username'] = htmlspecialchars($_POST['username']);
		$clean['firstName'] = htmlspecialchars($_POST['firstName']);
		$clean['lastName'] = htmlspecialchars($_POST['lastName']);
		$clean['usernameChange'] = htmlspecialchars($_POST['usernameChange']);
		$clean['password'] = htmlspecialchars($_POST['password']);
		$clean['level'] = htmlspecialchars($_POST['level']);
		
		$errorHeading = "Modify User Result";
		// Check if username is not empty
		if(!empty($clean['username']))
		{
			// Check if the username is numeric
			if(is_numeric($clean['username']))
			{
				// Check if the username is a negative number
				if($clean['username'] < 0)
				{
					$error .= '<p>' . 'Username can not be negative' . '</p>';
				}
				// Check to see if the length of the username is not 4 digits long
				if(strlen($clean['username']) != 4)
				{
					$error .= '<p>' . 'Username has to be 4 digits' . '</p>';
				}
				// Check to see if the username starts with zero
				if(substr($clean['username'],0,1) == 0)
				{
					$error .= '<p>' . 'Username can not start with zero' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Username needs to be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Username can not be empty' . '</p>';
		}
		// Check if first name is not empty
		if(!empty($clean['firstName']))
		{
			// Check if first name is not a string
			if(!is_string($clean['firstName']))
			{
				$error .= '<p>' . 'First name needs to be text' . '</p>';
			}
			else
			{
				$firstCheck = true;
			}
		}
		// Check if the last name is not empty
		if(!empty($clean['lastName']))
		{
			// Check if the last name is not a string
			if(!is_string($clean['lastName']))
			{
				$error .= '<p>' . 'Last name needs to be text' . '</p>';
			}
			else
			{
				$lastCheck = true;
			}
		}
		// Check if the username to change to is not empty
		if(!empty($clean['usernameChange']))
		{
			// Check if the username to change to is numeric
			if(is_numeric($clean['usernameChange']))
			{
				// Check to see if the username to change to is a negative number
				if($clean['usernameChange'] < 0)
				{
					$error .= '<p>' . 'Username to change can not be negative' . '</p>';
				}
				// Check if the username to change to is not 4 digits long
				if(strlen($clean['usernameChange']) != 4)
				{
					$error .= '<p>' . 'Username to change has to be 4 digits' . '</p>';
				}
				else
				{
					$usernameCheck = true;
				}
				// Check if the username to change to begins with zero
				if(substr($clean['usernameChange'],0,1) == 0)
				{
					$error .= '<p>' . 'Username to change can not start with zero' . '</p>';
				}
				// Check to see if the username and username to change to are the same
				if($clean['username'] === $clean['usernameChange'])
				{
					$error .= '<p>' . 'Username and username to change to can not be the same' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Username to change needs to be numeric' . '</p>';
			}
		}
		// Check if the password is not empty
		if(!empty($clean['password']))
		{
			// Check to see if the password is numeric
			if(is_numeric($clean['password']))
			{
				// Check to see if the password is not negative
				if($clean['password'] < 0)
				{
					$error .= '<p>' . 'Password can not be negative' . '</p>';
				}
				// Check to see if the password is not 4 digits long
				if(strlen($clean['password']) != 4)
				{
					$error .= '<p>' . 'Password has to be 4 digits' . '</p>';
				}
				else
				{
					$passCheck = true;
				}
			}
			else
			{
				$error .= '<p>' . 'Password needs to be numeric' . '</p>';
			}
		}
		// Check if the user level is not empty
		if(!empty($clean['level']))
		{
			// Check if the user level is numeric
			if(is_numeric($clean['level']))
			{
				// Check if the user level is less than or equal to zero
				if($clean['level'] <= 0)
				{
					$error .= '<p>' . 'User level can not be negative or zero' . '</p>';
				}
				// Check if user level is not equal to just one digit
				if(strlen($clean['level']) != 1)
				{
					$error .= '<p>' . 'User level has to be 1 digit' . '</p>';
				}
				else
				{
					// Check if the user level is more than 3
					if($clean['level'] > 3)
					{
						$error .= '<p>' . 'User level has to be either 1,2,3.' . '</p>';
					}
					else
					{
						$levelCheck = true;
					}
				}
			}
			else
			{
				$error .= '<p>' . 'User level needs to be numeric' . '</p>';
			}
		}
		// Check if the user has entered valid inputs into the changes part of the form
		if(($usernameCheck == true) || ($firstCheck == true) || ($lastCheck == true)|| ($passCheck == true)|| ($levelCheck == true))
		{
			// Check if there is still no errors
			if(empty($error))
			{
				// Create a database object
				$db = createDatabaseObject();
				$con = $db->getLink();
				// Clean up the values to use with the database
				$clean['firstName'] = $db->cleanInfo($clean['firstName']);
				$clean['lastName'] = $db->cleanInfo($clean['lastName']);
				$clean['username'] = $db->cleanInfo($clean['username']);
				$clean['usernameChange'] = $db->cleanInfo($clean['usernameChange']);
				$clean['password'] = $db->cleanInfo($clean['password']);
				$clean['level'] = $db->cleanInfo($clean['level']);
				// Check if user wants to change the username
				if($usernameCheck == true)
				{
					// Check if the original username already exists
					if(!$db->checkDuplicate('Users', 'username', $clean['username']))
					{
						$error .= '<p>' . 'The original username does not exist in the database' . '</p>';
					}
					// Check if there is a user with the username to change to
					if($db->checkDuplicate('Users', 'username', $clean['usernameChange']))
					{
						$error .= '<p>' . 'The username to change to, already exists in the database' . '</p>';
					}
					// Check if there is still no errors
					if(empty($error))
					{
						// try and change the username
						if($db->changeUserValue('username', $clean['username'], $clean['usernameChange']))
						{
							$output .= 'The username has been changed from "' . htmlentities($clean['username']) .
							'" to "' . htmlentities($clean['usernameChange']) . '" for the Users Table.' . '%0A';
							
							if($_SESSION['username'] == $clean['username'])
							{
								$_SESSION['username'] = $clean['usernameChange'];
							}
							// Change the value of username to the one that it has just been changed to
							$clean['username'] = $clean['usernameChange'];
						}
						else
						{
							$error .= '<p>' . 'The username has not been changed' . '</p>';
						}
					}
				}
				// check if the user wants to change the first name
				if($firstCheck)
				{
					// Check if the username exists
					if(!$db->checkDuplicate('Users', 'username', $clean['username']))
					{
						$error .= '<p>' . 'The username does not exist in the database' . '</p>';
					}
					// get the first name for that username
					$getFirst = $db->getUserValue('first_name', $clean['username']);
					// check if the first name is equal to the first name entered by the user
					if($getFirst === $clean['firstName'])
					{
						$error .= '<p>' . 'The first name for username "' . htmlentities($clean['username']) . '" is the same as the first name
						that was inputted to change to' . '</p>';
					}
					// check to see if there is no errors
					if(empty($error))
					{
						// Try and change the first name
						if($db->changeUserValue('first_name', $clean['username'], $clean['firstName']))
						{
							$output .= 'The First name for username "' . htmlentities($clean['username']) . '" has been changed from "' 
							. htmlentities($getFirst) . '" to "' . htmlentities($clean['firstName']) . '".' . '%0A';
						}
						else
						{
							$error .= '<p>' . 'The first name has not been changed' . '</p>';
						}
					}
				}
				// check if user wants to change the last name
				if($lastCheck)
				{
					// check if the user exists
					if(!$db->checkDuplicate('Users', 'username', $clean['username']))
					{
						$error .= '<p>' . 'The username does not exist in the database' . '</p>';
					}
					// get the last name
					$getLast = $db->getUserValue('last_name', $clean['username']);
					// check if the last name for that username and the last name to change to are the same
					if($getLast === $clean['lastName'])
					{
						$error .= '<p>' . 'The last name for username "' . htmlentities($clean['username']) . '" is the same as the last name
						that was inputted to change to' . '</p>';
					}
					// Check if there is still no errors
					if(empty($error))
					{
						// Try and change the last name
						if($db->changeUserValue('last_name', $clean['username'], $clean['lastName']))
						{
							$output .= 'The Last name for username "' . htmlentities($clean['username']) . '" has been changed from "' 
							. htmlentities($getLast) . '" to "' . htmlentities($clean['lastName']) . '".' . '%0A';
						}
						else
						{
							$error .= '<p>' . 'The last name has not been changed' . '</p>';
						}
					}
				}
				// check if the user wants to change the password
				if($passCheck)
				{
					// Check if the user exists
					if(!$db->checkDuplicate('Users', 'username', $clean['username']))
					{
						$error .= '<p>' . 'The username does not exist in the database' . '</p>';
					}
					// get the password value
					$getPass = $db->getUserValue('password', $clean['username']);
					// see if the password and the new password are the same value
					if($getPass === $clean['password'])
					{
						$error .= '<p>' . 'The password for username "' . htmlentities($clean['username']) . '" is the same as the password
						that was inputted to change to' . '</p>';
					}
					// check if there is still no errors
					if(empty($error))
					{
						// Try and change the password
						if($db->changeUserValue('password', $clean['username'], $clean['password']))
						{
							$output .= 'The Password for username "' . htmlentities($clean['username']) . '" has been changed' . '%0A';
						}
						else
						{
							$error .= '<p>' . 'The password has not been changed' . '</p>';
						}
					}
				}
				// Check if the user wants to change the user level
				if($levelCheck)
				{
					// Check if the user exists
					if(!$db->checkDuplicate('Users', 'username', $clean['username']))
					{
						$error .= '<p>' . 'The username does not exist in the database' . '</p>';
					}
					// get the user level for that user
					$getLevel = $db->getUserValue('level', $clean['username']);
					// check if the user level and the level to change to are the same value
					if($getLevel === $clean['level'])
					{
						$error .= '<p>' . 'The user level for username "' . htmlentities($clean['username']) . '" is the same as the user level
						that was inputted to change to' . '</p>';
					}
					// check if there is no errors
					if(empty($error))
					{
						// Try and change the user level
						if($db->changeUserValue('level', $clean['username'], $clean['level']))
						{
							$output .= 'The user level for username "' . htmlentities($clean['username']) . '" has been changed from "' 
							. htmlentities($getLevel) . '" to "' . htmlentities($clean['level']) . '".' . '%0A';
						}
						else
						{
							$error .= '<p>' . 'The user level has not been changed' . '</p>';
						}
					}
				}
				// end connection
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
	// Check if the user has submitted the delete user form
	else if(isset($_POST['deleteUser']))
	{
		// get the values the user has entered
		$clean['username'] = htmlspecialchars($_POST['username']);
		$clean['user'] = htmlspecialchars($_SESSION['username']);
		$errorHeading = "Delete User Result";
		
		// Check if the username is not empty
		if(!empty($clean['username']))
		{
			// check if the username is numeric
			if(is_numeric($clean['username']))
			{
				// check if the username is not negative
				if($clean['username'] < 0)
				{
					$error .= '<p>' . 'Username can not be negative' . '</p>';
				}
				// check if the username is not equal to 4 digits
				if(strlen($clean['username']) != 4)
				{
					$error .= '<p>' . 'Username has to be 4 digits' . '</p>';
				}
				// check if the first digit of the username is a zero
				if(substr($clean['username'],0,1) == 0)
				{
					$error .= '<p>' . 'Username can not start with zero' . '</p>';
				}
				// check if the username is the same as the current logged in user
				if($clean['user'] === $clean['username'])
				{
					$error .= '<p>' . 'Not allowed to delete your own user details' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Username needs to be numeric' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Username can not be empty' . '</p>';
		}
		// Check if the delete checkbox is not empty
		if(!empty($_POST['deleteCheck']))
		{
			// get the value of the checkbox
			$clean['deleteCheck'] = htmlspecialchars($_POST['deleteCheck']);
			// check if the value of the checkbox is Yes
			if($clean['deleteCheck'] != 'Yes')
			{
				$error .= '<p>' . 'Delete checkbox not correct value has to be  positive' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Delete confirmation not ticked' . '</p>';
		}
		// check if no errors and the delete checkbox is ticked
		if((empty($error)) && ($clean['deleteCheck'] == 'Yes'))
		{
			// Create a database object
			$db = createDatabaseObject();
			$con = $db->getLink();
			// Clean up the value to use with the database
			$clean['username'] = $db->cleanInfo($clean['username']);
			// Check if the username exists in the database
			if(!$db->checkDuplicate('Users', 'username', $clean['username']))
			{
				$error .= '<p>' . 'The username "'. htmlentities($clean['username']) . '" does not exist in the database' . '</p>';
			}
			// if still no errors
			if(empty($error))
			{
				// Try and delete the user
				if($db->deleteUser($clean['username']))
				{
					$output .= 'The user record with username "' . htmlentities($clean['username']) .
					'" has been deleted from the user table.' . '%0A';
				}
				else
				{
					$error .= '<p>' . 'The user has not been deleted' . '</p>';
				}
				// Redirect to avoid user refreshing and resubmitting form
				if(empty($error))
				{
					// end connection
					$db->endConnection($con);
					// Pepare the url to redirect to
					$url = $self . "&&errorHeading=" . $errorHeading . "&&output=" . $output;
					// Change to the URL to display the information the user wants
					header("Location: $url");
					// Exit from the code
					exit();	
				}
			}
			// end connection
			$db->endConnection($con);	
		}
		else
		{
			$error .= '<p>' . 'Need to input username and checkbox must be ticked' . '</p>';
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