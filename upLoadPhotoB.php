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
	
	
	
	$mail2=$_POST["mailId2"];
        $mail3=$_POST["mailId3"];

	$name=$_POST["name2"];
	
}
$pass= RandomString();


switch(checkmailId($mail2,$mail3)){
case  1:addNewUser($mail2,$pass,$name,$dbconn); 
         break;
case  2:$temp_array[]=array("status"=>0,"msg"=>" That Mail Already Registered");
	 echo json_encode($temp_array);
	 break;
case  3:$temp_array[]=array("status"=>0,"msg"=>" Invalid mail Domain");
	 echo json_encode($temp_array);
	break;
case  4:$temp_array[]=array("status"=>0,"msg"=>" Invalid mail Id");
	 echo json_encode($temp_array);

	break;
case  5:$temp_array[]=array("status"=>0,"msg"=>"Identical Mail Id Needed");
	echo json_encode($temp_array);
	break;

default: echo " some error";
	
}


function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 5; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}


function addNewUser($m,$p,$n,$dbconn)
	{
		$query="Insert into users(name,mail_id,password) values('$n','$m','$p');";
		
		if (mysqli_query($dbconn,$query))
		{
            if(sendmail($m,$p,$n)){
		        $temp_array[]=array("status"=>1,"msg"=>"Registered...Check your Mail for Password");
			    echo json_encode($temp_array);
                        }
                else
                    {
                    $temp_array[]=array("status"=>0,"msg"=>"Mail failed...Check your Mail status");
			          echo json_encode($temp_array);
                    }
			
		}
		else 
		{
			$temp_array[]=array("status"=>0,"msg"=>"Some Error...Mail..admin ");
			echo json_encode($temp_array);
			
			
		}
	}

function sendmail($to,$pw,$nme)
{
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: anandnpol@gmail.com";
$subject = "YAMKOCHI App Password";
$msg = "Hi!".$nme." Your password is : "."\r\n".$pw;

if(@mail($to,$subject,$msg,$headers))
{
  return true;
}else{
  return false;
}


}

	
	function checkmailID($m1,$m2){
		
		if ($m1==$m2){
			
			if (mailIdOk($m1)){

                              if (checkdomain($m1)){
                                     if (isUserExists($m,$dbconn)){
                                                       return 1;//mailId ok,domainok,Mail Id Allowed 
                                                               }
                                                           else{
                                                        return 2;// Mail ID already used
                                                               }

                                                  }
                                              else{
                                           return 3;//domain not ok                                                      

                                      }
			    
			                  }
			             else {
				  return 4;//mail Id not OK
			                  }
			
		            }
		       else {
			return 5;//mail Id not Unique
		            }
	                       }


function isUserExists($m,$dbconn)
{
	
    $query="select * from users where mail_id = '$m' ";
	$result=mysqli_query($dbconn,$query);
	$number_of_rows=mysqli_num_rows($result);
	if ($number_of_rows>0){			
		return false;
		}
		else 
		{		
		return true;
	    }
}

function mailIdOk($mail)
{
	$email = filter_var($mail, FILTER_SANITIZE_EMAIL);
       // echo $email."\n";
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		return true;
	} else {
		return false;
	}
	
}
function checkdomain($email){
$mailarr=explode("@", $email); 
if (checkdnsrr($mailarr[1], "MX")) { 
    return true;
} 
else { 
  return false;

} 

}

mysqli_close($dbconn);

?>