<?php
//includes confirmation.php where variables are set for this template
include_once "confirmation.php";
//returns string that contains confiramtion html
return"
	<h1>Order Confirmation</h1>
	<p>Customer name: $name</p>
	<p>Phone number: $phone</p>
	<p>Pesel: $pesel</p>
	<p>$error</p>
	<p>Discount: $discount</p>
	<h2>Pizza details:</h2>
	<p>Size: $size</p>
	<h3>Toppings</h3>
	<ul>
		$anchovies
		$pineapple
		$kielbasa
		$olives
		$onion
		$peppers
	</ul>
	<label>Pizza price: €$price</label>
	$price_d
	<form name='confirmation-form' method='post' action='order.php?page=order'>
	<input type='submit' name='back' value='Go Back'/>
	<input type='submit' name='confirm' value='Place an Order'/>
	</form>
";