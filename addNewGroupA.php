<?php
REQUIRE 'connection.php';

global $dbconn;
if ($_SERVER["REQUEST_METHOD"]=="POST"){
	if (isset($_SERVER['CONTENT_TYPE'])
			and stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
			) {
				$jsonEncoded = file_get_contents('php://input');
				$jsonDecoded = json_decode($jsonEncoded, true);
				if (is_array($jsonDecoded)) {
					foreach ($jsonDecoded as $varName => $varValue) {
						$_POST[$varName] = $varValue;
					}
				}
			}
	
	
	
	$user_id=$_POST["user_id"];
	$name=$_POST["name"];
	
}


if (isGroupExist($user_id,$name,$dbconn)){    //check user existing 
addNewGroup($user_id,$name,$dbconn);  // add user

}
else {
	//showUser($mail,$pass,$dbconn); //show existing user
	$temp_array[]=array("status"=>0,"msg"=>"This Group exists");
	echo json_encode($temp_array);
}



function isGroupExist($uid,$nme,$con)

{
	
    $query=("select * from usersgroups where user_id = '$uid' and name='$nme' ");

	$result=mysqli_query($con,$query);

	$number_of_rows=mysqli_num_rows($result);

	if ($number_of_rows>0){
		
		//$temp_array=array("status"=>1);
		//echo "exists";
		return false;
		}
		else {
			
		//$temp_array=array("status"=>0);
		//echo "not exists";
		return true;
	}
}
	function addNewGroup($uid,$name,$con)
	{
		$gid=getGroupid($uid);
		$query="Insert into usersgroups(user_id,group_id,name) values('$uid','$gid','$name','$p');";
		//echo $query;
		//mysqli_query($connect,$query) or die (mysqli_error($connect));
		if (mysqli_query($con,$query))
		{
			$temp_array[]=array("status"=>1,"msg"=>"New Group Added ");
			echo json_encode($temp_array);
			//return true;
			//echo"ok";
			//showUser($m, $p, $con);
		}
		else 
		{
			$temp_array[]=array("status"=>0,"msg"=>"Some Error...Mail..admin ");
			echo json_encode($temp_array);
			
			
		}
	}
	

	function getGroupid($uid){
		$query=("select * from usersgroups where user_id = '$uid' ");
		
		$result=mysqli_query($con,$query);
		
		return(mysqli_num_rows($result)+1);
		
		
		
	}

	
	mysqli_close($dbconn);



?>

