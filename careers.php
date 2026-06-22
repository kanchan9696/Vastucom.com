<?php
// function sendemail($toemail,$mailsubject,$body){
// 	$headers  = 'MIME-Version: 1.0' . "\r\n";
// 		//$headers .= "Bcc: neerajmaurya1994@gmail.com\r\n";
// 		$headers .= "Bcc: kanchanpawar7896@gmail.com\r\n";		
// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// 		$headers .= "From: Vaastucon Careers Enquiry <kanchan@codeoid.com>" . "\r\n";
		
// 		$mailit = mail($toemail,$mailsubject,$body,$headers);
// 		if($mailit){
// 			$msg = "success";
// 		}else{
// 			$msg = "fail";
// 		}
		
// 		return $msg;
	
// }

function sendemail($toemail,$mailsubject,$body){

    $from = "piyush@vcomedicure.com";

    $separator = md5(time());

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "From: Vaastucon Careers Enquiry <$from>\r\n";
    $headers .= "Bcc:piyush@vcomedicure.com\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

    // Main message
    $message = "--" . $separator . "\r\n";
    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message .= $body . "\r\n";

    // Attachment
    if(isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0){

        $fileName = $_FILES["resume"]["name"];
        $fileTmp  = $_FILES["resume"]["tmp_name"];
        $fileSize = $_FILES["resume"]["size"];

        $handle = fopen($fileTmp, "rb");
        $content = fread($handle, $fileSize);
        fclose($handle);

        $content = chunk_split(base64_encode($content));

        $message .= "--" . $separator . "\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"" . $fileName . "\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment\r\n\r\n";
        $message .= $content . "\r\n";
    }

    $message .= "--" . $separator . "--";

    $mailit = mail($toemail,$mailsubject,$message,$headers);

    if($mailit){
        return "success";
    }else{
        return "fail";
    }
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
	 // Role dropdown value
    $role = cleartext($_REQUEST['Role']);

    // If Others selected, take textbox value
    if($role == "Others" && !empty($_REQUEST['OtherRole'])){
        $role = cleartext($_REQUEST['OtherRole']);
    }
	$state = cleartext($_REQUEST['state']);
	$city = cleartext($_REQUEST['city']);
	$pin = cleartext($_REQUEST['pin']);
	//$town = cleartext($_REQUEST['town']);
	//$village = cleartext($_REQUEST['village']);
	$message = cleartext($_REQUEST['message']);
	
	$strBody = "";
	
		//$strBody = "Following are form details";
		$strBody .= "<p>Name : $name</p>";
		$strBody .= "<p>Phone  : $phone</p>";
		$strBody .= "<p>Email  : $email</p>";
		$strBody .= "<p>Role : $role</p>";	
		$strBody .= "<p>State : $state</p>";	
		$strBody .= "<p>City/Town/Village : $city</p>";
		$strBody .= "<p>Pin : $pin</p>";
		//$strBody .= "<p>Town : $town</p>";
		//$strBody .= "<p>Village : $village</p>";
		$strBody .= "<p>Message : $message</p>";		
		
		
	$mailsent = sendemail("careers@vcomedicure.com","Vaastucon Careers Enquiry",$strBody);
	 // Redirect back to HTML with success flag
    header("location: index.html?career=1");
    exit;
	//header("location:thank-you.html"); exit;
	
}
?>