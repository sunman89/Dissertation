<?php

// Require the functions.php to use functions
	require_once('includes/functions.php');
	
// Variables
	$clean = array();
	$error = '';
	$complete = '';
	$headingStart =  '<h3>' . 'Add one product at a time' . '</h3>' . PHP_EOL .
		 '<p>' . 'Need to enter the first 13 digits of the barcode, which is the product code. Followed by  the title of the product, and then enter the price of the product.' . '<br/>' .  'Finally, once entered valid inputs, press the "Add Product" button to add the product to the database.' .  '</p>';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
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
	
	// Add product form
	$selfDir = htmlspecialchars($_SERVER['REQUEST_URI']);
	$addProductForm = '<form action="' . $selfDir . '" method="post" id="addProductForm">' . PHP_EOL .
				   '<fieldset>' . PHP_EOL .
				   '<legend>Enter details of new product: </legend>' . PHP_EOL . 
				   '<div>' . PHP_EOL . 
				   '<label for="productBar">Barcode: </label>' . PHP_EOL . 
				   '<input type="text" name="barcode" id="productBar" value="' . $barcode . '" onblur="JSvalidateAddProductBar()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddProductBarcode()" class="helpButton">' . '?' . '</a>' .
					 '<span id="addProductFormBarError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . 
				   '<div>' . PHP_EOL . 
				   '<label for="productTitle">Title: </label>' . PHP_EOL . 
				   '<input type="text" name="title" id="productTitle" value="' . $title . '" onblur="JSvalidateAddProductTitle()" />' . PHP_EOL . 
				   '<a href="#" onclick="helpAddProductTitle()" class="helpButton">' . '?' . '</a>'  .
					'<span id="addProductFormTitleError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . 
				   '<div>' . PHP_EOL . 
				   '<label for="productPrice">Price: £</label>' . PHP_EOL . 
				   '<input type="text" name="price" id="productPrice" value="' . $price . '" onblur="JSvalidateAddProductPrice()"/>' . PHP_EOL . 
				   '<a href="#" onclick="helpAddProductPrice()" class="helpButton">' . '?' . '</a>' . 
				   '<span id="addProductFormPriceError" class="errorJS">' . '</span>' . PHP_EOL . 
				   '</div>' . PHP_EOL . 
				   '<br/>' . PHP_EOL . 
				   '<input type="submit" name="addProductToTable" value="Add Product" />' . PHP_EOL . 
				   '</fieldset>' . PHP_EOL . 
				   '</form>' . PHP_EOL;
	
	// Save the usual content to be displayed
	$content = $headingStart . $addProductForm;
	
	// Check if the form was submitted
	if(isset($_POST['addProductToTable']))
	{
		// Clean up the inputs entered by the user
		$clean['barcode'] = htmlspecialchars($_POST['barcode']);
		$clean['title'] = htmlspecialchars($_POST['title']);
		$clean['price'] = htmlspecialchars($_POST['price']);
		
		// Test if barcode was not empty
		if(!empty($clean['barcode']))
		{
			// Check if the barcode is numeric
			if(is_numeric($clean['barcode']))
			{
				// Check to see if the barcode was 13 characters long
				if(strlen($clean['barcode']) != 13)
				{
					$error .= '<p>' . 'Barcode needs to be 13 digits long' . '</p>';
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
		
		// Check to see if the title was empty
		if(empty($clean['title']))
		{
			$error .= '<p>' . 'Title can not be empty' . '</p>';
		}
		
		// Check to see if the price is not empty
		if(!empty($clean['price']))
		{
			// Check to see if the price is numeric
			if(is_numeric($clean['price']))
			{
				// Create a variable to store the price entered formatted into the desired format so can compare the two
				$priceFormat = number_format($clean['price'], 2, '.', '');
				// Check to see if the price given by the user is not equal to the desired format, eg, if
				// price entered was 6.9876 then it would produce an error, however if the user enter price as 6, then it will be
				// okay because it is a double so it saves as 6.00
				if($clean['price'] != $priceFormat)
				{
					$error .= '<p>' . 'Price needs to be format "o.oo"' . '</p>';
				}
			}
			else
			{
				$error .= '<p>' . 'Price needs to be numeric and format ' . '&pound;' . 'o.oo' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Price can not be empty' . '</p>';
		}
		
		// If there was no errors then continue
		if(empty($error))
		{
			// Create a database onject and connection
			$productDb = createDatabaseObject();
			$con = $productDb->getLink();
			
			// Clean up the inputs again, ready to use with the database
			$clean['barcode'] = $productDb->cleanInfo($clean['barcode']);
			$clean['title'] = $productDb->cleanInfo($clean['title']);
			$clean['price'] = $productDb->cleanInfo($clean['price']);
			
			// Check to see if that barcode already exists in the products table
			if($productDb->checkDuplicate('Products','barcode', $clean['barcode']))
			{
				$error .= '<p>' . 'That barcode already exists' . '</p>';
			}
			// Check to see if that title already exists in the products table
			if($productDb->checkDuplicate('Products','title', $clean['title']))
			{
				$error .= '<p>' . 'That title already exists' . '</p>';
			}
			// If there is still no errors, then can try adding the product to the product table
			if(empty($error))
			{
				// Tests if adding the product succeeded or not
				if($product = $productDb->addProduct($clean['barcode'], $clean['title'], $clean['price']))
				{
					// The product was successfully added, so produce a success message for the user.
					$complete = '<p>' . 'Product "' .  htmlentities($clean['title']) .  '" has been added with barcode "' .
					$clean['barcode'] . '"</p>';
				}
				else
				{
					// Failed to add the product to the database
					$error .= '<p>' . 'Failed to insert product into database' . '</p>';
				}
			}
			// Must end the connection
			$productDb->endConnection($con);
		}
	}
	
// Prepare the output to be displayed to the screen
	// If there is errors, display the erros
	if(!empty($error))
	{
		return $content . $errorStart . $error;
	}
	// If the product was successfully added, then tell the user it was added
	else if(!empty($complete))
	{
		return $content . $complete;
	}
	// The usual output
	else
	{
		return $content;
	}

?>