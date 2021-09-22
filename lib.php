<?php
//sanitizes input 
function sanitize($s){
	//list of unwanted characters
	$unwanted = '\/<>;",:=';
	//initiates output
	$output = "";
	//cycles through $s
	for($c = 0; $c < strlen($s); $c++){
		//compares each char to each char in unwanted
		for($i = 0; $i < strlen($unwanted); $i++)
			//if match found breaks out
			if ( $s[$c] == $unwanted[$i] ){	
				break 1;
			}
			//otherwise continues
			else{
				continue 1;
			}
		//if there was no match with unwanted 
		//adds char to string, or if there was match doesnt add to it
		if($i == strlen($unwanted)){
			$output .= $s[$c];
		}
	}
	//returns string that has no unwanted chars
	return $output;
}
