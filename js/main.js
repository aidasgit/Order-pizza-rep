//javascript for order.php
//same function as in example provided
//slightly modified to be more compact
function redraw()
{
	if (document.getElementById('small').checked==true)
	pizzaImageSize = 100;
	else if (document.getElementById('medium').checked==true)
	pizzaImageSize = 180;
	else if (document.getElementById('large').checked==true)
	pizzaImageSize = 250;

    var toppings = ["","","anchovies","pineapple","kielbasa","olives","onion","peppers"];
    for(var i = 1; i < 8; i++){
		document.getElementById("image"+i).height = pizzaImageSize;
		document.getElementById("image"+i).width = pizzaImageSize;
		if ( i > 1 )
			if (document.getElementById(toppings[i]).checked==true)
				document.getElementById("image"+i).style.visibility = "visible";
			else
				document.getElementById("image"+i).style.visibility = "hidden";
	}	
}
