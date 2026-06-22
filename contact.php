<?php
function sendemail($toemail,$mailsubject,$body){
	$headers  = 'MIME-Version: 1.0' . "\r\n";
		
		$headers .= "Bcc: piyush@vcomedicure.com\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: Vaastucon Contact Enquiry <piyush@vcomedicure.com>" . "\r\n";
		
		$mailit = mail($toemail,$mailsubject,$body,$headers);
		if($mailit){
			$msg = "success";
		}else{
			$msg = "fail";
		}
		
		return $msg;
	
}
	function cleartext($id){
		$id = trim(str_replace("'", "", $id));
		$id = strip_tags($id);
		return $id;
		
	}
if(isset($_REQUEST['submit'])){
	 $name = cleartext($_REQUEST['name']);
	$phone = cleartext($_REQUEST['phone']);
	$email = cleartext($_REQUEST['email']);
	$address = cleartext($_REQUEST['address']);
	$state = cleartext($_REQUEST['state']);
	$city = cleartext($_REQUEST['city']);
	//$town = cleartext($_REQUEST['town']);
	//$village = cleartext($_REQUEST['village']);
	$pin = cleartext($_REQUEST['pin']);
	$message = cleartext($_REQUEST['message']);
	
	
		//$strBody = "Following are form details";
		$strBody .= "<p>Name : $name</p>";
		$strBody .= "<p>Phone  : $phone</p>";
		$strBody .= "<p>Email  : $email</p>";
		$strBody .= "<p>Address : $address</p>";
		$strBody .= "<p>State : $state</p>";
		$strBody .= "<p>City/Town/Village : $city</p>";
		//$strBody .= "<p>Town : $town</p>";
		//$strBody .= "<p>Village : $village</p>";
		$strBody .= "<p>Pin : $pin</p>";
		$strBody .= "<p>Message : $message</p>";
		
		
	$mailsent = sendemail("ask@vcomedicure.com","Vaastucon Contact Enquiry",$strBody);
	 // Redirect back to HTML with success flag
    header("location: index.html?enquiry=1");
    exit;
	//header("location:thank-you.html"); exit;
	
}
?>