<?PHP

// All functions that are used often

	// Create a database object and return it, so can use the database class methods
	function createDatabaseObject()
	{
		//Gets the config file, which stores the Database info
		require('includes/config.inc.php');
	
		// Require the class Db - for creating and using the database connection as an object
		require_once 'classes/Db.php';
		
		// To connect to the database and create a database object by constructing the object with these parameters
		$hostDb = $config['db_host'];
		$userDb = $config['db_user'];
		$passDb = $config['db_pass'];
		$dbnameDb = $config['db_name'];
		
		// Instantiase a new Db object
		$functionsdb = new Db($hostDb, $userDb, $passDb, $dbnameDb);
	
		// Returns the newly created database object
		return $functionsdb;
	}
	
	// To get current date in required format
	function getCurrentDate()
	{
		return date("Y-m-d");
	}
	
	// This adds a month to the delivered date, and stores this as the date the delivered products need to be returned by
	function getReturnDate($date)
	{
		$returnDate = strtotime('+1 month', strtotime($date));
		$returnDate = date("Y-m-d", $returnDate);
		return $returnDate;
	}
	
	// This gets the correct value for use in the database tables, by testing the value selected by the user
	function getCorrectLocation($location)
	{
		if($location == 'Warehouse')
		{
			$location = 'warehouse_stock';
		}
		else if($location == 'Shop1')
		{
			$location = 'shop1_stock';
		}
		else if($location == 'Shop2')
		{
			$location = 'shop2_stock';
		}
		else
		{
			$location = '';
		}
		return $location;
	}
	
	// This will get rid of the leading zero from the issue number so can insert, compare, use with the database properly
	function cutIssueNumber($issue)
	{
		if(substr($issue,0,1) == 0)
		{
			$issue = substr($issue,1);
		}
		return $issue;
	}
	
	// This will get the last two digits from a 15 digit barcode, which is the issue number
	function getIssueNumber($barcode)
	{
			// Need to get issue number first from barcode
			$issue = substr($barcode,13,15);
			// If the issue number begins with zero eg, 02, then get rid of the zero.
			$issue = cutIssueNumber($issue);
			return $issue;
	}
	
	// After getting the issue number from the 15 digit barcode, cut it down to 13 digits.
	function cutBarcode($barcode)
	{
			// Cut barcode down to 13 digits, which is the product code
			$barcode = substr($barcode,0, 13);
			return $barcode;
	}
	
	// This will format the price given into the appropriate format and ass the pound (£) sign at the front
	function formatMoney($price)
	{
		// Format to 2 decimal places, and have a (.) to seperate the decimal
		$price = number_format((float)$price, 2, '.', '');
		$price = '&pound;' . $price;
		return $price;
	}
	
	// Use this to test for if the input is an actual date
	function checkTheDate($date)
	{
		return (date('Y-m-d', strtotime($date)) == $date);
	}
	
	// Use to display issue number properly by checking if the issue number is just one digit, if it is, then add a leading zero
	function displayIssue($issue)
	{
		if(strlen($issue) == 1)
		{
			$issue = '0' . $issue;
		}
		return $issue;
	}
	
	// This is to make sure the username or password is 4 digits, if not then it adds leading zeros to the number 
	// until it is 4 digits long, eg, if someones password is 0021, it is stored into the database as 21. So have to add the
	// zeros to the front so everything works properly
	function getFourDigits($info)
	{
		if(strlen($info) < 4)
		{
			while(strlen($info) < 4)
			{
				$info = '0' . $info;
			}
		}
		return $info;
		
	}
	
?>