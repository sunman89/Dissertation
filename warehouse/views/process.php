<?php

	// Require functions
	require_once('includes/functions.php');
	
	// Variables
	$output = '';
	
	$printLink = '<button id="printPageButton"  onclick="pagePrint()">' .'Print' . '</button>'. PHP_EOL .
				'<p id="printPageInfo">' . 'To print using Firefox = click options menu and then print.' . '<br/>'
				 . 'To print using Google Chrome, right click and press print, or click on file and then print.' . '</p>';
				 
	 $keyIndex = "<p>Key: Bar = Barcode, Iss = Issue Number, WH = Warehouse Stock, Sh1 = Shop1 stock, Sh2 = Shop2 stock, FDR = First Delivery Received, LRD = Latest Return Date.";
	
	// Checks to see if there is a type value in the url 
	if (!isset($_GET['enquiry'])) 
	{
		// If there is not a GET type, then display the menu page
		$output = '<p>' . 'No enquiry has been selected' . '</p>';
	} 
	// Checks to see if a number has been entered into the type value
	elseif(is_numeric($_GET['enquiry']))
	{
		// If the get is a number, return the menu
		$output = '<p>' . 'No enquiry has been selected' . '</p>';
	}
	else
	{
		// Create a variable to store the get type value and clean it up
		$enquiryType = htmlspecialchars($_GET['enquiry']);
		$date = getCurrentDate();
		
		// Create a database object
		$db = createDatabaseObject();
		
		// Here it compares the $pageType with the views/pages of the app and outputs the correct content
		// This is for the enquiry to show all products and their information
		if($enquiryType == 'allProducts')
		{
			// To display the table for all products and their information
			$title = '<div>' . '<h3>' . "This is all products information for today = " . htmlentities($date) . '</h3>' . '</div>';
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
				'<th>' . 'Date Of Return' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->allProductsEnquiry();
			if(!empty($results))
			{
				$output = $title . $printLink . $keyIndex . $outputStart . $results . $outputEnd;
			}
		}
		// To gather the output for all products information in shop one
		else if($enquiryType == 'allShopOne')
		{
			$title = '<div>' . '<h3>' . "This is all products information for shop 1 as of today = " . htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Shop One Stock' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->allShopOneEnquiry();
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// For the enquiry to gather all products information that is in shop two
		else if($enquiryType == 'allShopTwo')
		{
			$title = '<div>' . '<h3>' . "This is all products information for shop 2 as of today = " . htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Shop Two Stock' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->allShopTwoEnquiry();
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// For the enquiry to gather all products that have stock in the warehouse but not in the shops
		else if($enquiryType == 'allWarehouse')
		{
			$title = '<div>' . '<h3>' . "This is all products that are just in warehouse, not in any shops as of today = " . htmlentities($date) .
			 '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Warehouse Stock' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->allWarehouseEnquiry();
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// For the enquiry to gather the data for all deliveries that happened today
		else if($enquiryType == 'deliveryToday')
		{
			$title = '<div>' . '<h3>' . "This is all delivery information for today = " . htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Quantity Delivered' . '</th>' . PHP_EOL .
				'<th>' . 'Date Receieved' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
		
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->todayDeliveryEnquiry($date);
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// For the enquiry to display all the products data that was returned today
		else if($enquiryType == 'returnsToday')
		{
			$date = getCurrentDate();
			$title = '<div>' . '<h3>' . "This is all returns information for today = " .  htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Quantity Returned' . '</th>' . PHP_EOL .
				'<th>' . 'Returned Date' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
		
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->todayReturnsEnquiry($date);
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// For the enquiry to gather products information for products that need to be returned
		else if($enquiryType == 'allReturns')
		{
			$title = '<div>' . '<h3>' . "This is all products that need to be returned before todays date = " . htmlentities($date) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Warehouse Stock' . '</th>' . PHP_EOL .
				'<th>' . 'Shop One Stock' . '</th>' . PHP_EOL .
				'<th>' . 'Shop Two Stock' . '</th>' . PHP_EOL .
				'<th>' . 'Stock Received' . '</th>' . PHP_EOL .
				'<th>' . 'Returned' . '</th>' . PHP_EOL .
				'<th>' . 'Date of First Delivery' . '</th>' . PHP_EOL .
				'<th>' . 'Date to be Returned' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->allReturnsEnquiry($date);
			if(!empty($results))
			{
				$output = $title . $printLink . $outputStart . $results . $outputEnd;
			}
		}
		// To gather delivery report for between two dates
		else if($enquiryType == 'delivery')
		{
			// Collect the inputs from user
			$startDate = htmlspecialchars($_GET['start']);
			$endDate = htmlspecialchars($_GET['end']);
			
			// Clean up the start and end date for use with the database
			$startDate = $db->cleanInfo($startDate);
			$endDate = $db->cleanInfo($endDate);
			$title = '<div>' . '<h3>' . "This is all delivery information for dates between " . htmlentities($startDate) . " and " .
			 htmlentities($endDate) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Stock Delivered' . '</th>' . PHP_EOL .
				'<th>' . 'Date Receieved' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
		
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->deliveryBetweenEnquiry($startDate, $endDate);
			if(!empty($results))
			{
				$output = $title . $printLink .  $outputStart . $results . $outputEnd;
			}
		}
		// To gather returns report for between two dates
		else if($enquiryType == 'returns')
		{
			// Get the users inputs from the URL
			$startDate = htmlspecialchars($_GET['start']);
			$endDate = htmlspecialchars($_GET['end']);
			
			// Clean the inputs to be used with the database
			$startDate = $db->cleanInfo($startDate);
			$endDate = $db->cleanInfo($endDate);
			$title = '<div>' . '<h3>' . "This is all returns information for dates between " . htmlentities($startDate) . " and " .
			 htmlentities($endDate) . '</h3>' . '</div>';
			$outputStart = '<div class="smallScreen">' . PHP_EOL . 
				'<table>' . PHP_EOL . 
				'<tr>' . PHP_EOL .
				'<th>' . 'Barcode' . '</th>' . PHP_EOL .
				'<th>' . 'Issue Number' . '</th>' . PHP_EOL .
				'<th>' . 'Title' . '</th>' . PHP_EOL .
				'<th>' . 'Price' . '</th>' . PHP_EOL .
				'<th>' . 'Quantity Returned' . '</th>' . PHP_EOL .
				'<th>' . 'Returned Date' . '</th>' . PHP_EOL .
				'</tr>' . PHP_EOL;
		
			$outputEnd = '</table>' . PHP_EOL . '</div>' . PHP_EOL;
			$results = $db->returnBetweenEnquiry($startDate, $endDate);
			if(!empty($results))
			{
				$output = $title . $printLink .  $outputStart . $results . $outputEnd;
			}
		}
		// Else the enquiry was not a valid enquiry
		else
		{
			$output = '<p>' . 'Not recognised page' . '</p>';
		}	
	// end connection
	$db->endConnection($db->getLink());	
	}
		
	// Return the output to be displayed on the screen
	if(empty($output))
	{
		$output = '<p>' . 'No results found for that enquiry' . '</p>';
		return $output;
	}
	else
	{
		return $output;
	}

?>