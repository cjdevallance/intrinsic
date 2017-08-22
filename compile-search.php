<?php

$man = $_POST['man'];
$type = $_POST['type'];
$cond = $_POST['cond'];
$minLn = $_POST['minLn'];
$maxLn = $_POST['maxLn'];
$minPr = $_POST['minPr'];
$maxPr = $_POST['maxPr'];
$minYr = $_POST['minYr'];
$maxYr = $_POST['maxYr'];
$state = $_POST['spid'];
$hull = $_POST['hmid'];
$engines = $_POST['enid'];
$fuel = $_POST['ftid'];
$reg = $_POST['rid'];

if($_POST['source'] == "searchform"){
	$url = "manufacturer-search.php?slim=pp283659&ps=20&searched=true?";
}else{
	$url = "manufacturer-search.php?slim=pp283659&ps=20&searched=true?";
}

if($man){
	$url .= "&man=" . stripslashes($man);
}
if($type){
	$url .= "&type=" . $type;
}
if($cond){
	$url .= "&is=" . $cond;
}
if($minLn){
	$url .= "&fromLength=" . $minLn;
}
if($maxLn){
	$url .= "&toLength=" . $maxLn;
}
if($minPr){
	$url .= "&fromPrice=" . $minPr;
}
if($maxPr){
	$url .= "&toPrice=" . $maxPr;
}
if($minYr){
	$url .= "&fromYear=" . $minYr;
}
if($maxYr){
	$url .= "&toYear=" . $maxYr;
}

if($state){
	$url .= "&spid=" . $state;
}

if($reg){
	$url .= "&rid=" . $reg;
}

if($hull){
	$url .= "&hmid=" . $hull;
}
if($engines){
	$url .= "&enid=" . $engines;
}
if($fuel){
	$url .= "&ftid=" . $fuel;
}

$url .= "&lineonly";

header("Location: " . $url);

?>