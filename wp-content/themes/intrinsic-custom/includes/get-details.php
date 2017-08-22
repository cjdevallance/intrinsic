<?php
//This document provides functions for doing string replaces on data from the database. It may need editing for local spellings

//Get Boat ID from URL
$id = $_GET["BoatID"];

//Get Boat Details from Database
$Query = "SELECT * FROM boatdetails WHERE BoatID = $id";
$singleboat = $db->db_query($Query); 
$boat = $db->db_rs($singleboat);

//Get Engine Details from Database
$Query = "SELECT * FROM engines WHERE BoatID=$id";
$enginedata = $db->db_query($Query); 
$engine = $db->db_rs($enginedata);

//Get Video Details from Database
$Query = "SELECT * FROM videos WHERE BoatID=$id";
$videodata = $db->db_query($Query); 
$video = $db->db_rs($videodata);

//Replace incorrect YouTube URLs to ensure that they play correctly
$video['VideoURL']=str_replace("/watch?v=","/v/",$video['VideoURL']);
$video['VideoURL']=str_replace("youtu.be/","www.youtube.com/v/",$video['VideoURL']);

//Convert common currencies from codes to symbols
$boat['PriceCurrency']=str_replace("GBP",chr(163),$boat['PriceCurrency']);
$boat['PriceCurrency']=str_replace("USD",chr(36),$boat['PriceCurrency']);
$boat['PriceCurrency']=str_replace("EUR",chr(128),$boat['PriceCurrency']);
$boat['Price'] = number_format($boat['Price']);
if ($boat['TaxStatus'] == "Not Paid"){
	$boat['Price'] .= " ex Vat";
} else if ($boat['TaxStatus'] == "Paid"){
	$boat['Price'] .= " inc Vat";
}

//Correct spellings and switch American spellings to UK
$boat['HullMaterial']=str_replace("Fiberglass","GRP",$boat['HullMaterial']);
$boat['LengthUnit']=str_replace("meter","metres",$boat['LengthUnit']);	
$boat['BeamUnit']=str_replace("meter","metres",$boat['BeamUnit']);	
$boat['DisplacementUnit']=str_replace("kilogram","kilograms",$boat['DisplacementUnit']);
$boat['DisplacementUnit']=str_replace("pound","lbs",$boat['DisplacementUnit']);	
$boat['MinDraftUnit']=str_replace("meter","metres",$boat['MinDraftUnit']);
$boat['MaxDraftUnit']=str_replace("meter","metres",$boat['MaxDraftUnit']);
$boat['BallastUnit']=str_replace("kilogram","kilograms",$boat['BallastUnit']);
$boat['BallastUnit']=str_replace("pound","lbs",$boat['BallastUnit']);	
$engine['EngineFuel']=str_replace("diesel","Diesel",$engine['EngineFuel']);
$engine['EngineFuel']=str_replace("petrol","Petrol",$engine['EngineFuel']);
$boat['FuelTankCapUnit']=str_replace("gallon","gallons",$boat['FuelTankCapUnit']);
$boat['FuelTankCapUnit']=str_replace("liter","litres",$boat['FuelTankCapUnit']);	
$boat['WaterTankCapUnit']=str_replace("gallon","gallons",$boat['WaterTankCapUnit']);
$boat['WaterTankCapUnit']=str_replace("liter","litres",$boat['WaterTankCapUnit']);	
$boat['HoldingTankCapUnit']=str_replace("gallon","gallons",$boat['HoldingTankCapUnit']);
$boat['HoldingTankCapUnit']=str_replace("liter","litres",$boat['HoldingTankCapUnit']);					

//Convert measurements in feet to display correctly
if ($boat['LengthUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['Length']);
	$boat['Length'] = $result;
} else {
	$boat['Length'] .= $boat['LengthUnit'];
}
if ($boat['LWLUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['LWL']);
	$boat['LWL'] = $result;
} else {
	$boat['LWL'] .= $boat['LWLUnit'];
}
if ($boat['LOAUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['LOA']);
	$boat['LOA'] = $result;
} else {
	$boat['LOA'] .= $boat['LOAUnit'];
}
if ($boat['BeamUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['Beam']);
	$boat['Beam'] = $result;
} else {
	$boat['Beam'] .= $boat['BeamUnit'];
}
if ($boat['MinDraftUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['MinDraft']);
	$boat['MinDraft'] = $result;
} else {
	$boat['MinDraft'] .= $boat['MinDraftUnit'];
}
if ($boat['MaxDraftUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['MaxDraft']);
	$boat['MaxDraft'] = $result;
} else {
	$boat['MaxDraft'] .= $boat['MaxDraftUnit'];
}
if ($boat['BridgeClearanceUnit'] == "feet"){ 
	$result = $db->convert_feet($boat['BridgeClearance']);
	$boat['BridgeClearance'] = $result;
} else {
	$boat['BridgeClearance'] .= $boat['BridgeClearanceUnit'];
}

?>