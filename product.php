<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function cleartext($text){
    return trim(strip_tags(str_replace("'", "", $text)));
}


function sendemail($toemail, $mailsubject, $body){

    $from = "piyush@vcomedicure.com";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: {$from}\r\n";
    $headers .= "Bcc: piyush@vcomedicure.com\r\n";
    $result = mail($toemail, $mailsubject, $body, $headers);

   // var_dump($result);
  //  exit;
    header("location: index.html?order=1");
    exit;

}
if(isset($_POST['submit'])){

    $product = cleartext($_POST['Role'] ?? '');
    $amount  = cleartext($_POST['amount'] ?? '0');
    $qty     = cleartext($_POST['qty'] ?? '1');

    // Product form name field
    $name    = cleartext($_POST['productname'] ?? '');

    $phone   = cleartext($_POST['phone'] ?? '');
    $email   = cleartext($_POST['email'] ?? '');
    $address = cleartext($_POST['address'] ?? '');
    $city    = cleartext($_POST['city'] ?? '');
    $state   = cleartext($_POST['state'] ?? '');
    $pin     = cleartext($_POST['pin'] ?? '');
    $message = cleartext($_POST['message'] ?? '');

    $coupon  = cleartext($_POST['coupan_name'] ?? '');

    // Remove ₹ and commas
    $amount = str_replace(array('₹', ','), '', $amount);

    $base = (float)$amount * (int)$qty;

    // GST 18%
    $gst = $base * 0.18;
    $total = $base + $gst;

    $body = "
    <html>
    <body>

    <h2>Product Order</h2>

    <table border='1' cellpadding='8' cellspacing='0' width='100%'>
        <tr>
            <td><b>Product</b></td>
            <td>{$product}</td>
        </tr>

        <tr>
            <td><b>Amount</b></td>
            <td>₹" . number_format($amount,2) . "</td>
        </tr>

        <tr>
            <td><b>Quantity</b></td>
            <td>{$qty}</td>
        </tr>
       
        <tr>
            <td><b>Coupon Code</b></td>
            <td>{$coupon}</td>
        </tr>
    
        <tr>
            <td><b>Name</b></td>
            <td>{$name}</td>
        </tr>

        <tr>
            <td><b>Phone</b></td>
            <td>{$phone}</td>
        </tr>

        <tr>
            <td><b>Email</b></td>
            <td>{$email}</td>
        </tr>

        <tr>
            <td><b>Address</b></td>
            <td>{$address}</td>
        </tr>

        <tr>
            <td><b>City</b></td>
            <td>{$city}</td>
        </tr>

        <tr>
            <td><b>State</b></td>
            <td>{$state}</td>
        </tr>

        <tr>
            <td><b>Pin Code</b></td>
            <td>{$pin}</td>
        </tr>

        <tr>
            <td><b>Message</b></td>
            <td>{$message}</td>
        </tr>
        <tr>
            <td><b>Total Payable Amount</b></td>
            <td>₹" . number_format($base,2) . "</td>
        </tr>
 

    </table>

    </body>
    </html>
    ";

    $mailSent = sendemail(
        "sales@vcomedicure.com",
        "Product Order - Vaastucon",
        $body
    );

    if($mailSent){
        header("Location: index.html?success=1");
        exit;
    } else {
        echo "Mail sending failed.";
    }
}
?>