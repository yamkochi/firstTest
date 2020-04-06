<?php
REQUIRE 'connection.php';

global $dbconn;
if ($_SERVER["REQUEST_METHOD"]=="POST"){


	$pass= $_POST["password"];
	$mail=$_POST["mail_id"];
}


if (notUserExist($mail,$pass,$dbconn)){
addNewUser($mail,$pass,$dbconn);
$temp_array=array("mail_id"=>"user","password"=>"added");
header('Content-Type:application/json');
echo json_encode($temp_array);
}
else 
{
	$temp_array=array("mail_id"=>"user","password"=>"Exist");
	header('Content-Type:application/json');
	echo json_encode($temp_array);
	
}
//isUserExist($mail,$pass,$dbconn);

function notUserExist($m,$p,$con)

{
	
    $query=("select * from user where mail_id = '$m' and  password='$p'");

	$result=mysqli_query($con,$query);

	$number_of_rows=mysqli_num_rows($result);

	if ($number_of_rows>0){
		
		//$temp_array=array("status"=>1);
	//	echo "exists";
		return false;
		}
		else {
			
		//$temp_array=array("status"=>0);
	//	echo "not exists";
		return true;
	}
}
	function addNewUser($m,$p,$con)
	{
		$query="Insert into user(name,mail_id,password) values('test','$m','$p');";
		//echo $query;
		//mysqli_query($connect,$query) or die (mysqli_error($connect));
		if (mysqli_query($con,$query))
		{
			return true;
			//echo"ok";
		}
		else 
		{
			return false;
			//echo "not ok";
		}
	}
	
	
	
	//header('Content-Type:application/json');
	//echo json_encode($temp_array);
	mysqli_close($dbconn);



?>






















