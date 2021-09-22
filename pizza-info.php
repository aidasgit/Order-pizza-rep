<?php
//inludes setup.php to get access to displayPizza function
include_once "setup.php";
//adds navigation string to content
$content = include_once "navigation.php";
//adds displayPizza function output to content
$content .= displayPizza($conn,$_GET['pid'],$dbname);
//creates form that sends post data that pizza_info is set
//so it could take it to back to open orders
$content .= "<form method= 'post' action='order.php'><br>
	<input type='submit' name='pizza_info' value='Go Back'/>

</form>";
//echos page_template do display content
echo include_once "page_template.php";