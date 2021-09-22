<?php
//global variables with database details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
if (!isset($conn))
	$conn = mysqli_connect($servername, $username, $password);
	mysqli_query($conn,"CREATE DATABASE $dbname");
	$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



//sql querry for creating customer table
$customer = "
CREATE TABLE $dbname.customer(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL,
phone VARCHAR(15) NOT NULL,
pizza_no INT(6) NOT NULL,
discount INT(2)
);";

//sql querry for creating pizza table
$pizza_t="
CREATE TABLE $dbname.pizza(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
size ENUM('Small', 'Medium', 'Large'),
anchovies BOOLEAN,
pineapple BOOLEAN,
kielbasa BOOLEAN,
olives BOOLEAN,
onion BOOLEAN,
peppers BOOLEAN,
price FLOAT(100,2)
);";

//if customer table dont exist creates that table
if (!mysqli_query($conn,"SELECT 1 FROM $dbname.customer")){
	mysqli_query($conn,$customer);
	mysqli_query($conn,$pizza_t);
}


//function that adds customer to customer table
function addCustomer($name,$phone,$discount,$pizza_no,$conn){
	//sql query with customer details passed to the function
	$q ="INSERT INTO ". $GLOBALS['dbname'].".customer (name, phone,discount,pizza_no) VALUES ('$name','$phone',$discount,$pizza_no);";
	//if query was not succesfull shows that there was an error
	//this was used for debugging only
	if (!mysqli_query($conn,$q))
		echo "something went wrong, customer couldn't be added to database";
	//creates sql query to get last inserted id and sets it to q
	$q = "SELECT LAST_INSERT_ID();";
	//calls it
	$id=mysqli_query($conn,$q);
	//fetches the output of that query
	$row = mysqli_fetch_array($id, MYSQLI_NUM);
	// and function returns last inserted customer id
	return $row[0];
}


//fuction to add pizza to database returns its id
function addPizza($size,$price,$conn,$toppings){
	//sql query for it using parameters passed to it
	$q ="INSERT INTO ". $GLOBALS['dbname']. ".pizza (size,price, anchovies, pineapple, kielbasa, olives, onion, peppers)
	VALUES ('$size',$price,$toppings[0], $toppings[1], $toppings[2], $toppings[3], $toppings[4], $toppings[5]);";
	//executes query if it was unsuccesfull shows error
	if (!mysqli_query($conn,$q))
		echo "something went wrong, pizza couldn't be added to database";
	//sql query string to get id of last pizza to database
	$q = "SELECT LAST_INSERT_ID();";
	//executes query
	$id=mysqli_query($conn,$q);
	//saves its ouput to $row array
	$row = mysqli_fetch_array($id, MYSQLI_NUM);
	//returns its value
	return $row[0];
}

//returns order table as a string
function displayOrders($conn){
	//sets htlm to $out
	$out="<h1>Open Orders</h1><table>
	<table border = 1>
	<tr>
	<th>Customer Name</th>
	<th>Phone Number</th>
	<th>Pizza</th>
	<th>Discount</th>
	<th>Price</th>
	<th>Action</th>
	</tr>";
	//sets sql query for the rest of data that is needed for that table
	$q="
	SELECT c.name, c.phone, p.size, c.discount, p.price, c.id, p.id
	FROM ".$GLOBALS['dbname'].".customer c, ".$GLOBALS['dbname'].".pizza p
	". " WHERE c.pizza_no = p.id;";
	//stores querys output to $output
	$output= mysqli_query($conn, $q);
	//cycles throug its ouput and ads its formated info to $out variable
	while ($row = mysqli_fetch_array($output, MYSQLI_NUM))
	{
		$out.= "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td><a href='pizza-info.php?pid=".$row[6]."'>".$row[2]."</td><td>".$row[3]."</td><td>€".$row[4]."</td><td><a href='order.php?page=open_orders&id=".$row[5]."'>Close Order</a></tr>";
	}
	//closes table tag
	$out .="</table>";
	//returns $out
	return $out;
}
//deletes both customer and its pizza from database
function deleteOrder($id, $conn, $dbname){
	//sql query that finds customer and its pizza and deletes it
	$q="
	DELETE p.*, c.* FROM $dbname.pizza p, $dbname.customer c WHERE c.pizza_no = p.id AND c.id = $id;";
	//executes query
	mysqli_query($conn, $q);
}

//displays individual pizza
function displayPizza($conn,$id, $dbname){
	//sets some html for to output 
	 $output = 
	"<h2>Pizza Info</h2>
	<table border = 1>
	<tr>
	<th>Pizza Size</th>
	<th>Anchovies</th>
	<th>Pineapple<Bbth>
	<th>Kielbasa</th>
	<th>Olives</th>
	<th>Onions</th>
	<th>Peppers</th>
	</tr>";
	//sql query stirng
	$q="
	SELECT p.size, p.anchovies, p.pineapple, p.kielbasa, p.olives, p.onion, p.peppers 
	FROM $dbname.pizza p
	WHERE p.id = $id;";
	//executes query
	$out= mysqli_query($conn, $q);
	//initiates id variable
	$id=0;
	//outputs pizza data from sql to html table
	//also eahc table row gets id 1,2,3...so on
	while ($row = mysqli_fetch_array($out, MYSQLI_NUM))
	{
		$output.= "<tr id=++$id><td>".$row[0]."</td><td>".($row[1]?"yes":"no")."</td><td>".($row[2]?"yes":"no")."</td><td>".($row[3]?"yes":"no")."</td><td>".($row[4]?"yes":"no")."</td><td>".($row[5]?"yes":"no")."</td><td>".($row[6]?"yes":"no")."</td></tr>";
	}
	//closes talbe tag
	$output.= "</table>";
	//returns $output
	return $output;
}
//this is very specific funtion to accomodate ' in a name
// and if ' is found places \ before it
//this way name is entered correctly into database
function prepString($s){
	//initiates output
	$output ="";
	//cycles through each char in $s
	for($c = 0; $c < strlen($s); $c++){
		//if ' is found, escapes it and adds it to output
		if ($s[$c]=="'")
			$output.="\'";
		else
		//otherwise just adds it to the output
			$output.= $s[$c];
	}
	//returns output
	return $output;
}

?>