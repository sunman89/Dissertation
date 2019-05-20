<?php

	// Starts the session and regenerate the id everytime the page/view changes
	session_start();
	session_regenerate_id(true);
	
	// Code for getting template and replacing placeholders
	$file = 'templates/page.html';
	$tpl = file_get_contents($file);
	
	// Code to get the header
	$heading = require ('includes/headings.php');
	
	// Code to get the content
	$content = require ('includes/contents.php');
	
	// To get the footer for each view/page
	$footer = require ('includes/footers.php');
	
	// Subject for first 'pass' is raw template plus headings
	$pass1 = str_replace('[+heading+]', $heading, $tpl);
	
	// Subject for second 'pass' is template, headings and then content
	$pass2 = str_replace('[+content+]', $content, $pass1);
	
	// $final will contain the HTML from the template file, the header, content and the footer
	$final = str_replace('[+footer+]', $footer, $pass2);
	
	// Output all the html to the screen
	echo $final;		
		
?>
