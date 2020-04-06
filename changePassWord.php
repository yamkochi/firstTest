<?php
REQUIRE 'connection.php';

global $dbconn;
if ($_SERVER["REQUEST_METHOD"]=="POST"){
if (isset($_SERVER['CONTENT_TYPE'])
and stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
) {$jsonEncoded = file_get_contents('php://input');
$jsonDecoded = json_decode($jsonEncoded, true);
if (is_array($jsonDecoded)) {
foreach ($jsonDecoded as $varName => $varValue) {
$_POST[$varName] = $varValue;
}
}
}
	
	
	
$pass1=$_POST["password1"];
$pass2=$_POST["password2"];
$mailid=$_POST["mail_id"];

}


$nme=get_name($mailid,$dbconn);

changePass($pass1,$pass2,$mailid,$dbconn);

function get_name($m1,$con){
 $sql_query="select name from  users where  mail_id='$m1';";
    $result= mysqli_query($con,$sql_query);      	
     $number_of_rows=mysqli_num_rows($result);
          if ($number_of_rows>0){
           $row=mysqli_fetch_assoc($result);
           return $row['name'];
           }
           else
           {
            return "Error 5";
            }
}


function sendmail($to,$p1)
{


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: yamceg1984@gmail.com";
$subject = "YAMKOCHI  Password changed";
$msg = "Hi!".$nme." Your New password is : "."\r\n".$p1;

if(@mail($to,$subject,$msg,$headers))
  {
  return true;//mail sent
  }
else
  {
  return false; //mail problem
  }
}






	
	function changePass($p1,$p2,$m1,$conn){
		
		if ($p1==$p2){
                        $sql_query="update users set password='$p1' where mail_id='$m1';";
                        if (mysqli_query($conn,$sql_query)){

                                                   if( sendmail($m1,$p1)){
                                                    $temp_array[]=array("status"=>1,"msg"=>"Password Changed.Mail sent");
			                                        echo json_encode($temp_array);
                                                                         }
                                                                     else  
                                                                      {
                                                                       $temp_array[]=array("status"=>1,"msg"=>"Password Changed. Mail Not sent");
			                                               echo json_encode($temp_array);
                                                                       }
                                                            }
                                                    else
                                                   {
                                                    $temp_array[]=array("status"=>0,"msg"=>"Error". mysqli_error($conn));
			                            echo json_encode($temp_array);
                                                   }

			                 
			
	                      }
                          else{
                                $temp_array[]=array("status"=>0,"msg"=>"PassWords are  not unique");
			        echo json_encode($temp_array);
                              }    
               }

                      







mysqli_close($dbconn);

?>