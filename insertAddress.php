<?php
if ($_SERVER["REQUEST_METHOD"]=="POST"){
	REQUIRE 'connection.php';
	createAddress();
	
}
function createAddress()
{
	global $connect;
	$name=$_POST["name"];
	$mail_id=$_POST["mail_id"];	
	$phone_no=$_POST["phone_no"];
	$query="Insert into myaddress(name,mail_id,phone_no) values('$name','$mail_id','$phone_no');";
	mysqli_query($connect,$query) or die (mysqli_error($connect));
	mysqli_close($connect);

}

?>
