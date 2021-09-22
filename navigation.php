<?php
//returns navigation html string that passes _GET['page'] value accordingly
//for order.php to process it and load coresponding page.
return "
<nav>
    <a href='order.php?page=order'>Home</a>
    <a href='order.php?page=open_orders'>Open Orders</a>
</nav>
";