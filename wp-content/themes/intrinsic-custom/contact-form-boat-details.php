<?php

$submitted = $_POST['result'];
$desired = $_POST['check7'];
$critical = $_POST['criticalinfo'];

if (!empty($critical) && !($critical == "")) {
$gotomail = "DeadendEmail";

	} else {

$gotomail = "5576-Website@bwleadmanager.com, jackie@intrinsicyacht.com, chris@intrinsicyacht.com";

}

if ($submitted==$desired) {

//Include configuration parameters
require("setup/config.php");

$title = $_POST['title'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$comments = $_POST['comments'];
$url = $_POST['reference'];
$error_msg = "";
$msg = "";

$msg .= "This is a message submitted from the Boat Details Contact Form on Intrinsic Yacht & Ship \n\n";

$msg .= "--------------------------------------------------------------------------------\n\n";

$msg .= "Customer Information\n\n";

$msg .= "--------------------------------------------------------------------------------\n\n";

if($name){
	$msg .= "Name: \t $name \n";
}

if($phone){
	$msg .= "Phone: \t $phone \n";
}

if(!$email){
	$error_msg .= "Your email \n";
}
if($email){
	if(!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}/", $email)){
		echo "\n<br>That is not a valid email address.  Please <a href=\"javascript:history.back()\">return</a> to the previous page and try again.\n<br>";
		exit;
	}			
	$msg .= "Email: \t $email \n";
}

if($subject){
	$msg .= "Subject: \t $subject \n";
}

if($comments){
	$msg .= "Comments: \t $comments \n";
}

$newurl.="&sent=yes";

$sender_email="";

if(!isset($name)){
	if($name == ""){
		$sender_name="";
	}
} else {
	$sender_name="Web Customer";
}
if(!isset($email)){
	if($email == ""){
		$sender_email="cwteam@yachtworld.com";
	}
} else {
	$sender_email=$email;
}
if($error_msg != ""){
	echo "You didn't fill in these required fields:<br>"
	.nl2br($error_msg) .'<br>Please <a href="javascript:history.back()">return</a> to the previous page and try again.';
	exit;
}
$mailheaders  = "MIME-Version: 1.0\r\n";
$mailheaders .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$mailheaders .= "From: $sender_name <$sender_email>\r\n";
$mailheaders .= "Reply-To: $sender_email <$sender_email>\r\n"; 
mail("$gotomail", $subject, stripslashes($msg), $mailheaders);
//header("Location: $url"); 
 ?>
<script>
  var myvar = <?php echo json_encode($url.$newurl); ?>;
	window.location = myvar;
</script>

 <?php
} else {
// Alerts that the problem was not answered correctly.
	echo "<script type=\"text/javascript\">window.alert('You did not solve the problem correctly.');window.history.back();</script>";
}
?>