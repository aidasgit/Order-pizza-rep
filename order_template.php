<?php
//returns string with order html
//here also loads user_input.php at the end
//I broke into seperate files for testing and readability
return "
<h2 id=heading>$title</h2>
<h3>Pizza with a Polish Twist</h3>
<form  id='pizza-form' name='theform' method='post' action=$action>
    <h3>What Size of Pizza Would You Like? </h3>   
    Small
    <input id='small' type='radio' name='pizzaSize' value='Small' onChange='redraw()'/>
    Medium
    <input id='medium' type='radio' name='pizzaSize' value='Medium' onChange='redraw()' />
    Large
    <input id='large' type='radio' name='pizzaSize' value='Large' onChange='redraw()' checked/>
    <div id='pizzaImages'>
		<img id='image1' src='images/base.png' width='250' height='250'/>
		<img id='image2' src='images/anchois.png' width='250' height='250'/>
		<img id='image3' src='images/pineapple.png' width='250' height='250'/>
		<img id='image4' src='images/kielbasa.png' width='250' height='250'/>
		<img id='image5' src='images/olives.png' width='250' height='250' />
		<img id='image6' src='images/onion.png' width='250' height='250' />
		<img id='image7' src='images/pepper.png' width='250' height='250'/>
	</div>
        <br>
	    <h3>Add Extra Toppings</h3>
	    Anchovies
	    <input id='anchovies' type='checkbox' name='addAnchovies' value='yes' onChange='redraw()' checked/>
	    &nbsp; &nbsp; &nbsp; Pineapple
	    <input id='pineapple' type='checkbox' name='addPineapple' value='yes' onChange='redraw()' checked/>
	    &nbsp; &nbsp; &nbsp;Kiełbasa
        <input id='kielbasa' type='checkbox' name='addKielbasa' value='yes' onChange='redraw()' checked/>
	    &nbsp; &nbsp; &nbsp; Olives
        <input id='olives' type='checkbox' name='addOlives' value='yes' onChange='redraw()' checked/>
	    &nbsp; &nbsp; &nbsp;Onion
	    <input id='onion' type='checkbox' name='addOnion' value='yes' onChange='redraw()' checked/>  
	    &nbsp; &nbsp; &nbsp;Peppers
	    <input id='peppers' type='checkbox' name='addPeppers' value='yes' onChange='redraw()' checked/>
	   <br><br><br>
".include_once"user_input.php";