<?php

function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $email);
}

function composeXml($trade_in_val) {
	if ( $_POST['pbsposted'] ) {
		$xml = new DomDocument("1.0", "UTF-8");
	
		$xml_pbs = $xml->createElement("pbs");
		$xml_pbs->setAttribute("version", "1.0");
		
		$xml_pbs->appendChild( $xml->createElement("account", YW_ACCOUNT_ID ) );
		$xml_pbs->appendChild( $xml->createElement("domain", LM_DOMAIN_ID ) );
	
		$xml_pbs_contact = $xml->createElement("contact");
		$xml_pbs_contact->appendChild( $xml->createElement("firstname", stripslashes($_POST['firstname']) ) );
		$xml_pbs_contact->appendChild( $xml->createElement("lastname", stripslashes($_POST['lastname']) ) );
		$xml_pbs_contact->appendChild( $xml->createElement("email", stripslashes($_POST['email']) ) );
		$xml_pbs_contact->appendChild( $xml->createElement("phone", stripslashes($_POST['phone']) ) );
		$xml_pbs_contact->appendChild( $xml->createElement("comments", stripslashes($_POST['comments']) ) );
		$xml_pbs->appendChild( $xml_pbs_contact );

		$xml_pbs_criteria = $xml->createElement("criteria");

		$xml_pbs_criteria->appendChild( $xml->createElement("listingtype", $trade_in_val ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("isnew", stripslashes($_GET["is"]) ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("salestatus", "" ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("manufacturer", stripslashes($_GET["man"]) ) );
			
		$xml_pbs_types= $xml->createElement("types");
		$xml_pbs_types->appendChild( $xml->createElement("type", stripslashes($_GET["type"]) ) );

		$xml_pbs_criteria->appendChild( $xml_pbs_types );
			
		$xml_pbs_length=$xml->createElement("length");
		$xml_pbs_length->setAttribute("units", "126");
		$xml_pbs_length->appendChild( $xml->createElement("from", stripslashes($_GET["fromLength"]) ) );
		$xml_pbs_length->appendChild( $xml->createElement("to", stripslashes($_GET["toLength"]) ) );
		$xml_pbs_criteria->appendChild( $xml_pbs_length );
			
		$xml_pbs_year=$xml->createElement("year");
		$xml_pbs_year->appendChild( $xml->createElement("from", stripslashes($_GET["fromYear"]) ) );
		$xml_pbs_year->appendChild( $xml->createElement("to", stripslashes($_GET["toYear"]) ) );
		$xml_pbs_criteria->appendChild( $xml_pbs_year );
			
		$xml_pbs_price=$xml->createElement("price");
		$xml_pbs_price->setAttribute("currency", "100");
		$xml_pbs_price->appendChild( $xml->createElement("from", stripslashes($_GET["fromPrice"]) ) );
		$xml_pbs_price->appendChild( $xml->createElement("to", stripslashes($_GET["toPrice"]) ) );
		$xml_pbs_criteria->appendChild( $xml_pbs_price );

		$xml_pbs_criteria->appendChild( $xml->createElement("hullmaterial", stripslashes($_GET["hmid"]) ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("fuel", stripslashes($_GET["ftid"]) ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("numberofengines", stripslashes($_GET["enid"]) ) );
		$xml_pbs_criteria->appendChild( $xml->createElement("city", stripslashes($_GET["city"]) ) );
			
		$xml_pbs_states = $xml->createElement("states");
		$xml_pbs_states->appendChild( $xml->createElement("state", stripslashes($_GET["spid"]) ) );

		$xml_pbs_criteria->appendChild( $xml_pbs_states );

		$xml_pbs_countries= $xml->createElement("countries");
		$xml_pbs_countries->appendChild( $xml->createElement("country", stripslashes($_GET["cint"]) ) );

		$xml_pbs_criteria->appendChild( $xml_pbs_countries ); 

		$xml_pbs_regions=$xml->createElement("regions");
		$xml_pbs_regions->appendChild( $xml->createElement("region", stripslashes($_GET["rid"]) ) );
		
		$xml_pbs_criteria->appendChild( $xml_pbs_regions );		
		$xml_pbs->appendChild( $xml_pbs_criteria );
			
		$xml->appendChild($xml_pbs);
		
		return $xml->saveXML();
	}
}

function sendPbsData($url, $data) {
	$curl = curl_init();	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "data=".urlencode($data));
	$response = @curl_exec($curl);
	$httpInfo = @curl_getinfo($curl);
	$result = array('httpcode'=>$httpInfo['http_code'], 'response'=>trim($response));
	curl_close($curl);
	return $result;
}

?>