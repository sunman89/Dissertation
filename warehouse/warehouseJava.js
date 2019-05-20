// JavaScript Document

// Functions for getting and sending a message to the popup div =
// $popUp = '<div class="popup"><span class="popuptext" id="popUp"></span></div>';
// div containing popup messages = gotten from www.w3schools.com/howto/howto_js_popup.asp
// $popUp = '<div id="popBox" class="popup"><span class="popuptext" id="popUp"></span></div>' . PHP_EOL;
	function displayPopUp(message)
	{
		var text = message;
		document.getElementById("popUp").innerHTML = message;
		document.getElementById("popBox").style.display = "block";
	}
	
	function closePopup()
	{
		document.getElementById("popBox").style.display = "none";
		document.getElementById("popUp").innerHTML = "";
	}
	

// For log form
	function helpLogUser()
	{
		var message = "Please enter a username.<br/>Username should be 4 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpLogPass()
	{
		var message = "Please enter a password.<br/>Password should be 4 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Add Product
	function helpAddProductBarcode()
	{
		var message = "Please enter a barcode.<br/>Barcode should be 13 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddProductTitle()
	{
		var message = "Please enter a title.<br/>Title can be a mixture of numbers and text <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddProductPrice()
	{
		var message = "Please enter a price.<br/>Price should be all numbers, positive and in format 0.00<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Deliveries page
	function helpDeliveryBarcode()
	{
		var message = "Please enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpDeliveryQuantity()
	{
		var message = "Please enter a quantity.<br/>Must be numeric and positive<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Returns page
	function helpReturnsBarcode()
	{
		var message = "Please enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
		function helpReturnsLocation()
	{
		var message = "Please select a location.<br/>Location from which you are returning a product, from: Warehouse,Shop1,Shop2  <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
		function helpReturnsQuantity()
	{
		var message = "Please enter a quantity.<br/>Must be numeric and positive<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Title Check page
	function helpCheckBarcode()
	{
		var message = "Please enter a barcode.<br/>Barcode can be either 13 or 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpCheckTitle()
	{
		var message = "Please enter a title or part of a title.<br/>Title can be a mixture of numbers and text <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpCheckPrice()
	{
		var message = "Please enter a price.<br/>Price should be all numbers, positive and in format 0.00<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Enquiries Page
	function helpEnquiryDeliveryDates()
	{
		var message = "Please enter a Delivery start date and a Delivery end date.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpEnquiryReturnsDates()
	{
		var message = "Please enter a Returns start date and a Returns end date.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Transfer Products page
	function helpTransferBarcode()
	{
		var message = "Please enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
		function helpTransferLocation()
	{
		var message = "Please select a location.<br/>Location where you are transferring stock from the Warehouse to either Shop1 or Shop2  <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
		function helpTransferQuantity()
	{
		var message = "Please enter a quantity.<br/>Must be numeric and positive and must not exceed quantity of stock in the Warehouse for that product<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For Modify Page
	// For Modify Stock in Shops form
	function helpModifyStockBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockLocation()
	{
		var message = "Must select a location.<br/>Location where the product is located, either Shop1 or Shop2  <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockQuantityChange()
	{
		var message = "Must enter a quantity.<br/>Must be numeric, can be negative or positive. A postive number is added whereas a negative number is taken away from the quantity of the stock for that product in the location selected<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// For Modify Returns form
	function helpModifyReturnsBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyReturnsOrigDate()
	{
		var message = "Must enter the date of the product.<br/>This is the date that the product was added to the returns table. Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyReturnsBarcodeChange()
	{
		var message = "Please enter a barcode that you wish to change the products barcode into.<br/>Barcode should be 15 digits long, all numbers, first 13 digits must be same as original barcode, to be same product.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyReturnsQuantityChange()
	{
		var message = "Please enter a quantity.<br/>Must be numeric, can be negative or positive. A postive number is added whereas a negative number is taken away from the quantity of the returns for that product<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyReturnsDateChange()
	{
		var message = "Please enter a date to change to.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// For Modify Delivery form
	function helpModifyDeliveryBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeliveryOrigDate()
	{
		var message = "Must enter the date of the product.<br/>This is the date that the product was added to the delivery table. Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeliveryBarcodeChange()
	{
		var message = "Please enter a barcode that you wish to change the products barcode into.<br/>Barcode should be 15 digits long, all numbers, first 13 digits must be same as original barcode, to be same product.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeliveryQuantityChange()
	{
		var message = "Please enter a quantity.<br/>Must be numeric, can be negative or positive. A postive number is added whereas a negative number is taken away from the quantity of the delivery for that product<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeliveryReceivedDateChange()
	{
		var message = "Please enter a date to change to.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// For Modify Stock Full form
	function helpModifyStockFullBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockFullBarcodeChange()
	{
		var message = "Please enter a barcode that you wish to change the products barcode into.<br/>Barcode should be 15 digits long, all numbers, first 13 digits must be same as original barcode, to be same product.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockFullQuantityChange()
	{
		var message = "Please enter a quantity.<br/>Must be numeric, can be negative or positive. A postive number is added whereas a negative number is taken away from the quantity of the warehouse stock for that product<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockFullReceivedDateChange()
	{
		var message = "Please enter a date to change the first delivery received date into.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyStockFullReturnsDateChange()
	{
		var message = "Please enter a date to change the products return date into.<br/>Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// For Delete Record form
	function helpModifyDeleteBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 15 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeleteOrigDate()
	{
		var message = "Must enter the date of the product if deleting a record from Returns or Deliveries table.<br/>This is the date that the product was added to the delivery/returns table. Must be in date format YYYY-MM-DD, eg = 2017-04-10.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeleteLocation()
	{
		var message = "Must select table location of the record.<br/>Location where the product/record is located, from: Stock, Returns, Deliveries.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyDeleteCheck()
	{
		var message = "Must check this box to confirm you want to delete this record<br/>If left unchecked, the record will not be deleted.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
// For admin tools page
	// Modify Product form
	function helpModifyProductsBarcode()
	{
		var message = "Must enter a barcode.<br/>This barcode should be 13 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyProductsBarcodeChange()
	{
		var message = "Please enter a barcode that you wish to change the products barcode into.<br/>Barcode should be 13 digits long, all numbers<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyProductsTitleChange()
	{
		var message = "Please enter a title to change product title into.<br/>Title can be a mixture of numbers and text <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyProductsPriceChange()
	{
		var message = "Please enter a price to change product price into.<br/>Price should be all numbers, positive and in format 0.00<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// For Delete Product form
	function helpProductsDeleteBarcode()
	{
		var message = "Must enter a barcode.<br/>Barcode should be 13 digits long, all numbers <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpProductsDeleteCheck()
	{
		var message = "Must check this box to confirm you want to delete this record<br/>If left unchecked, the record will not be deleted.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// Add user form
	function helpAddUserFirst()
	{
		var message = "Must enter a first name<br/>This should be text<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddUserLast()
	{
		var message = "Must enter a last  name<br/>This should be text <br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddUserName()
	{
		var message = "Must enter a username<br/>Username should be 4 digits long, all numbers. Positive number.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddUserPass()
	{
		var message = "Must enter a password.<br/>Password should be 4 digits long, all numbers. Positive number.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpAddUserLevel()
	{
		var message = "Must enter a user level for this user<br/>Must be either: 1,2,3. 1 is admin, 2 is supervisor, 3 is general staff<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// Modify User form
	function helpModifyUserName()
	{
		var message = "Must enter a valid username.<br/>Username should be 4 digits long, all numbers. Positive number.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyUserFirst()
	{
		var message = "Please enter a first name to change to.<br/>Should be all text. Will change the users first name, for the user with the username selected<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyUserLast()
	{
		var message = "Please enter a last name to change to.<br/>Should be all text. Will change the users last name, for the user with the username selected<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyUserNameChange()
	{
		var message = "Please enter a username to change to.<br/>Should be 4 digits long, all numbers. Positive number. Will change the users username to the one entered here<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyUserPass()
	{
		var message = "Please enter a password to change to.<br/>Should be 4 digits long, all numbers. Positive number.  Will change the users password, for the user with the username selected<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpModifyUserLevel()
	{
		var message = "Please enter a user level to change to.<br/>Should be either: 1,2,3. Will change the users level, for the user with the username selected<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	
	// Delete User form
	function helpUserDeleteUsername()
	{
		var message = "Must enter a username<br/>Should be 4 digits long, all numbers. Positive number.This is needed to select the appropriate user.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}
	function helpUserDeleteCheck()
	{
		var message = "Must check this box to confirm you want to delete this record<br/>If left unchecked, the record will not be deleted.<br/><br/><br/><a href='#' onclick='closePopup()'>Close</a>";
		displayPopUp(message);
	}

// Help functions

// For exit the app, does not work on firefox after latest firefox update
	function closeWin() 
	{
		window.close();
	}
	
// Check inputs from user
	// For loginForm.php
	function JSvalidateLogUser()
	{
		var logUser = document.getElementById("user").value;
		var logRegExp = "^([0-9]{4})$";
		document.getElementById("logFormUserError").innerHTML = "";
		if((logUser.length != 4) || (logUser == "") || (logUser == " ") || (!logUser.match(logRegExp)))
		{
			document.getElementById("logFormUserError").innerHTML = "You have to enter a valid username";
		}
		else
		{
			document.getElementById("logFormUserError").innerHTML = "";
		}
	}
	function JSvalidateLogPass()
	{
		var logPass = document.getElementById("pass").value;
		var passRegExp = "^([0-9]{4})$";
		document.getElementById("logFormPassError").innerHTML = "";
		if((logPass.length != 4) || (logPass == "") || (logPass == " ") || (!logPass.match(passRegExp)))
		{
			document.getElementById("logFormPassError").innerHTML = "You have to enter a valid password";
		}
		else
		{
			document.getElementById("logFormPassError").innerHTML = "";
		}
	}
	
	// For addProduct.php
	function JSvalidateAddProductBar()
	{
		var formBar = document.getElementById("productBar").value;
		var barRegExp = "^([0-9]{13})$";
		document.getElementById("addProductFormBarError").innerHTML = "";
		if((formBar.length != 13) || (formBar == "") || (formBar == " ") || (!formBar.match(barRegExp)))
		{
			document.getElementById("addProductFormBarError").innerHTML = "You have to enter a valid barcode, 13 digits, numeric";
		}
		else
		{
			document.getElementById("addProductFormBarError").innerHTML = "";
		}
	}
	function JSvalidateAddProductTitle()
	{
		var formTitle = document.getElementById("productTitle").value;
		document.getElementById("addProductFormTitleError").innerHTML = "";
		if((formTitle.length <= 0) || (formTitle == "") || (formTitle == " "))
		{
			document.getElementById("addProductFormTitleError").innerHTML = "You have to enter a valid title";
		}
		else
		{
			document.getElementById("addProductFormTitleError").innerHTML = "";
		}
	}
	function JSvalidateAddProductPrice()
	{
		var formPrice = document.getElementById("productPrice").value;
		document.getElementById("addProductFormPriceError").innerHTML = "";
		if((formPrice.length <= 0) || (formPrice == "") || (formPrice == " "))
		{
			document.getElementById("addProductFormPriceError").innerHTML = "You have to enter a valid price, format 0.00";
		}
		else
		{
			document.getElementById("addProductFormPriceError").innerHTML = "";
		}
	}
	
	// For deliveries.php
	function JSvalidateDeliveryBar()
	{
		var formBar = document.getElementById("deliveryBar").value;
		var barRegExp = "^([0-9]{15})$";
		document.getElementById("deliveryFormBarError").innerHTML = "";
		if((formBar.length != 15) || (formBar == "") || (formBar == " ") || (!formBar.match(barRegExp)))
		{
			document.getElementById("deliveryFormBarError").innerHTML = "You have to enter a valid barcode, 15 digits, numeric";
		}
		else
		{
			document.getElementById("deliveryFormBarError").innerHTML = "";
		}
	}
	function JSvalidateDeliveryQuantity()
	{
		var formValue = document.getElementById("deliveryQuantity").value;
		var valueRegExp = "^([0-9])+$";
		document.getElementById("deliveryFormQuantityError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp)) ||(formValue == 0))
		{
			document.getElementById("deliveryFormQuantityError").innerHTML = "You have to enter a valid quantity, numeric";
		}
		else
		{
			document.getElementById("deliveryFormQuantityError").innerHTML = "";
		}
	}
	
	// For returns.php
	function JSvalidateReturnsBar()
	{
		var formValue = document.getElementById("returnsBar").value;
		var valueRegExp = "^([0-9]{15})$";
		document.getElementById("returnsFormBarError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp)))
		{
			document.getElementById("returnsFormBarError").innerHTML = "You have to enter a valid barcode, 15 digits, numeric";
		}
		else
		{
			document.getElementById("returnsFormBarError").innerHTML = "";
		}
	}
	function JSvalidateReturnsQuantity()
	{
		var formValue = document.getElementById("returnedQuantity").value;
		var valueRegExp = "^([0-9])+$";
		document.getElementById("returnsFormQuantityError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp))||(formValue == 0))
		{
			document.getElementById("returnsFormQuantityError").innerHTML = "You have to enter a valid quantity, numeric";
		}
		else
		{
			document.getElementById("returnsFormQuantityError").innerHTML = "";
		}
	}
	
	// For titleCheck.php
	function JSvalidateTitleCheckBar()
	{
		var formValue = document.getElementById("checkBar").value;
		var valueRegExp = "^([0-9]{13,15})$";
		document.getElementById("titleCheckFormBarError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp)) 
		|| (formValue.length == 14))
		{
			document.getElementById("titleCheckFormBarError").innerHTML = "You have to enter a valid barcode, 13 or 15 digits, numeric";
		}
		else
		{
			document.getElementById("titleCheckFormBarError").innerHTML = "";
		}
	}
	function JSvalidateTitleCheckTitle()
	{
		var formValue = document.getElementById("checkTitle").value;
		document.getElementById("titleCheckFormTitleError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " "))
		{
			document.getElementById("titleCheckFormTitleError").innerHTML = "You have to enter a valid title or part of a title";
		}
		else
		{
			document.getElementById("titleCheckFormTitleError").innerHTML = "";
		}
	}
	function JSvalidateTitleCheckPrice()
	{
		var formPrice = document.getElementById("checkPrice").value;
		document.getElementById("titleCheckFormPriceError").innerHTML = "";
		if((formPrice.length <= 0) || (formPrice == "") || (formPrice == " "))
		{
			document.getElementById("titleCheckFormPriceError").innerHTML = "You have to enter a valid price, format 0.00";
		}
		else
		{
			document.getElementById("titleCheckFormPriceError").innerHTML = "";
		}
	}
	
	// For titleCheck.php
	function JSvalidateEnquiriesDeliveryStart()
	{
		var formValue = document.getElementById("deliveryStartDate").value;
		document.getElementById("enquiriesDeliveryFormStartError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " "))
		{
			document.getElementById("enquiriesDeliveryFormStartError").innerHTML = "You have to enter a valid date, in format YYYY-MM-DD";
		}
		else
		{
			document.getElementById("enquiriesDeliveryFormStartError").innerHTML = "";
		}
	}
	function JSvalidateEnquiriesDeliveryEnd()
	{
		var formValue = document.getElementById("deliveryEndDate").value;
		document.getElementById("enquiriesDeliveryFormEndError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " "))
		{
			document.getElementById("enquiriesDeliveryFormEndError").innerHTML = "You have to enter a valid date, in format YYYY-MM-DD";
		}
		else
		{
			document.getElementById("enquiriesDeliveryFormEndError").innerHTML = "";
		}
	}
	function JSvalidateEnquiriesReturnStart()
	{
		var formValue = document.getElementById("returnStartDate").value;
		document.getElementById("enquiriesReturnFormStartError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " "))
		{
			document.getElementById("enquiriesReturnFormStartError").innerHTML = "You have to enter a valid date, in format YYYY-MM-DD";
		}
		else
		{
			document.getElementById("enquiriesReturnFormStartError").innerHTML = "";
		}
	}
	function JSvalidateEnquiriesReturnEnd()
	{
		var formValue = document.getElementById("returnEndDate").value;
		document.getElementById("enquiriesReturnFormEndError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " "))
		{
			document.getElementById("enquiriesReturnFormEndError").innerHTML = "You have to enter a valid date, in format YYYY-MM-DD";
		}
		else
		{
			document.getElementById("enquiriesReturnFormEndError").innerHTML = "";
		}
	}
	
	// For transfer.php
	function JSvalidateTransferBar()
	{
		var formValue = document.getElementById("transferBar").value;
		var valueRegExp = "^([0-9]{15})$";
		document.getElementById("transferFormBarError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp)))
		{
			document.getElementById("transferFormBarError").innerHTML = "You have to enter a valid barcode, 15 digits, numeric";
		}
		else
		{
			document.getElementById("transferFormBarError").innerHTML = "";
		}
	}
	function JSvalidateTransferQuantity()
	{
		var formValue = document.getElementById("transferQuantity").value;
		var valueRegExp = "^([0-9])+$";
		document.getElementById("transferFormQuantityError").innerHTML = "";
		if((formValue.length <= 0) || (formValue == "") || (formValue == " ") || (!formValue.match(valueRegExp))||(formValue == 0))
		{
			document.getElementById("transferFormQuantityError").innerHTML = "You have to enter a valid quantity, numeric";
		}
		else
		{
			document.getElementById("transferFormQuantityError").innerHTML = "";
		}
	}
	
// Making parts visible/hidden
	// Show the selected modify form
	function showModify()
	{
		var form = document.getElementById("modifySelect").value;
		if(form == "shopStock")
		{
			hideAllModify()
			document.getElementById("stockShopForm").style.display = "block";
		}
		else if(form == "returns")
		{
			hideAllModify()
			document.getElementById("returnsForm").style.display = "block";
		}
		else if(form == "delivery")
		{
			hideAllModify()
			document.getElementById("deliveryForm").style.display = "block";
		}
		else if(form == "stock")
		{
			hideAllModify()
			document.getElementById("stockFullForm").style.display = "block";
		}
		else if(form == "delete")
		{
			hideAllModify()
			document.getElementById("deleteRecordForm").style.display = "block";
		}
	}
	
	// Use this function to hide all the modofy forms first, before making one visible
	function hideAllModify()
	{
		document.getElementById("stockShopForm").style.display = "none";
		document.getElementById("returnsForm").style.display = "none";
		document.getElementById("deliveryForm").style.display = "none";
		document.getElementById("stockFullForm").style.display = "none";
		document.getElementById("deleteRecordForm").style.display = "none";
	}
	
	// Show the selected admin form
	function showAdmin()
	{
		var form = document.getElementById("adminSelect").value; 
		if(form == "productModify")
		{
			hideAllAdmin()
			document.getElementById("productModifyForm").style.display = "block";
		}
		else if(form == "productDelete")
		{
			hideAllAdmin()
			document.getElementById("productDeleteForm").style.display = "block";
		}
		else if(form == "addUser")
		{
			hideAllAdmin()
			document.getElementById("addUserForm").style.display = "block";
		}
		else if(form == "modifyUser")
		{
			hideAllAdmin()
			document.getElementById("modifyUserForm").style.display = "block";
		}
		else if(form == "deleteUser")
		{
			hideAllAdmin()
			document.getElementById("deleteUserForm").style.display = "block";
		}
	}
	
	// Use this function to hide all the modofy forms first, before making one visible
	function hideAllAdmin()
	{
		document.getElementById("productModifyForm").style.display = "none";
		document.getElementById("productDeleteForm").style.display = "none";
		document.getElementById("addUserForm").style.display = "none";
		document.getElementById("modifyUserForm").style.display = "none";
		document.getElementById("deleteUserForm").style.display = "none";
		
	}
	
	
	
// Get stock data functions
	// Got this function help from https://www.w3schools.com/php/php_ajax_database.asp
	// Will gather all the stock info for the barcode that the user enters into the transfer stock barcode input on the form
	function gatherBarcodeInfo(str)
	{
		if(str == "")
		{
			document.getElementById("transferProductInformation").innerHTML = "";
			return;
		}
		else
		{
			if(window.XMLHttpRequest)
			{
				//code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{
				//code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						document.getElementById("transferProductInformation").innerHTML = this.responseText;
					}
				};
			xmlhttp.open("GET","includes/getProduct.php?barcode="+str, true);
			xmlhttp.send();
		}
	}
	
// Print functions
	// Got this function help from https://www.w3schools.com/jsref/met_win_print.asp
	// Lets the user print the page just from clicking the print button	
	function pagePrint() 
	{
    	window.print();
	}
	