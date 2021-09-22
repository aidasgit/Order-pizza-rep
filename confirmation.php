<?php
//checks if session started if not starts it
if (!isset($_SESSION))
	session_start();
//included lib.php for sanitize function
include_once 'lib.php';
//if something is passed from order.php
if (isset($_POST['name'])){
	//sanitizes post values
	$name = sanitize($_POST['name']);
	$phone = str_replace(' ','',sanitize($_POST['phone']));
	$pesel = str_replace(' ','',sanitize($_POST['pesel']));
	$size = $_POST['pizzaSize'];
	//stores them to session 
	$_SESSION['name'] = $name;
	$_SESSION['phone'] = $phone;
	$_SESSION['pesel'] = $pesel;
	$_SESSION['size'] = $size;
	//check if labes where set and if they where stores 1 or 0 if they where not in
	//Session array
	if(isset($_POST['addAnchovies'])){
		$anchovies = "<li>anchovies</li>";
		$_SESSION['addAnchovies'] = 1;
	}
	else{
		$anchovies = "";
		$_SESSION['addAnchovies'] = 0;
	}
	if(isset($_POST['addPineapple'])){
		$pineapple = "<li>pineapple</li>";
		$_SESSION['addPineapple'] = 1;
	}
	else{
		$pineapple = "";
		$_SESSION['addPineapple'] = 0;
	}
	if(isset($_POST['addKielbasa'])){
		$kielbasa = "<li>kielbasa</li>";
		$_SESSION['addKielbasa'] = 1;
	}
	else{
		$kielbasa = "";
		$_SESSION['addKielbasa'] = 0;
	}
	if(isset($_POST['addOlives'])){
		$olives = "<li>olives</li>";
		$_SESSION['addOlives'] = 1;
	}
	else{
		$olives = "";
		$_SESSION['addOlives'] = 0;
	}
	if(isset($_POST['addOnion'])){
		$onion = "<li>onion</li>";
		$_SESSION['addOnion'] = 1;
	}
	else{
		$onion = "";
		$_SESSION['addOnion'] = 0;
	}
	if(isset($_POST['addPeppers'])){
		$peppers = "<li>peppers</li>";
		$_SESSION['addPeppers'] = 1;
	}
	else{
		$peppers = "";
		$_SESSION['addPeppers'] = 0;
	}
	//checks if it was valid pesel and stores its output to $discount
	$discount = valid_pesel($pesel).'%';
	//if discount is 0 and pesel was set that means its wrong 
	//there for sets error msg for user to notice
	if ($_POST['pesel']!="" and $discount == 0)
		$error = "Invalid PESEL entered, go back to re-enter it...";
	else
		//otherwise error is empty
		$error = "";
	//sets discount to session discount so it could be used in order.php
	$_SESSION['discount'] = $discount;
	//creates array with pizza topings
	$toppings = array($_SESSION['addAnchovies'],$_SESSION['addPineapple'],$_SESSION['addKielbasa'],$_SESSION['addOlives'],$_SESSION['addOnion'],$_SESSION['addPeppers']);
	//calculates  price after discount if any
	$_SESSION['price']=getPizzaPrice($size, $toppings)-(((int)$discount)/100*getPizzaPrice($size, $toppings));
	//stores toppings array to session var
	$_SESSION['toppings']=$toppings;
	//calculates and sets pizzas price without discount
	$price = getPizzaPrice($size,$toppings);
	//sotres it in session
	$out = $_SESSION['price'];
	//sets $price_d if there was a discount aplied
	if((int)$discount>0)
		$price_d = "<label><br>Pizza price after discount: €$out </label><br><br>";
	else
		$price_d = "<br><br>";
	
}


//validates a pesel 
function valid_pesel($pesel){
	$sum = 0;
	//array of multipliers
	$multipliers = array(1,3,7,9);
	//if pesel dont mach reg expresion return 0
	if(!preg_match("/[0-9]{11}$/",$pesel))
		return 0;
	//bday day of the mounth is more then 31 return 0
	if(substr($pesel, 4, 2)>31)
		return 0;
	//creates valid 1st mount digit array
	$valid_mounth = array(1,4,5,6,7,8,9);
	//if 3d digit in pesel is in valid mounth 
	if (in_array(substr($pesel, 2, 1), $valid_mounth)){
		//echo (in_array(substr($pesel, 2, 1), $valid_mounth));
		//if 3d digit is valid, but second is mounth digit is more
		//than 2;returns 0
		if (substr($pesel, 3,1)>2)
			return 0;
	}
	
	//sums all(but last) pesel numbers after multiplying them with 
	//values 1 3 7 9 sequentually
	for($i=0; $i < 10; $i++){
		$sum += $pesel[$i] * $multipliers[$i%4];
	}
	//adds last number to sum
	$sum += $pesel[-1];
	//if sum mod 10 is not equal 0 returns 0
	if ($sum % 10 != 0)
		return 0;
	//if pesel owner is born in 21 century return 15 for 15% discount
	if ((substr($pesel,2,1) == 2) or (substr($pesel,2,1) == 3))
		return 15;	
	//otherwise return 10 for 10% discount
	return 10;
}


//this function calculates pizza price
//takes 2 parameters size and array of toppings
function getPizzaPrice($size, $toppings){
	//sets default topping price
	$toppings_price = 1;
	//reduces it if it is small pizza
	if ($size == 'Small')
		$toppings_price = 0.5;
	//sets base price to 5
	$base = 5;
	//increases it if medium or large
	if ($size == 'Medium')
		$base = 9;
	if ($size == 'Large')
		$base = 12;
	//initiates ammount
	$ammount = 0;
	//counts how many topings are in the $topping array
	//because we only want ones that are set
	foreach ($toppings as $topping) {
		if ($topping == '1')
			$ammount++;
	}
	//takes 1 free topping from ammount multiplies by its reate + base price
	return $base + ($ammount-1)*$toppings_price;
}

