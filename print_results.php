<?php 
	error_reporting('off');
	if (!function_exists('curl_setopt_array')) 
	{
  		function curl_setopt_array(&$ch, $curl_options)
  		{
      		foreach ($curl_options as $option => $value) 
			{
          		if (!curl_setopt($ch, $option, $value)) 
				{
              		return false;
          	} 
      	}
      	return true;
  	}
}

	function get_web_page( $url )
	{    
		// basically ASP page doesent use  any xml as it looks to be by using msxml ... etc 
		$arr = explode("&",$url) ;
		for($i=1;$i<=count($arr)-1;$i++)
		{
			$tmp = explode("=",$arr[$i]);
			if(isset($tmp[1])) 
			{
				$url = str_replace($tmp[1],urlencode($tmp[1]),$url);
			}
		}
		$options = array(  CURLOPT_RETURNTRANSFER => true,     // return web page        
		CURLOPT_HEADER         => false,    
		// don't return headers       
		CURLOPT_FOLLOWLOCATION => true,     
		// follow redirects        
		CURLOPT_ENCODING       => "",       // handle all encodings        
		CURLOPT_USERAGENT      => "spider", // who am i        
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect        
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect        
		CURLOPT_TIMEOUT        => 120,      // timeout on response        
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects   
		);    
		$ch      = curl_init( $url );    
		curl_setopt_array( $ch, $options );    
		$content = curl_exec( $ch );    
		$err     = curl_errno( $ch );    
		$errmsg  = curl_error( $ch );    
		$header  = curl_getinfo( $ch );    
		curl_close( $ch );    
		$header['errno']   = $err;    
		$header['errmsg']  = $errmsg;    
		$header['content'] = $content;    
		//print ($url);
		//print_r($header);
		//die();
		return $header;
	}	

	function replace_query_ASP()
	{
		$tmp = "";
		foreach($_GET as $x => $Y)
		{
			$tmp .= $x."=".$Y."&";
		}
		return $tmp ;// find out how request.querystring behaves . 
	}
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Details</title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<meta http-equiv="Content-Language" content="en-GB">

<script language="javascript" type="text/javascript" src="js/imageFunctions.js"></script>
<script type="text/JavaScript">
<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+".location='search.asp?<%=Request.QueryString()%>&currencyid="+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}
//-->
</script>

<style type="text/css">

#hideOnPrint
		{display: none;}

</style>
    
<link href="intrinsic_search_print.css" rel="stylesheet" type="text/css">

</head>


<body onLoad="setTimeout(chkImg, 200); window.print();">


<img style="text-align: center; margin: 0px auto; display: block;" src="logo-intrinsic-print.jpg" alt="Intrinsic Yacht and Ship">
<div id="content">
<?php 
	if (($_SERVER["HTTP_HOST"]=="www.intrinsicyacht.com" || $_SERVER["HTTP_HOST"]=="intrinsicyacht.com" || $_SERVER["HTTP_HOST"]=="localhost" || $_SERVER["HTTP_HOST"]=="64.68.37.71" || $_SERVER["HTTP_HOST"]=="www.boatwizardwebsolutions.com" || $_SERVER["HTTP_HOST"]=="www.boats-search.com" || "boatwizardwebsolutions.com"))
	{
  		$BaseURL="http://www.yachtworld.com";
  	if ($_GET["rPage"]!="")
  	{
    	$sURL=$BaseURL.str_replace("rPage=","",replace_query_ASP());
  	}
    else
  	{
    	$sURL=$BaseURL."/privatelabel/listing/cache/pl_search_results.jsp?".replace_query_ASP().""; //Yacht Lisiting
    	$_SESSION['searchResultsURL']=str_replace($BaseURL,"",$sURL);
		//Response.Write("<a href=""default.asp?" & Session("searchResultsURL") & """ class=""btn"">Change Search Criteria</a><br><br>")
		//sURL = "/privatelabel/listing/pl_boat_detail.jsp?&units=Feet&checked_boats=1448887&slim=pp254585&" 'Yacht Detail
  	} 
  	if ($sURL!= "" && (strpos($_GET["rPage"],"pl_search_results.jsp") ? strpos($_GET["rPage"],"pl_search_results.jsp")+1 : 0)>0)
  	{
    	$_SESSION['searchResultsURL']=str_replace($BaseURL,"",$sURL);
   	}
  	// replace Msxml2.ServerXMLHTTP  with PHP might . 
  	//die($sURL);
  	$result = get_web_page($sURL);
  	//die($result['content']);
  	if($result['http_code']!=200)
	{
		$pageHTML = "<h1>An Error Occurred</h1><p>Sorry, but we are not able to complete the search at the moment.</p><p style=\"font-size: 100%;\">Error Code: 200 </p>";
  	}
	else
	{
		$pageHTML = $result['content'];
  	}
	//print_r($result);
	
	function drawImage($idNumber)
	{
		global $pageHTML , $out;
	  	// $idNumber = $out[1][] passed as  a param 
	  	$imgPath = "";
	  	for ($i=1; $i<=5; $i=$i+1)
	  	{
	    	$imgPath=$imgPath.substr(substr($idNumber,0,$i),strlen(substr($idNumber,0,$i))-(strlen(substr($idNumber,0,$i))-($i-1)))."/";
	  	}
		//		  |<---- this is 169 characters -------------------------------------------------------------------------------------------------------------------------------------------------------------->|
// Add hyperlink to thumbnail image
preg_match("/&boat_id={$idNumber}&primary_photo_id=\d+/", $pageHTML, $match);
preg_match("/&primary_photo_id=\d+/", $match[0], $match);
preg_match("/\d+/", $match[0], $match);
if(preg_match("/&boat_id={$idNumber}&primary_photo_id={$match[0]}&primary_photo_url=.*[A-Za-z0-9_%\.]&back/", $pageHTML)){
preg_match("/&boat_id={$idNumber}&primary_photo_id={$match[0]}&primary_photo_url=.*[A-Za-z0-9_%\.]&back/", $pageHTML, $newurlmatch);
preg_match("/&primary_photo_url=.*[A-Za-z0-9_%\.]&back/", $newurlmatch[0], $newurlmatch);
preg_match("/http.*[A-Za-z0-9_%\.].jpg/", $newurlmatch[0], $newurlmatch);
$imgNewSrc=urldecode($newurlmatch[0])."?w=300&h=300&t=".time();
$imgPath="<a href=\"/privatelabel/listing/pl_boat_detail_handler.jsp?slim=$pp&units=Feet&boat_id=$idNumber&back=/privatelabel/listing/cache/pl_search_results.jsp?slim=$pp&sm=3&is=All&cit=true&searchtype=buy\"><img src=\"".$imgNewSrc."\" border=\"0\" style=\"max-width: 100px;\" onmouseover=\"showtrail(this.src);\" onmouseout=\"hidetrail();\" /></a>";  
}
else{
$imgPath="<a href=\"/privatelabel/listing/pl_boat_detail_handler.jsp?slim=$pp&units=Feet&boat_id=$idNumber&back=/privatelabel/listing/cache/pl_search_results.jsp?slim=$pp&sm=3&is=All&cit=true&searchtype=buy\"><img src=\"http://newimages.yachtworld.com/".$imgPath.$idNumber."_".$match[0]."_thumb.jpg?".time()."\" border=\"0\" style=\"max-width: 100px;\" onmouseover=\"showtrail(this.src);\" onmouseout=\"hidetrail();\" /></a>"; 
}


		//							 |<---------- this 54 characters if boat_id is 7 digits	-------------->|
	  	$pageHTML=str_replace("<input type=\"checkbox\" name=\"checked\" value=\"".$idNumber."\">",$imgPath,$pageHTML);
	  	return;
	} 	
	preg_match_all("<input type=\"checkbox\" name=\"checked\" value=\"(.*)\">" ,
	$pageHTML,$out, PREG_PATTERN_ORDER);
	//print_r($out);
	foreach ($out[1] as $tempID)
	{
		drawImage($tempID);
	}

	$pageHTML=str_replace("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">","",$pageHTML);
	$pageHTML=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"../../includes/css/brokerpages.css\">","",$pageHTML);
	$pageHTML=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"/core/includes/css/brokerpages.css\">","",$pageHTML);

	$pageHTML=str_replace("width=650 bgcolor=\"#FFFFFF\"","width=\"100%\"",$pageHTML);
	$pageHTML=str_replace("<!--".chr(10)."</body>".chr(10)."</html>".chr(10)."-->","",$pageHTML);
	$pageHTML=str_replace("<!-- /opt/weblogic/waeyw/ywcluster/public_html/broker_pages/intrinsicyacht/boats.header.html:/opt/weblogic/waeyw/ywcluster/public_html/broker_pages/intrinsicyacht/boats.footer.html:-->","",$pageHTML);
	$pageHTML=str_replace("summary=\"search_results\"","summary=\"search_results\" width=\"100%\"",$pageHTML);
	
	//Replace images
	$pageHTML=str_replace("<img border=\"0\" alt=\"*\" src=\"../../images/star_2.gif\" />","<img src=\"img/full_listing.gif\" border=\"0\" align=\"absmiddle\" alt=\"Full specification available\" />",$pageHTML);
	
			$pageHTML=str_replace("view full listings for all the boats on this page.","",$pageHTML);
	//$pageHTML=str_replace("<img border=\"0\" alt=\"*\" src=\"/privatelabel/images/star_2.gif\" />","<img src=\"img/full_listing.gif\" align=\"absmiddle\" border=\"0\" alt=\"Full specification available\" />",$pageHTML);
		
//	$pageHTML=str_replace("<table border=\"0\"","border=\"1\"",$pageHTML);


	// Replaces images of Full Specification available

	foreach ($out[1] as $tempID)
	{
		$pageHTML=preg_replace("/<img border=\"0\" alt=\"\*\" src=\"\/privatelabel\/images\/star_2.gif\" \/>/","<a href=\"brokerage-inventory/?rPage=/privatelabel/listing/pl_boat_full_detail.jsp?slim=$pp&boat_id=$tempID&ybw=&units=Feet&access=Public&listing_id=1895&url=\"><img src=\"images/full_listing.png\" align=\"absmiddle\" border=\"0\" alt=\"Full Specifications Available.\"/> </a>",$pageHTML,1);
	}
	
	// Replace images of Photos available
	//foreach ($out[1] as $tempID)
	//{
	//	$pageHTML=preg_replace("/<img border=\"0\" src=http:\/\/newimages.yachtworld.com\/images\/camera.gif \/>/","<a href=\"yachts-for-sale.php?rPage=/privatelabel/listing/photo_gallery.jsp?slim=$pp&lang=en&units=Feet&id=$tempID&back=/privatelabel/listing/pl_boat_detail.jsp&boat_id=$tempID\"><img src=\"images/emphoto.png\" border=\"0\" align=\"absmiddle\" alt=\"Photos available\" /></a>",$pageHTML,1);
	//}
	
	$pageHTML=str_replace("<img src=\"/graphics/star_2.gif\" border=0>","<img src=\"img/full_listing.gif\" border=\"0\" alt=\"Full specification available\" align=\"absmiddle\" />",$pageHTML);
	$pageHTML=str_replace("<img border=\"0\" src=\"../../images/camera.gif\" />","<img src=\"img/emphoto.gif\" border=\"0\" align=\"absmiddle\" alt=\"Photos available\" />",$pageHTML);
	$pageHTML=str_replace("<img border=\"0\" src=\"/privatelabel/images/camera.gif\" />","<img src=\"img/emphoto.gif\" border=\"0\" align=\"absmiddle\" alt=\"Photos available\" />",$pageHTML);
	$pageHTML=str_replace("<img border=\"0\" src=http://www.yachtworld.com/images/camera.gif />","<img src=\"img/emphoto.gif\" border=\"0\" align=\"absmiddle\" alt=\"Photos available\" />",$pageHTML);
	$pageHTML=str_replace("<img src=\"/graphics/camera.gif\" border=0>","<img src=\"img/emphoto.gif\" border=\"0\" alt=\"Photos available\" align=\"absmiddle\" /> ",$pageHTML);
	$pageHTML=str_replace("<img src=\"/images/ML-Logo.png\"/>","<img src=\"img/ML-Logo.png\" alt=\"Fairline Approved\" border=\"0\" vspace=\"4\" />",$pageHTML);
	//$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/star_2.gif\" border=0>","<img src=\"/img/full_listing.gif\" align=\"absmiddle\" border=\"0\" />",$pageHTML);
	$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/star_2.gif\" border=0>","<img src=\"images/full_listing.png\" align=\"absmiddle\" border=\"0\" />",$pageHTML);
	//$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/camera.gif\" border=0>","<img src=\"/img/emphoto.gif\" align=\"absmiddle\" border=\"0\" />",$pageHTML);
	$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/camera.gif\" border=0>","<img src=\"images/emphoto.png\" align=\"absmiddle\" border=\"0\" />",$pageHTML);

	//Form
	$pageHTML=str_replace("<form name=\"search_results\" method=get action=\"../../listing/pl_boat_detail_handler.jsp?\" >","<form name=\"search_results\" method=\"get\" action=\"default.asp\"><input type=hidden name=\"rPage\" value=\"/privatelabel/listing/pl_boat_detail_handler.jsp?\"><input type=\"hidden\" value=\"".$_GET["region"]."\" />",$pageHTML);
	$pageHTML=str_replace("<td>".chr(10)."<input type=\"checkbox\"","<td class=\"hidden\"><input type=\"checkbox\"",$pageHTML);
	$pageHTML=str_replace("<td colspan=2></br>&nbsp;</td>","<td class=\"hidden\"></td><td></td>",$pageHTML);
	$pageHTML=str_replace("&nbsp;</b></a>","</b></a>",$pageHTML);

	//Paging image links
	$pageHTML=str_replace("<img valign=middle border=0 src=\"/core/images/buttons/next.gif\" />","<img src=\"images/page_next.png\" alt=\"Next page\" hspace=\"2\" valign=\"bottom\" border=\"0\"  />",$pageHTML);
	$pageHTML=str_replace("<img valign=middle border=\"0\" src=\"/core/images/buttons/back.gif\" />","<img src=\"images/page_previous.png\" alt=\"Previous page\" hspace=\"2\" valign=\"bottom\" border=\"0\"  />",$pageHTML);

	//Replace hyperlinks
	$pageHTML=str_replace("href=\"../../","href=\"?rPage=/privatelabel/",$pageHTML);
	$pageHTML=str_replace("href='../","href='?rPage=/privatelabel/",$pageHTML);
	$pageHTML=str_replace("href=\"/privatelabel/","href=\"?rPage=/privatelabel/",$pageHTML);
	$pageHTML=str_replace("href='/privatelabel/","href='?rPage=/privatelabel/",$pageHTML);
	$pageHTML=str_replace("href=\"../listing/","href=\"?rPage=/privatelabel/listing/",$pageHTML);
	$pageHTML=str_replace("href=/privatelabel/","href=?rPage=/privatelabel/",$pageHTML);

	//other tags
	$pageHTML=str_replace("<tr bgcolor=\"#CCE8FF\">","<tr class=\"approved\">",$pageHTML);
	$pageHTML=str_replace("<tr class=white bgcolor=\"#CCE8FF\">","<tr class=\"approved\">",$pageHTML);
	$pageHTML=str_replace("<tr class=blue bgcolor=\"#CCE8FF\">","<tr class=\"approved\">",$pageHTML);
	$pageHTML=str_replace("type=\"button\"","type=\"button\" class=\"hidden\" style=\"margin-top: 4px; \"",$pageHTML);
	$pageHTML=str_replace("type=\"submit\"","type=\"submit\" class=\"hidden\" style=\"margin-top: 4px; \"",$pageHTML);
	$pageHTML=str_replace("<font face=\"Verdana, Helvetica, sans-serif\" size=2>","",$pageHTML);
	$pageHTML=str_replace("<font face=\"Verdana, Helvetica, sans-serif\">","",$pageHTML);
	$pageHTML=str_replace("<blockquote><font face=\"Verdana, Helvetica, sans-serif\" size=2>","",$pageHTML);
	$pageHTML=str_replace("</font>","",$pageHTML);
	$pageHTML=str_replace("<hr>","",$pageHTML);
	$pageHTML=str_replace("<br>","<br>",$pageHTML);

	//fix table width on specs page
	$pageHTML=str_replace("width=95%","",$pageHTML);
	$pageHTML=str_replace("width=90%","",$pageHTML); 
	$pageHTML=str_replace("<table width=250 border=0 align=left>","<table width=250 border=0 align=left>",$pageHTML);

	//fix link target for contact link at bottom of boat details page
	$pageHTML=str_replace("target=\"_self\"","target=\"_blank\"",$pageHTML);


	//Remove Codes column
	$pageHTML=str_replace("<a href=\"#codes\"><b>Codes</b></a>","",$pageHTML);
	$pageHTML=str_replace("P&nbsp;U&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;","",$pageHTML);
	$pageHTML=str_replace("P&nbsp;U&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;","",$pageHTML);
	$pageHTML=str_replace("P&nbsp;U&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;","",$pageHTML);
	$pageHTML=str_replace("P&nbsp;U&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;","",$pageHTML);

	//Boat details page
	//If InStr(Request.QueryString("rPage"), "pl_boat_detail_handler.jsp") > 0 then
	$pageHTML=str_replace("<a href='http://www.boats.com/boat-loans/index.jsp'><img src='/graphics/button_finance.gif' border=0 alt='Boat Loans'></a>","",$pageHTML);
	$pageHTML=str_replace("><img src='/graphics/button_fullspec.gif' border=0 alt='Full specs'></a>","></a>",$pageHTML);
	$pageHTML=str_replace("><img src='/graphics/button_fullspec.gif' border=0 hspace=1 alt='Full specs'></a>","></a>",$pageHTML);

	$pageHTML=str_replace("><img src=\"/graphics/photo_gallery.gif\" border=0 hspace=1 alt=\"Photo Gallery\"></a>","></a>",$pageHTML);
	$pageHTML=str_replace("><img src=\"/graphics/photo_gallery.gif\" border=0 alt=\"Photo Gallery\">",">",$pageHTML);
	$pageHTML=str_replace("><img src='/graphics/button_email.gif' border=0 alt=Email>",">",$pageHTML);
	$pageHTML=str_replace("><img src=\"/graphics/button_email.gif\" border=0 alt=\"Email\">",">",$pageHTML);
	$pageHTML=str_replace("><img src=\"/graphics/button_email.gif\" border=0 alt=\"Email\" />",">",$pageHTML);
	
	
	$pageHTML=str_replace("<table align=\"center\"","<table",$pageHTML);
	$pageHTML=str_replace("<!-- This needs to be here in order to force the points table to float to the left -->","<div id=\"boatTitle\"></div>",$pageHTML);
	preg_match_all("/<h3>(.*)<\/h3>/" ,
	$pageHTML,$out,PREG_OFFSET_CAPTURE);
	if(isset($out[0][0][0]))
	{
		$pageHTML=str_replace($out[0][0][0],"<script>document.getElementById('boatTitle').innerHTML='".str_replace("'","&#39;",$out[0][0][0])."';</script>",$pageHTML);
	}
    preg_match_all("|<div class=\"hideOnPrint\" align=\"left\">(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n|" ,
	$pageHTML,$out,PREG_OFFSET_CAPTURE);
	// the above expression is tooo bad , but ok for the time being , could'nt think of any other way which worked . 
	$mValue=str_replace(chr(10),"",$out[0][0][0]);
	$mValue=str_replace("'","\"",$mValue);
	$mValue=str_replace("<table cellspacing=\"1\" cellpadding=\"0\">","",$mValue);
	$mValue=str_replace("</table>","",$mValue);
	$mValue=str_replace("<td>","",$mValue);
	$mValue=str_replace("</td>","",$mValue);
	$mValue=str_replace("<tr>","",$mValue);
	$mValue=str_replace("</tr>","",$mValue);
	$mValue=str_replace("class=\"hideOnPrint\"","id=\"hideOnPrint\"",$mValue);
	$mValue=str_replace("<a target=\"_blank\" href=\"http://www.boats.com/util/redirect.serv?id=4002\"><img src=\"/graphics/button_warranty.gif\" border=\"0\" alt=\"Warranty It\"></a>","",$mValue);
	$pageHTML=str_replace($out[0][0][0],$mValue,$pageHTML);
	//upto line number -- 202 of ASP 
	  
	// starting from line number 
	preg_match_all("|<TABLE cellspacing=\"2\" width=\"100%\" id=\"table1\">(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n|" ,
	$pageHTML,$out,PREG_OFFSET_CAPTURE);
	$pageHTML=str_replace($out[0][0][0],"",$pageHTML);
	
	// at this moment we have that table -- return to --- etc in 
	preg_match_all("|The URL has moved <a href=(.*)a>|" ,
	$pageHTML,$out,PREG_OFFSET_CAPTURE);
	if(isset($out[0][0][0]))
	{
		$pageHTML = str_replace($out[0][0][0],"" ,$pageHTML);
	}
	$pageHTML=str_replace("Click on one boat to view the full listing, or ","",$pageHTML);
	$pageHTML=str_replace("<td class=\"hidden\"></td><td></td>","<td class=\"hidden\">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>",$pageHTML);
	$pageHTML=str_replace("class=blue","",$pageHTML);
	$pageHTML=str_replace("><b>Length</b></a>"," style=\"text-align: right;\"><b>Length</b></a>",$pageHTML);
	$pageHTML=str_replace("<body style=\"margin: 0px 0px 0px 0px\" onLoad=\"initForm();\">","",$pageHTML);
	$pageHTML=str_replace("href=../listing","href=?rPage=/privatelabel/listing",$pageHTML);
	$pageHTML=str_replace("<font face='Verdana' size=2>","",$pageHTML);
	$pageHTML=str_replace("table width=\"616\"","table width=\"100%\"",$pageHTML);
	$pageHTML=str_replace("bgcolor=\"#5A79BB\"","class=\"galleryNav\"",$pageHTML);
	$pageHTML=str_replace("color: #333333;","color: #FFFFFF;",$pageHTML);
	$pageHTML=str_replace("style=\"width: 615px;","style=\"width: 600px;",$pageHTML);
	$pageHTML=str_replace("target=\"_blank\" >Email Us</a>",">Contact Us</a>",$pageHTML);
	$pageHTML=str_replace("style=\"text-decoration: none; color: #FFFFFF;\"","style=\"text-decoration: none; color: #333333; text-align: right;\"",$pageHTML);
	$pageHTML=str_replace("style=\"color: #333333; height: 21px; overflow: auto; ","style=\"color: #333333; font-weight: bold;",$pageHTML);
	$pageHTML=str_replace("style=\"color: #FFFFFF; height: 21px; overflow: auto; padding: 1px\"","style=\"color: #333333; font-weight: bold; height: 21px; overflow: auto; padding: 1px\"",$pageHTML);
	$pageHTML = str_replace("<a name=\"codes\">P=Power, S=Sail<br>N=New, U=Used<br>S=Single, T=Twin, D=Diesel, G=Gas/Petrol<br>W=Wood, ST=Steel, AL=Aluminum, FG=Fiberglass, CP=Composite, FC=Ferro-Cement","",$pageHTML);
	$pageHTML = str_replace("<br>O=Other/None,","",$pageHTML);
	echo $pageHTML;
}
else 
{
	print "<h1>Server Error</h1>";
	print "<p>This page is intended for use on www.boats-search.com only.</p>";

}
?>