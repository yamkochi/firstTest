
<?php
$dbhost='localhost';
$dbuser='amith';
$dbpass='Npol#1068';
$dbname='yam1';
$name=$_POST["name"];
$mail_id=$_POST["mail_id"];
$password=$_POST["password"];
// Create connection



$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


if (isUserExists($conn, $mail_id)){
	echo json_encode(Array('isExist' => '1'));
	
}else {
	
	if(insertUser($conn,$name,$mail_id, $password)){
		echo json_encode(Array('isInserted' => '1'));
	
	}else {
		echo json_encode(Array('isInserted' => '0'));
		
	}
}




function insertUser($con,$nme,$mid,$pword){	
$sql = "Insert into usera(name,mail_id,password) values('$nme','$mid','$pword');";
if ($con->query($sql) === TRUE) {
        return TRUE;
       } else {
  //  echo "Error: " . $sql . "<br>" . $con->error;
    return FALSE;
    }
}

function isUserExists($con,$mid){
	$sql = "select * from usera where mail_id='$mid'";
	$result=$con->query($sql);
	if ($result->num_rows > 0) {
		return TRUE;
		} else {
			return FALSE;
	}
	
}

$conn->close();
?>




