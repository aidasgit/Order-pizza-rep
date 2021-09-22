<?php
if (isset($_GET['id'])){
	deleteOrder($_GET['id'],$conn,$dbname);
}
$orders = displayOrders($conn);
return "
<div>$orders</div><br>
<form action='order.php?page=order'>
	<input type='submit' value='Go Back'/>
</form>";