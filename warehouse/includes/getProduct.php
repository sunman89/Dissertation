<?php
	
	// Get the barcode from the url given
	$bar = htmlspecialchars($_GET['barcode']);
	// Set errors to false
	$error = false;
	
	//Gets the config file, which stores the Database info
	require_once('config.inc.php');
	// Gets the functions needed
	require_once('functions.php');

	// Require the class Db - for creating and using the database connection as an object
	require_once ('../classes/Db.php');

	// Check if the barcode is not empty
	if(!empty($bar))
	{	
		// Check to see if the barcode is numeric
		if(is_numeric($bar))
		{
			// Check to see if the barcode is 15 digits long
			if(strlen($bar) == 15)
			{
				// Get the issue number from the barcode
				$issue = getIssueNumber($bar);
				// Cut the barcode down to the product code of the first 13 digits
				$bar = cutBarcode($bar);
			}
			else
			{
				$error = true;
			}
		}
		else
		{
			$error = true;
		}
		
		// If error is still false, then can continue to checkking the database
		if($error == false)
		{
			// Create the database object
			$hostDb = $config['db_host'];
			$userDb = $config['db_user'];
			$passDb = $config['db_pass'];
			$dbnameDb = $config['db_name'];
			
			$db = new Db($hostDb, $userDb, $passDb, $dbnameDb);
			$con = $db->getLink();
			
			// Clean up the inputs, ready to use with the database
			$issue = $db->cleanInfo($issue);
			$bar = $db->cleanInfo($bar);
			
			// Check if the stock actually exists for that barcode
			if($db->checkStockExist('Stock', $bar, $issue))
			{
				// If stock does exist, then try gather all the information about the stock for the user
				$output = $db->transferStockGatherInfo($bar, $issue);
				
				// if gathering the information was a success then continue
				if($output != false)
				{
					// Prepare the beginning of the table to output to the screen
					echo '<div id="displayedInformation" class="smallScreen">
						<h4 class="getProduct">Current Stock</h4>
						<table>
						<tr>
						<th>Barcode</th>
						<th>Issue Number</th>
						<th>Title</th>
						<th>Warehouse Stock</th>
						<th>Shop One Stock</th>
						<th>Shop Two Stock</th>
						</tr>';
					// Put the information gatherred into the table
					echo $output;
					// Close the table 
					echo "</table></div>";
				}
				else
				{
					// Was unsucessful gathering the info, so close the connection and display an error to the user
					echo "<p>A problem occurred retrieving product information for that barcode</p>";
				}
			}
			else
			{
				// The barcode does not exist in the stock table
				echo "<p>That barcode does not exist in the stock table</p>";
			}
			// End connection with the databasse because it is no longer needed
			$db->endConnection($con);
		}
		else
		{
			// Tell the user that the barcode is not valid
			echo "<p>That barcode is not valid</p>";
		}
	}	
	
?>