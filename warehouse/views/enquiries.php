<?php

// Variables
	$clean = array();
	$error ='';
	$errorStart = '<h4>' . 'Errors:' . '</h4>';
	$selfDir = htmlspecialchars($_SERVER['REQUEST_URI']);
	
	// Set the variables to use with the form
	$dStart = '';
	$dEnd = '';
	$rStart = '';
	$rEnd = '';
	// Then this it to gather the form inputs and keep them written inside the form so the user can see them
	if($_POST)
	{
		if(isset($_POST['deliveryDateSubmit']))
		{
			$dStart = $_POST['deliveryStart'];
			$dEnd = $_POST['deliveryEnd'];
		}
		else if(isset($_POST['returnDateSubmit']))
		{
			$rStart = $_POST['returnStart'];
			$rEnd = $_POST['returnEnd'];
		}
	}
		
	
	// Put together the menu and the links, each link goes to index.php?type=process and sends a specific enquiry
	// Then on the process page, it gets the enquiry information and displays the appropriate information
	$enquirymenu = '<h3>' . 'Select an Enquiry from below: ' . '</h3>' . '<ul class="enquiriesMenu">' . PHP_EOL;
	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=allProducts">' . 'Display All Products' . '</a>' .
	 '</li>'. PHP_EOL;

	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=allShopOne">' . 'Display All Products in shop 1' .
	 '</a>' . '</li>' . PHP_EOL;
	
	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=allShopTwo">' . 'Display All Products in shop 2' 
	. '</a>' . '</li>' . PHP_EOL;
	
	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=allWarehouse">' . 'Display All Products in just warehouse' 
	. '</a>' . '</li>' . PHP_EOL;
	
	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=deliveryToday">' . 'Display The Delivery Report for Today' .
	 '</a>' . '</li>' . PHP_EOL;
	
	$enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=returnsToday">' . 'Display The Returns Report for Today'.
	 '</a>' . '</li>' . PHP_EOL;
	 
	 $enquirymenu .= '<li>' . '<a href="index.php?type=process&&enquiry=allReturns">' . 'Display The Products Needed to be returned' .
	 '</a>' . '</li>' . PHP_EOL;
	 
	 // Close up the menu
	$enquirymenu .= '</ul>'. PHP_EOL;
	
	$enquirymenu .= '<p class="enquiryCenter">' . 'Delivery Report for dates between: ' .
	'<a href="#" onclick="helpEnquiryDeliveryDates()" class="helpButton">' . '?' . '</a>' . '</p>' . PHP_EOL;
	
	
	// Delivery Dates form
	$enquirymenu .= '<form action="' . $selfDir . '" method="post" id="enquiryDeliveryForm">' . PHP_EOL .
			   '<fieldset>' . PHP_EOL .
			   '<legend>Select Delivery Dates</legend>' . PHP_EOL . 
			   '<div>' . PHP_EOL . 
			   '<label for="deliveryStartDate">Delivery Start Date: </label>' . PHP_EOL . 
			   '<input type="date" name="deliveryStart" id="deliveryStartDate" value="' . $dStart . '" onblur="JSvalidateEnquiriesDeliveryStart()"/>' 
			   . '<span id="enquiriesDeliveryFormStartError" class="errorJS">' . '</span>' . PHP_EOL .
			   '</div>' . PHP_EOL . 
			   '<br/>' . 
			   '<div>' . PHP_EOL . 
			   '<label for="deliveryEndDate">Delivery End Date: </label>' . PHP_EOL . 
			   '<input type="date" name="deliveryEnd" id="deliveryEndDate" value="' . $dEnd . '" onblur="JSvalidateEnquiriesDeliveryEnd()"/>' .
			   '<span id="enquiriesDeliveryFormEndError" class="errorJS">' . '</span>' . PHP_EOL .
			   '</div>' . PHP_EOL . 
			   '<br/>' . PHP_EOL . 
			   '<input type="submit" name="deliveryDateSubmit" value="Check Deliveries" />' . PHP_EOL . 
			   '</fieldset>' . PHP_EOL . 
			   '</form>' . PHP_EOL;
	
	$enquirymenu .= '<p class="enquiryCenter">' .  'Returns Report for dates between: ' .
	'<a href="#" onclick="helpEnquiryReturnsDates()" class="helpButton">' . '?' . '</a>' . '</p>' . PHP_EOL;
	
	// Return dates form
	$enquirymenu .= '<form action="' . $selfDir . '" method="post" id="enquiryReturnForm">' . PHP_EOL .
			   '<fieldset>' . PHP_EOL .
			   '<legend>Select Return Dates</legend>' . PHP_EOL . 
			   '<div>' . PHP_EOL . 
			   '<label for="returnStartDate">Return Start Date: </label>' . PHP_EOL . 
			   '<input type="date" name="returnStart" id="returnStartDate" value="' . $rStart . '" onblur="JSvalidateEnquiriesReturnStart()"/>' .
			   '<span id="enquiriesReturnFormStartError" class="errorJS">' . '</span>' . PHP_EOL .
			   '</div>' . PHP_EOL . 
			   '<br/>' . 
			   '<div>' . PHP_EOL . 
			   '<label for="returnEndDate">Return End Date: </label>' . PHP_EOL . 
			   '<input type="date" name="returnEnd" id="returnEndDate" value="' . $rEnd . '" onblur="JSvalidateEnquiriesReturnEnd()"/>' .
			   '<span id="enquiriesReturnFormEndError" class="errorJS">' . '</span>' . PHP_EOL .
			   '</div>' . PHP_EOL . 
			   '<br/>' . PHP_EOL . 
			   '<input type="submit" name="returnDateSubmit" value="Check Returns" />' . PHP_EOL . 
			   '</fieldset>' . PHP_EOL . 
			   '</form>' . PHP_EOL;
			  
	
	// Check if the delivery dates form has been submitted
	if(isset($_POST['deliveryDateSubmit']))
	{
		// Get the values the user has entered
		$clean['deliveryStart'] = htmlspecialchars($_POST['deliveryStart']);
		$clean['deliveryEnd'] = htmlspecialchars($_POST['deliveryEnd']);
		
		// Checks if delivery start date is empty
		if(!empty($clean['deliveryStart']))
		{
			// Check if the dates given are actual dates and in the correct format
			if(!checkTheDate($clean['deliveryStart']))
			{
				$error .= '<p>' . 'Delivery Start date is not a valid date, needs to be YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Delivery Start date can not be empty' . '</p>';
		}
		
		// Checks if delivery end date is empty
		if(!empty($clean['deliveryEnd']))
		{
			// Check if the dates given are actual dates and in the correct format
			if(!checkTheDate($clean['deliveryEnd']))
			{
				$error .= '<p>' . 'Delivery End date is not a valid date, needs to be YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Delivery End date can not be empty' . '</p>';
		}
	
		// If no errors, then continue
		if(empty($error))
		{
			// Pepare the url to send to the process page
			$url = 'index.php?type=process&&enquiry=delivery&&start=' . htmlentities($clean['deliveryStart']) . 
			'&&end=' . htmlentities($clean['deliveryEnd']);
			// Change to the URL to display the information the user wants
			header("Location: $url");
			// Exit from the code
			exit();
		}
	}
	// Checks if the return dates form has been submiited
	else if(isset($_POST['returnDateSubmit']))
	{
		$clean['returnStart'] = htmlspecialchars($_POST['returnStart']);
		$clean['returnEnd'] = htmlspecialchars($_POST['returnEnd']);
		
		// Checks to see if return start date is empty
		if(!empty($clean['returnStart']))
		{
			// Checks to see if it is an actual date and correct format
			if(!checkTheDate($clean['returnStart']))
			{
				$error .= '<p>' . 'Returns Start date is not a valid date, needs to be YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Returns Start date can not be empty' . '</p>';
		}
		
		// Checks to see if return start date is empty
		if(!empty($clean['returnEnd']))
		{
			// Checks to see if it is an actual date and correct format
			if(!checkTheDate($clean['returnEnd']))
			{
				$error .= '<p>' . 'Returns End date is not a valid date, needs to be YYYY-MM-DD' . '</p>';
			}
		}
		else
		{
			$error .= '<p>' . 'Returns End date can not be empty' . '</p>';
		}
		
		// If errors is empty, proceed
		if(empty($error))
		{
			// Prepare the URL to redirect to
			$url = 'index.php?type=process&&enquiry=returns&&start=' . htmlentities($clean['returnStart']) . '&&end='
			 . htmlentities($clean['returnEnd']);
			// Redirect to the url, to gather the information the user requested
			header("Location: $url");
			// Exit from the code
			exit();
		}
	}
	
//Display the output
	// If errors, dispplay the erros and the menu
	if(!empty($error))
	{
		$final = $errorStart . $error . $enquirymenu;
		return $final;
	}
	// Else just ouput the menu
	else
	{
		return $enquirymenu;
	}

?>
