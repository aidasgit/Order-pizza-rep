<?php
//Student name: Aidas Karpavicius
//Student no: R00171054
//Starts session
if (!isset($_SESSION))
	session_start();

//Sets $title variable to be used in order_template.php
$title="🇵🇱 Poznan Pizza 🇵🇱";

//includes two libraries setup.php sets up database connection
//and imports its functions
//lib.php has sanitice function that will be used in two pages
include_once "setup.php";
include_once 'lib.php';

//sets default action and $_GET['page']=order
$action="order.php?page=order";

//checks if gets page is set to something sets $pageToLoad to its value
//otherwise default "order" is given to it
$navigationIsClicked = isset ($_GET['page']);

if ($navigationIsClicked){
	$pageToLoad = $_GET['page'];
} else{
	$pageToLoad = "order";
}

//if post pizza_info is set that means  go back	button in pizza info was clicked 
//so it sets $pageToLoad to open_orders
if (isset($_POST['pizza_info']))
	$pageToLoad = "open_orders";

//This section checks user input
//If all input is in order sets $pageToLoad to confirmation
if ( isset($_POST['name']) and $_POST['name']!="" and strlen($_POST['name']) <= 30 and preg_match("/\(?08(3|5|6|7|9)\)?[0-9]{3}-?[0-9]{4}$/",str_replace(' ', '', $_POST['phone'])))
	$pageToLoad = 'confirmation';
//if name was given $set_name keeps its value after sanitize function process it
if ( isset($_POST['name']) and $_POST['name']!="")
	$set_name = sanitize($_POST['name']);
//if pesel was given $set_pesel stores it after sanitize process it
if ( isset($_POST['pesel']) and $_POST['pesel']!="")
	$set_pesel = sanitize($_POST['pesel']);
//if no name was given and it was submited sets $name_error to error msg that will be used
//in order_template.php
if ( isset($_POST['name']) and ($_POST['name']=="" or strlen($_POST['name'])> 30))
	$name_error = "You must enter valid name, it can't be empty or longer then 30 character.";
//if phone was given but it don't match reg expresion
//sets msg to display in that case
if ( isset($_POST['phone']) and !preg_match("/\(?08(3|5|6|7|9)\)?[0-9]{3}-?[0-9]{4}$/",str_replace(' ', '', $_POST['phone'])) )
	$phone_error = "The phone number you've entered is not valid.<br>Please enter valid phone number starting with 08 and 10 digits in total.";
//if phone was given and matches reg expresion sanitizes it and stores it in $set_phone
if ( isset($_POST['phone']) and preg_match("/\(?08(3|5|6|7|9)\)?[0-9]{3}-?[0-9]{4}$/",str_replace(' ', '', $_POST['phone'])) )
	$set_phone = sanitize($_POST['phone']);

//if post has value confirm sets $pageToLoad to confirm and adds customer and its pizza to database
if (isset($_POST['confirm'])){
	$pageToLoad = "confirm";
	$output=addPizza(ucfirst($_SESSION['size']),$_SESSION['price'],$conn, $_SESSION['toppings']);
	addCustomer(prepString($_SESSION['name']), strval($_SESSION['phone']),(int)$_SESSION['discount'],$output, $conn);
}
//sets $content to all data thats in navigation.php
$content = include_once "navigation.php";
//adds to content whatever is in $pageToLoad."_template"
$content .= include_once $pageToLoad."_template.php";
//$page variable gets all output of page_template
$page = include_once "page_template.php";
//and $page is outputed for display
echo $page;
