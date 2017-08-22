<?php

error_reporting(0);
$emailAddress = 'cherylshrk@aol.com';

require "classes/phpmailer.class.php";

//Min length validation
function validateMinLength($length, $number){
    //if it's NOT valid
    if(strlen($length) < $number)
        return false;
    //if it's valid
    else
        return true;
}
//Max length validation
function validateMaxLength($length, $number){
    //if it's NOT valid
    if(strlen($length) > $number)
        return false;
    //if it's valid
    else
        return true;
}
//Email length validation
function validateEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
//Phone length validation	
//function validatePhone($phone){
//	return preg_match("/^[0-9 -]{1,}$/", $phone);
//}

session_start();

$err = array();
//2 = Minimum Number, 21 = Maximum Number
if(!validateMinLength($_POST['name'], 2))$err[]='<p style="font-family: Fjord One, Verdana, sans-serif;">The name field is too short or empty. Please go back and fix the error.</p>';
if(!validateMaxLength($_POST['name'], 21))$err[]='<p style="font-family: Fjord One, Verdana, sans-serif;">The name field must be less than 21 characters. Please go back and fix the error.</p>';

//if(!validateMinLength($_POST['company'], 2))$err[]='PHP: The company field is too short or empty'; 	
//if(!validateMaxLength($_POST['company'], 21))$err[]='PHP: The company field is too long'; 	

//2 = Minimum Number, 254 = Maximum Number
if(!validateMinLength($_POST['email'], 2))$err[]='<p style="font-family: Fjord One, Verdana, sans-serif;">The email field is too short or empty. Please go back and fix the error.</p>';
if(!validateMaxLength($_POST['email'], 254))$err[]='<p style="font-family: Fjord One, Verdana, sans-serif;">The email field must be less than 254 characters. Please go back and fix the error.</span>';
if(validateMinLength($_POST['email'], 2) && validateMaxLength($_POST['email'], 254) && !validateEmail($_POST['email']))$err[]='<p style="font-family: Fjord One, Verdana, sans-serif;">That email address appears to be invalid. Please go back and fix the error.</p>';

//11 = Minimum Number, 23 = Maximum Number
//if(!validateMinLength($_POST['phone'], 11))$err[]='The phone number field must be at least 11 numbers';
//if(!validateMaxLength($_POST['phone'], 23))$err[]='The phone number field must be less than 22 numbers';
//if(validateMaxLength($_POST['phone'], 23) && validateMinLength($_POST['phone'], 11) && !validatePhone($_POST['phone']))$err[]='The phone number is not valid. Numbers and Hyphens (-) only';

//1 = Minimum Number
//if(!validateMinLength($_POST['message'], 1))$err[]='The message field is too short or empty';

//5 = Minimum Number, 5 = Maximum Number
//if(!validateMinLength($_POST['verify'], 5))$err[]='The security captcha field is too short or empty';
//if(!validateMaxLength($_POST['verify'], 5))$err[]='The security captcha field is too long';
//if(validateMinLength($_POST['verify'], 5) && validateMaxLength($_POST['verify'], 5) && md5($_POST['verify']) != $_SESSION['verify'])$err[]='The captcha field appears to be incorrect';

if(count($err)){
    foreach($err as $one_er){
        echo $one_er . "<br/>";
    }
    exit();
}

if (strpos($url,"BoatID=") == false) {
   $url.="../../../../../contact-us/?sent=yes";

    $newurl.="";
}

if (strpos($url,"BoatID=") !== false) {
    $newurl.= "&sent=true";
}

else
    session_destroy();

//Style how the received email will look

$msg='<b>Intrinsic Yacht and Ship Contact Form</b><br>
You have been contacted by '.$_POST['name'].'

<br>
<br>

<table style="width: 100%; font-family: Verdana, sans-serif; margin: 0; padding: 0px; border: 1px solid #9FC8FA; border-collapse: collapse; border-spacing: 0;" border="0">
<tr> 
<td colspan="2" style="height: 15px; text-align: center; text-transform: uppercase; background: #9FC8FA; color: #333333; padding: 1%;">Intrinsic Yacht and Ship Contact Form</td>
</tr>
</table><br>
<table style="width: 100%; font-family: Verdana, sans-serif; margin: 0; padding: 0px; border: 1px solid #999; border-collapse: collapse; border-spacing: 0;" border="0">
<tr>
<td style="width: 25%; padding: 10px; border-right: 1px solid #999;">Name:</td><td style="width: 75%; padding: 10px;">'.$_POST['name'].'</td>
</tr>
<tr>
<td style="padding: 10px; border-right: 1px solid #999;">Telephone:</td><td style="padding: 10px;">'.$_POST['phone'].'</td>
</tr>
<tr>
<td style="padding: 10px; border-right: 1px solid #999;">Email:</td><td style="padding: 10px;">'.$_POST['email'].'</td>
</tr>
<tr>
<td style="padding: 10px; border-right: 1px solid #999;">Subject:</td><td style="padding: 10px;">'.$_POST['subject'].'</td>
</tr>
<tr>
<td style="padding: 10px; border-right: 1px solid #999;">Message:</td><td style="padding: 10px;">'.$_POST['comments'].'</td>
</tr>
</table>

<br>

You can contact '.$_POST['name'].' via the email '.$_POST['email'].' <br>
This page URL is '.$_POST['reference'].' <br>
The recorded IP is '.$_SERVER['REMOTE_ADDR'].'';

$mail = new PHPMailer();
$mail->IsMail();
$mail->AddReplyTo($_POST['email'], $_POST['name']);
$mail->AddAddress($emailAddress);
$mail->SetFrom($_POST['email'], $_POST['name']);
$mail->Subject = "You have been contacted by ".$_POST['name']."";
$mail->MsgHTML($msg);
$mail->Send();
unset($_SESSION['post']);
header("Location: $url$newurl");
?>
