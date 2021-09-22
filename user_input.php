<?php
//checks if errors where set if not sets them to empty string
//returns the rest of order.php html
if ( !isset($name_error))
	$name_error="";
if ( !isset($phone_error))
	$phone_error="";
if ( !isset($set_name))
	$set_name="";
if ( !isset($set_phone))
	$set_phone="";
if ( !isset($set_pesel))
	$set_pesel="";
return "
<label>Name
<input type='text' name='name' value='$set_name'>
$name_error</label><br><br>
<label>Phone No.
<input type='tel' name='phone' value='$set_phone'>
$phone_error<br><br>
<label>Pesel
<input type='text' name='pesel' value='$set_pesel'></label><br><br>
<input type='submit' name='user_input' value='Proceed'>
</form>
";