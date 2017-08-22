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

$title = $_POST['title'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$starfish = $_POST['starfish'];
$comments = $_POST['comments'];
$url = $_POST['reference'];
$error_msg = "";
$msg = "";

$msg .= "This is a message submitted from the Contact form on Intrinsic Yacht & Ship \n\n";

$msg .= "--------------------------------------------------------------------------------\n\n\n";

$msg .= "Customer Information\n\n";

$msg .= "--------------------------------------------------------------------------------\n\n\n";

if($name){
	$msg .= "Name: \t $name \n";
}

if($phone){
	$msg .= "Phone: \t $phone \n";
}

if($email){		
	$msg .= "Email: \t $email \n";
}

if($email == ""){
	echo "You didn't fill in your Email<br>"
	.nl2br($error_msg) .'<br>Please <a href="javascript:history.back()">return</a> to the previous page and try again.';
	exit;
}

if($subject){
	$msg .= "Subject: \t $subject \n";
}

if($comments){
	$msg .= "Comments: \t $comments \n";
}

if (!empty($starfish) && !($starfish == "")) {
	echo "You are a rotten bot. DENIED!";
	exit ();
}



if (strpos($url,"BoatID=") == false) {

    $newurl.= "?sent=true";
}

if (strpos($url,"BoatID=") !== false) {
    $newurl.= "&sent=true";
}



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
// header("Location: $newurlfinal");
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