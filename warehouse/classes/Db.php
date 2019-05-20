<?php

	/*
		This is the database class.
		It contains the constructor to construct a database object, getter methods and every method that
		is used to interact with the database
	*/
	class Db
	{
		// This is the variable used to hold the connection link to the database
		private $link;
		
		/*
			This constructs the database object using the config files values, to establish a connection to the database.
		*/
		public function __construct($host,$user,$pass,$db)
		{	
			$this->link = mysqli_connect($host, $user, $pass, $db);
			if(mysqli_connect_errno())
			{
				exit(mysqli_connect_error());
			}
		}
		
		/*
			This is a method to return the link of the connection.
		*/
		public function getLink()
		{
			return $this->link;
		}
		
		/*
			This is a method to end the connection to the database. 
		*/
		public function endConnection($con) 
		{
			mysqli_close($con);
		}
		
		/*
			This is a method that frees up the result from a query to the database.
		*/
		public function freeResult($result) 
		{
			mysqli_free_result($result);
		}
		
		/*
			This is a method call that cleans up the value sent to it, so that the value can be used with the database
			without causing any problems. And returns the cleaned value for another method to use.
		*/
		public function cleanInfo($info)
		{
			$con = $this->link;
			$clean = mysqli_real_escape_string($con, $info);
			return $clean;
		}
		
		/*
			This is a method call to get the result from a sql query. 
		*/
		public function getResult($sql)
		{
			$con = $this->link;
			$result = mysqli_query($con, $sql);
			$test = $this->checkResult($result);
			if($result == $test)
			{
				return $result;
			}
			else
			{
				return $test;
			}
		}
		
		/*
			This is a method call to add a product to the table Products in the database.
		*/
		public function addProduct($barcode, $title, $price)
		{
			$con = $this->link;
			$sql = "INSERT INTO Products (barcode, title, price) VALUES ('$barcode', '$title' , '$price')";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method that checks for any duplicates of a certain value. You give it a table to check and the column of that
			table, then give it a value to check for. If that value is within that specific column in that table, then it will
			return true.
		*/
		public function checkDuplicate($tableName, $columnName, $info)
		{	
			$sql = "Select $columnName FROM $tableName";
			$result = $this->getResult($sql);
			while($row = mysqli_fetch_assoc($result))
			{
				if($row[$columnName] == $info)
				{
					$this->freeResult($result);
					return true;
				}
			}
			$this->freeResult($result);
			return false;
		}
		
		/*
			This is a method that checks if the result is false. If it is false, it then puts together an error message and
			returns it to display to the user.
		*/
		public function checkResult($result)
		{
			if($result == false)
			{
				$error = mysqli_error($this->getLink());
				$mError = '<p>' . 'MySQL error = ' . $error . '</p>';
				$this->freeResult($result);
				return $mError;
			}
			else
			{
				return $result;
			}
		}
		
		/*
			This is a method call to check if that user exists in the database.
		*/
		public function checkUser($cleanUser)
		{
			$user = $this->checkDuplicate('Users','username',$cleanUser);
			return $user;
		}
		
		/*
			This is a method to get the users level. So can display the relevant options in the menu for that users level.
		*/
		public function getLevel($user)
		{
			// Variable to store the users level
			$level = '';
			
			// Get the connection from the object, so can use with sql
			$con = $this->getLink();
			
			// Prepare the query
			$sql = "Select username, level FROM Users";
				
			// Use a method in the database class to get the result of the query and return it
			$result = $this->getResult($sql);
				
			// If the result is equal to false, gather the outputs and return it to the user
			if($result == false)
			{
				// Gather the error message in a variable
				$mError = mysqli_error($con);
				return $mError;
			}
			// Else if the result is true
			else
			{
				// Loop through all the rows of the result
				while($row = mysqli_fetch_assoc($result))
				{
					// Check to see if the username and password match a row from the Users table
					if($user == $row['username'])
					{
						$level = $row['level'];
					}
				}
			}
			$this->freeResult($result);
			return $level;
		}
		
		/*
			This is a method that checks whether the stock exists for a certain barcode and issue number.
			It can be used for Stock, Deliveries, Returns tables.
		*/
		public function checkStockExist($tableName, $barcode, $issue)
		{
			$sql = "Select barcode, issue FROM $tableName";
			$result = $this->getResult($sql);
			while($row = mysqli_fetch_assoc($result))
			{
				if(strlen($row['issue'] == 1))
				{
					$row['issue'] = '0' . $row['issue'];
				}
				if(($row['barcode'] == $barcode) && ($row['issue'] == $issue))
				{
					$this->freeResult($result);
					return true;
				}
			}
			$this->freeResult($result);
			return false;
		}
		
		/*
			This is a method that inserts a product into the Stock table.
		*/
		public function addDelivery($barcode, $issue, $wareStock, $currentDate, $returnDate)
		{
			$con = $this->link;
			$sql = "INSERT INTO Stock (barcode, issue, warehouse_stock, shop1_stock, shop2_stock, received_date, return_date)
			 VALUES ('$barcode', '$issue' , '$wareStock', '0', '0', '$currentDate', '$returnDate')";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method to update a record in the Stock table instead of adding a new record, it just updates the record
			that alrady exists.
		*/
		public function updateDelivery($barcode, $issue, $wareStock)
		{
			$con = $this->link;
			$sql = "UPDATE Stock SET warehouse_stock = warehouse_stock + '$wareStock'
			 WHERE barcode = '$barcode' AND issue = '$issue'";
			$result = mysqli_query($con, $sql);
			return $result;
		}
	
		/*
			This is a method to check if the current date is more than the return date. So it checks whether the date for the 
			product to be returned is before todays date.
		*/
		public function checkCurrentToReturnDate($tableName, $columnName, $date, $barcode, $issue)
		{	
			$sql = "Select $columnName FROM $tableName WHERE barcode = $barcode AND issue = $issue";
			$result = $this->getResult($sql);
			while($row = mysqli_fetch_assoc($result))
			{
				$returnDate = strtotime($row[$columnName]);
				$returnDate = date("Y-m-d", $returnDate);
				if($date >= $returnDate)
				{
					$this->freeResult($result);
					return true;
				}
			}
			$this->freeResult($result);
			return false;
		}

		/*
			This is a method to add a record to the returns table
		*/
		public function addReturns($barcode, $issue, $quantity, $date)
		{
			$con = $this->link;
			$sql = "INSERT INTO Returns (barcode, issue, return_quantity, return_date)
			 VALUES ('$barcode', '$issue' , '$quantity','$date')";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method to update a returns record if the a record already exists for that product and date
		*/
		public function updateReturns($barcode, $issue, $quantity, $date)
		{
			$con = $this->link;
			$sql = "UPDATE Returns SET return_quantity = return_quantity + '$quantity'
			 WHERE barcode = '$barcode' AND issue = '$issue' AND return_date = '$date'";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method to remove stock from the Stock table. Can be used to remove stock from Warehouse, Shop 1 or Shop 2.
		*/
		public function removeStock($barcode, $issue, $location, $quantity)
		{
			$con = $this->getLink();
			if(substr($issue,0,0) == 0)
			{
				$issue = substr($issue,1,1);
			}
			$sql = "UPDATE Stock SET $location = $location - $quantity
			WHERE barcode = '$barcode' AND issue = '$issue'";
			$result = mysqli_query($con, $sql);
			return $result;
		}

		/*
			This is a method to get the quantity of stock for a certain location (Warehouse, Shop1, Shop2), for a certain product
			using the barcode and issue number. Plus can be used to get any column information from a table.
		*/
		public function getStock($columnName, $barcode, $issue, $tableName)
		{
			$con = $this->getLink();
			if(strlen($issue) == 2)
			{
				if(substr($issue,0) == 0)
				{
					$issue = substr($issue,1,1);
				}
			}
			$sql = "SELECT $columnName FROM $tableName WHERE barcode = '$barcode' AND issue = '$issue'";
			$result = mysqli_query($con, $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$row = mysqli_fetch_assoc($result);
				$stock = $row[$columnName];
				return $stock;
			}
		}
	
		/*
			This is a method to get one of the dates in the tables, eg, Stock table has received date and return date. So can use
			this to get that information. Can use this to get information from any table except products and users. Use this to be
			more specific when looking for a product, for example in deliveries table, there is duplicate records with the only
			difference being the date it was added to the table. This method can be used to get information from that 
			specific record.
		*/
		public function getStockDate($columnName, $barcode, $issue, $tableName, $date, $originalDate)
		{
			$con = $this->getLink();
			if(strlen($issue) == 2)
			{
				if(substr($issue,0) == 0)
				{
					$issue = substr($issue,1,1);
				}
			}
			
			$sql = "SELECT $columnName FROM $tableName WHERE barcode = '$barcode' AND issue = '$issue' AND $date = '$originalDate'";
			$result = mysqli_query($con, $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$row = mysqli_fetch_assoc($result);
				$stock = $row[$columnName];
				return $stock;
			}	
		}
		
		/*
			This is a method that gathers all the data from the database except for the users table. And puts all the data into
			a table. It gathers certain data based on what has been sent to it. It is called when a user uses the title check form
			to gather the information from what they have inputted into the form.
		*/
		public function gatherAllData($barcode, $issue, $price, $title)
		{
			$con = $this->getLink();
			$sql = '';
			if(!empty($issue))
			{
				$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, p.price, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivered_quant, s.received_date,s.return_date,
					r.return_quantity AS return_sum, r.return_date  AS returned_date
					FROM (SELECT barcode, title, price FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity, MAX(return_date) return_date
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE s.barcode='$barcode' AND s.issue='$issue'
					GROUP BY p.barcode, s.issue, p.title, p.price, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
						
			}
			else if(!empty($barcode))
			{
				$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, p.price, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivered_quant, s.received_date,s.return_date,
					r.return_quantity AS return_sum, r.return_date  AS returned_date
					FROM (SELECT barcode, title, price FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity, MAX(return_date) return_date
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE s.barcode='$barcode'
					GROUP BY p.barcode, s.issue, p.title, p.price, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
			}
			else if(!empty($title))
			{
				$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, p.price, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivered_quant, s.received_date,s.return_date,
					r.return_quantity AS return_sum, r.return_date  AS returned_date
					FROM (SELECT barcode, title, price FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity, MAX(return_date) return_date
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE p.title LIKE '%$title%'
					GROUP BY p.barcode, s.issue, p.title, p.price, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
			}
			else if(!empty($price))
			{
				$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, p.price, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivered_quant, s.received_date,s.return_date,
					r.return_quantity AS return_sum, r.return_date  AS returned_date
					FROM (SELECT barcode, title, price FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity, MAX(return_date) return_date
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE p.price='$price'
					GROUP BY p.barcode, s.issue, p.title, p.price, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
			}
			else
			{
				return false;
			}
			
			$result = mysqli_query($con, $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['delivered_quant'] . '</td>' . PHP_EOL .
								'<td>' . $row['received_date'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_sum'] . '</td>' . PHP_EOL .
								'<td>' . $row['returned_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method that is used when the users wants to display all the products and the information about those
			products. It essentially gathers all the data from the database and puts it into a table for the user to view.
		*/
		public function allProductsEnquiry()
		{			
				$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, p.price, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivery_received, s.received_date,s.return_date,
					r.return_quantity AS return_sum, r.return_date  AS returned_date
					FROM (SELECT barcode, title, price FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity, MAX(return_date) return_date
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					GROUP BY p.barcode, s.issue, p.title, p.price, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
					
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['delivery_received'] . '</td>' . PHP_EOL .
								'<td>' . $row['received_date'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_sum'] . '</td>' . PHP_EOL .
								'<td>' . $row['returned_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to all the information about products that have stock in shop 1.
		*/
		public function allShopOneEnquiry()
		{
			$sql = "SELECT Products.barcode, Stock.issue, Products.title, Products.price, Stock.shop1_stock
					FROM Products
					LEFT OUTER JOIN Stock
					ON Products.barcode=Stock.barcode
					WHERE Stock.shop1_stock IS NOT NULL AND Stock.shop1_stock>0
					ORDER BY Products.title, Stock.issue ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to get all the products information for products that have stock in Shop 2.
		*/
		public function allShopTwoEnquiry()
		{
			$sql = "SELECT Products.barcode, Stock.issue, Products.title, Products.price, Stock.shop2_stock
					FROM Products
					LEFT OUTER JOIN Stock
					ON Products.barcode=Stock.barcode
					WHERE Stock.shop2_stock IS NOT NULL AND Stock.shop2_stock>0
					ORDER BY Products.title, Stock.issue ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to get all the products information for products that have stock in the warehouse but currently have
			none in either of the shops.
		*/
		public function allWarehouseEnquiry()
		{
			$sql = "SELECT Products.barcode, Stock.issue, Products.title, Products.price, Stock.warehouse_stock
					FROM Products
					LEFT OUTER JOIN Stock
					ON Products.barcode=Stock.barcode
					WHERE Stock.warehouse_stock IS NOT NULL AND Stock.warehouse_stock>0 AND Stock.shop1_stock <=0 
					AND Stock.shop2_stock<=0
					ORDER BY Products.title, Stock.issue ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to gather the information about the products that have been delivered today.
		*/
		public function todayDeliveryEnquiry($date)
		{
			$sql = "SELECT d.barcode, d.issue, p.title, p.price, d.delivered_quantity, d.delivered_date
					FROM Products p
					LEFT OUTER JOIN Deliveries d
					ON p.barcode=d.barcode
					WHERE d.delivered_date='$date'
					ORDER BY p.title, d.issue ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['delivered_quantity'] . '</td>' . PHP_EOL .
								'<td>' . $row['delivered_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to gather the information about all the products that have been taken off the shelves and out of the 
			warehouse and been returned today.
		*/
		public function todayReturnsEnquiry($date)
		{
			$sql = "SELECT Products.barcode, Returns.issue, Products.title, Products.price,
					Returns.return_quantity, Returns.return_date
					FROM Products
					LEFT OUTER JOIN Returns
					ON Returns.barcode=Products.barcode
					WHERE Returns.return_date='$date'
					ORDER BY Products.title, Returns.issue ASC";
				
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['return_quantity'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to gather all the relevant information about products delivered between two dates.
		*/
		public function deliveryBetweenEnquiry($startDate, $endDate)
		{
			$sql = "SELECT p.barcode, d.issue, p.title, p.price, d.delivered_quantity, d.delivered_date
					FROM Products p
					LEFT OUTER JOIN Deliveries d
					ON p.barcode=d.barcode
					WHERE d.delivered_date>='$startDate' AND d.delivered_date<='$endDate'
					ORDER BY p.title, d.issue, d.delivered_date ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['delivered_quantity'] . '</td>' . PHP_EOL .
								'<td>' . $row['delivered_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to gather all the relevant information about products that have been returned between two dates.
		*/
		public function returnBetweenEnquiry($startDate, $endDate)
		{
			$sql = "SELECT Products.barcode, Returns.issue, Products.title, Products.price,
					Returns.return_quantity, Returns.return_date
					FROM Products
					LEFT OUTER JOIN Returns
					ON Returns.barcode=Products.barcode
					WHERE Returns.return_date>='$startDate' OR Returns.return_date<='$endDate'
					ORDER BY Products.title, Returns.issue, Returns.return_date ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . formatMoney($row['price']) . '</td>' . PHP_EOL .
								'<td>' . $row['return_quantity'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}

		/*
			This is a method to transfer stock from the warehouse to either of the shops in the Stock table.
		*/
		public function transferStock($barcode, $issue, $location, $quantity)
		{	
			$sql = "UPDATE Stock SET warehouse_stock = warehouse_stock - $quantity, $location = $location + $quantity
					WHERE barcode = $barcode AND issue = $issue";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	
		/*
			This is a method to change a barcode and issue of a product in Stock, Returns, Delivery tables.
		*/
		public function changeBarcode($tableName, $barcode, $issue, $barcodeChange, $issueChange, $date, $originalDate)
		{
			$sql = "UPDATE $tableName SET barcode = $barcodeChange, issue = $issueChange
					WHERE barcode = $barcode AND issue = $issue AND $date = '$originalDate'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method alter the quantity of the stock in the Stock table. It allows negative values, so that the 
			user can entera quantity they wish to change it by. For example, if the Stock in warehouse was 6 on the system but 
			was really 7, they would just enter 1 and it would add 1 to 6 and make 7. Also, if the stock in the warehouse 
			said 7 and the stockwas actually 6, they could enter -1 and it would subtract that from 7 to get 6.
		*/
		public function changeQuantity($tableName, $columnName, $barcode, $issue, $quantity)
		{
			$sql = "UPDATE $tableName SET $columnName = $columnName + $quantity
					WHERE barcode = $barcode AND issue = $issue";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method alter the quantity of the stock in a table that needs to use a date to specify that record. 
			The deliveries and returns table use dates to specify each record. It allows negative values, so that the user 
			can enter a quantity they wish to change it by. For example, if the Stock in deliveries for a record with date
			2017-04-20 was 6 on the system but was really 7, they would just enter 1 and it would add 1 to 6 and make 7. 
			Also, if the stock in the delivery for the date 2017-04-20 said 7 and the stock was actually 6, they 
			could enter -1 and it would subtract that from 7 to get 6.
		*/
		public function changeQuantityDate($tableName, $columnName, $barcode, $issue, $quantity, $date, $originalDate)
		{
			$sql = "UPDATE $tableName SET $columnName = $columnName + $quantity
					WHERE barcode = $barcode AND issue = $issue AND $date = '$originalDate'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to change the date of a record. The date to change is decided by the column name, so if the user wanted
			to change the received date on the stock table for a certain record, it would be received date that would be changed.
		*/
		public function changeDate($tableName, $columnName, $barcode, $issue, $date)
		{
			$sql = "UPDATE $tableName SET $columnName = '$date'
					WHERE barcode = $barcode AND issue = $issue";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method change a date of a record by using an original date as a reference to that specific product.
		*/
		public function changeDateOriginal($tableName, $columnName, $barcode, $issue, $date, $originalDate)
		{
			$sql = "UPDATE $tableName SET $columnName = '$date'
					WHERE barcode = $barcode AND issue = $issue AND $columnName = '$originalDate'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to retrieve a certain date from a table for a product. Is also used to test if a date exists for that
			product in that column in a certain table.
		*/
		public function getDate($tableName, $columnName, $barcode, $issue)
		{
			$sql = "Select $columnName From $tableName
					WHERE barcode = $barcode AND issue = $issue";
			$output = '';
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return $result;
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$output =  $row[$columnName];
				}	
				$this->freeResult($result);
				return $output;
			}
		}

		/*
			This is a method to delete a record using just the barcode and issue number of the record. If this is used to delete a 
			record from the products table, all records in the other tables associated with that record will also be deleted.
			However if used to delete a record from Stock, just that record is deleted.
			But, if used with the deliveries and returns tables. It will delete all the records with that barcode and issue, which
			would be bad considering those will have duplicates of the barcode and issue but just different dates.
		*/
		public function deleteRecord($tableName, $barcode, $issue)
		{
			$sql = '';
			if(($tableName == 'Products') && (empty($issue)))
			{
				$sql = "DELETE FROM $tableName
					WHERE barcode = $barcode";
			}
			else
			{
				$sql = "DELETE FROM $tableName
					WHERE barcode = $barcode AND issue = $issue";
			}
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to delete a specific record from the deliveries, returns tables. It uses a date along with the
			barcode and issue number to target a specific record in the database table and delete it.
		*/
		public function deleteRecordDate($tableName, $barcode, $issue, $date, $originalDate)
		{
			$sql = '';
		
				$sql = "DELETE FROM $tableName
					WHERE barcode = $barcode AND issue = $issue AND $date = '$originalDate'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to change a barcode in the Products table.
		*/
		public function changeProductBarcode($tableName, $barcode, $barcodeChange)
		{
			$sql = "UPDATE $tableName SET barcode = $barcodeChange
					WHERE barcode = $barcode";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to alter a specific value of a product, decided by the column name using a barcode.
		*/
		public function changeProductValue( $column, $barcode, $info)
		{
			$sql = "UPDATE Products SET $column = '$info'
					WHERE barcode = '$barcode'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to get a value from the Products table, depending on the column given and a barcode.
		*/
		public function getProductValue( $column, $barcode)
		{
			$sql = "SELECT $column FROM Products
					WHERE barcode = $barcode";
			$output = '';
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$output =  $row[$column];
				}
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to add a user to the users table.
		*/
		public function addUser($first, $last, $user, $pass, $level)
		{
			$sql = "INSERT INTO Users (first_name, last_name, username, password, level) 
			VALUES ('$first', '$last' , '$user' , '$pass', '$level')";
			$result = mysqli_query($this->getLink(), $sql);
			return $result;
		}
		
		/*
			This is a method to display all the information from the users table into a nice table displayed to the user.
		*/
		public function allUsersShow()
		{
			$sql = "SELECT * FROM Users ORDER BY Users.last_name, Users.first_name ASC";
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['first_name'] . '</td>' . PHP_EOL .
								'<td>' . $row['last_name'] . '</td>' . PHP_EOL .
								'<td>' . $row['username'] . '</td>' . PHP_EOL .
								'<td>' . getFourDigits($row['password']) . '</td>' . PHP_EOL .
								'<td>' . $row['level'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
								
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to change a value in the users table, depending on the username that has been given along with the 
			name of the column the value they wish to change is in.
		*/
		public function changeUserValue( $column, $username, $info)
		{
			$sql = "UPDATE Users SET $column = '$info'
					WHERE username = '$username'";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to retrieve a value from the users table, depending on the column of the table and a username of the
			record they wish to retrieve the information for.
		*/
		public function getUserValue( $column, $username)
		{
			$sql = "SELECT $column FROM Users
					WHERE username = $username";
			$output = '';
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$output =  $row[$column];
				}
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to delete a user from the users table, just need a have the username they wish to delete.
		*/
		public function deleteUser($username)
		{
			$sql = "DELETE FROM Users
					WHERE username = $username";
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
			This is a method to check if their already exists a record in either the Deliveries or Returns tables. Using a date
			to specify the record.
		*/
		public function checkDuplicateIssueDate($tableName, $columnName, $barcode, $issue, $date)
		{
			
			$sql = "Select $columnName FROM $tableName WHERE barcode=$barcode AND issue=$issue";
			$result = $this->getResult($sql);
			
			while($row = mysqli_fetch_assoc($result))
			{
				if($row[$columnName] == $date)
				{
					$this->freeResult($result);
					return true;
				}
			}
			$this->freeResult($result);
			return false;
		}
		
		/*
			This is a method to add a record into the deliveries table.
		*/
		public function addDeliveryToTable($barcode, $issue, $quantity, $currentDate)
		{
			$con = $this->link;
			$sql = "INSERT INTO Deliveries (barcode, issue, delivered_quantity, delivered_date)
			 VALUES ('$barcode', '$issue' , '$quantity', '$currentDate')";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method to update a record that already exists in the deliveries table.
		*/
		public function updateDeliveryTable($barcode, $issue, $quantity)
		{
			$con = $this->link;
			$sql = "UPDATE Deliveries SET delivered_quantity = delivered_quantity + '$quantity'
			 WHERE barcode = '$barcode' AND issue = '$issue'";
			$result = mysqli_query($con, $sql);
			return $result;
		}
		
		/*
			This is a method to gather the information for all the products that have stock somewhere and must now be returned.
			It checks if the return date for each product is before the current date. If it is, it gathers the information about
			those products and puts it into a table to display to the user.
		*/
		public function allReturnsEnquiry($date)
		{
			
					$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, d.delivered_quantity AS delivery_received,
					r.return_quantity AS return_sum, s.received_date,s.return_date
					FROM (SELECT barcode, title FROM Products) p
					LEFT JOIN (SELECT barcode,issue, warehouse_stock, shop1_stock,
					shop2_stock, received_date, return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE s.return_date <= '$date' AND (s.shop1_stock>0 OR s.shop2_stock>0 OR s.warehouse_stock>0)
					GROUP BY p.barcode, s.issue, p.title, s.warehouse_stock, 
					s.shop1_stock, s.shop2_stock, s.received_date, s.return_date
					ORDER BY p.title, s.issue ASC";
					
						
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				require_once 'includes/functions.php';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . $row['title'] . '</td>' . PHP_EOL .
								'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['delivery_received'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_sum'] . '</td>' . PHP_EOL .
								'<td>' . $row['received_date'] . '</td>' . PHP_EOL .
								'<td>' . $row['return_date'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
		
		/*
			This is a method to gather the information about a product to be displayed when a user enters a barcode into the
			transfer stock form.
		*/
		public function transferStockGatherInfo($barcode, $issue)
		{
			$con = $this->getLink();
			$sql = "SELECT DISTINCT s.barcode, s.issue, p.title,  
					s.warehouse_stock, s.shop1_stock, s.shop2_stock
					FROM Products p
					LEFT OUTER JOIN Stock s
					ON p.barcode=s.barcode
					WHERE s.barcode='$barcode' AND s.issue='$issue'
					ORDER BY p.title, s.issue ASC";
			
			$result = mysqli_query($con, $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				$output = '';
				while($row = mysqli_fetch_assoc($result))
				{
					$output .= '<tr>' . PHP_EOL .
								'<td>' . $row['barcode'] . '</td>' . PHP_EOL .
								'<td>' . displayIssue($row['issue']) . '</td>' . PHP_EOL .
								'<td>' . htmlentities($row['title']) . '</td>' . PHP_EOL .
								'<td>' . $row['warehouse_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop1_stock'] . '</td>' . PHP_EOL .
								'<td>' . $row['shop2_stock'] . '</td>' . PHP_EOL .
								'</tr>' . PHP_EOL;
				}	
				$this->freeResult($result);
				return $output;
			}
		}
	
		/*
			This is a method to get all the information about the products that have returned the same amount that was delivered,
			so if a product had 40 stock delivered, and then all 40 was returned. It will gather the information about that product
			and show it to the user.
		*/
		public function gatherAllReturnsReceived()
		{
			$sql = "SELECT DISTINCT p.barcode, s.issue, p.title, s.warehouse_stock,
					s.shop1_stock, s.shop2_stock, s.return_date,
					d.delivered_quantity AS delivered_quant,
					r.return_quantity AS return_sum
					FROM (SELECT barcode, title FROM Products) p
					LEFT JOIN (SELECT barcode,issue,warehouse_stock, shop1_stock,
					shop2_stock,return_date FROM Stock) s ON (p.barcode = s.barcode)
					Left JOIN (SELECT barcode, issue, SUM(return_quantity) return_quantity
					FROM`Returns` GROUP BY barcode,issue) r ON (s.barcode=r.barcode) AND (s.issue= r.issue)
					Left JOIN (SELECT barcode, issue, SUM(delivered_quantity) delivered_quantity FROM
					Deliveries GROUP BY barcode, issue) d ON (s.barcode=d.barcode) AND (s.issue= d.issue)
					WHERE return_quantity=delivered_quantity
					GROUP BY p.barcode, s.issue, p.title, s.warehouse_stock, s.shop1_stock,
					s.shop2_stock,s.return_date";
					
			$result = mysqli_query($this->link, $sql);
			if($result == false)
			{
				$this->freeResult($result);
				return false;
			}
			else
			{
				return $result;
			}
		}
		
		/*
			This is a method to delete all the records from Stock, Delivers, Returns tables. That have had all their stock received,
			returned. So every product that has returned all of the stock that was received, it will delete.
		*/
		public function deleteAllReturnsReceived($barcode, $issue)
		{
				$sql = "DELETE s,r,d
			FROM Stock AS s
			JOIN `Returns` AS r
			  ON r.barcode = s.barcode AND r.issue = s.issue
			JOIN Deliveries AS d
			  ON d.barcode = s.barcode AND d.issue = s.issue
			WHERE
			  s.barcode='$barcode' AND s.issue='$issue'";
			
			
			$result = mysqli_query($this->getLink(), $sql);
			if($result == false)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
	}
?>