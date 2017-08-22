<?php 

//Include configuration parameters
require("setup/config.php");


$lastKnownWorkingXml = $XMLpath . "lastKnownWorking.xml";
$temporaryXml = $XMLpath . "temporaryXml.xml";

rename($lastKnownWorkingXml, $temporaryXml);


$doc = new DOMDocument('1.0');
// we want a nice output
$doc->formatOutput = true; 
$doc->load($boatfeed);
	if (@$doc->load($boatfeed) === false){
		rename($temporaryXml, $lastKnownWorkingXml);
		$msg = "XML FEED from BoatWizard Failed for Site - now using the backup XML   |   to re-run the script, visit ". $fulldirectoryurl ."create-xml.php ";
		$mailheaders  = "MIME-Version: 1.0\r\n";
		$mailheaders .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$mailheaders .= "From: BWWS Aletrs <websites@yachtworld.com>\r\n";
		$mailheaders .= "Reply-To: BWWS Alerts <$errorsemail>\r\n"; 
		mail("$errorsemail","ALERT for: " . $brokername,stripslashes($msg), $mailheaders);
	} else {
		$doc->save($lastKnownWorkingXml); 
	}

//Include Database File
require("classes/db.class.php");

$i = 0;
for (; $i < 2; $i++) {
	$db = new db();

	//Clear Database
	$clear = "DELETE FROM boatdetails";
	$db->db_query($clear);

	$clear = "DELETE FROM descriptions";
	$db->db_query($clear);

	$clear = "DELETE FROM engines";
	$db->db_query($clear);

	$clear = "DELETE FROM features";
	$db->db_query($clear);

	$clear = "DELETE FROM images";
	$db->db_query($clear);

	$clear = "DELETE FROM links";
	$db->db_query($clear);
	
	$clear = "DELETE FROM videos";
	$db->db_query($clear);
	

	$result = $db->run_import($lastKnownWorkingXml);

	if ($result == 1){
		echo "Feed imported successfully<br>";
		break;
	} else {
		if ($i == 1) {
			rename($temporaryXml, $lastKnownWorkingXml);
		}
		echo "Feed import unsuccessful - using backup XML<br>";
		$msg = "IMPORTING TO DATABASE has failed for XML site   |   to re-run the script, visit ". $fulldirectoryurl ."create-xml.php ";
		$mailheaders  = "MIME-Version: 1.0\r\n";
		$mailheaders .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$mailheaders .= "From: BWWS Alerts <websites@yachtworld.com>\r\n";
		$mailheaders .= "Reply-To: BWWS Alerts <$errorsemail>\r\n"; 
		mail("$errorsemail","ALERT for: " . $brokername,stripslashes($msg), $mailheaders);
	}
}



?>
