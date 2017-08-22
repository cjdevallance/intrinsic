<?php  
	$init_html = "";
	if ($strIframe!="")
	{
  		print "";
	} 
?>

<div id="content">

	<?php 

	//die($_SERVER["HTTP_HOST"]);
	$strBackText="< Back";
	$strBackLinkClass="backLink";
	
	$strStyleSheet = isset($strStyleSheet) ? $strStyleSheet : "";
	$strIframe = isset($strIframe) ? $strIframe : "" ;
	
	if (($_SERVER["HTTP_HOST"]=="www.intrinsicyacht.com" || $_SERVER["HTTP_HOST"]=="intrinsicyacht.com" || $_SERVER["HTTP_HOST"]=="localhost" || $_SERVER["HTTP_HOST"]=="64.68.37.71" || $_SERVER["HTTP_HOST"]=="www.boatwizardwebsolutions.com" || $_SERVER["HTTP_HOST"]=="boatwizardwebsolutions.com") && $strStyleSheet!="" && $strIframe!="") 
	{
  		$BaseURL="http://www.yachtworld.com";
    	if ($_GET["rPage"]!="")
  		{
    		$sURL=$BaseURL.str_replace("rPage=","",replace_query_ASP());
  		}
    	else
    	{
			
			$sURL=$BaseURL."/privatelabel/listing/cache/pl_search_results.jsp?".replace_query_ASP().""; //Yacht Listing
    		$_SESSION['searchResultsURL']=str_replace($BaseURL,"",$sURL);
			//Response.Write("<a href=""default.asp?" & Session("searchResultsURL") & """ class=""btn"">Change Search Criteria</a><br><br>")
			//sURL = "/privatelabel/listing/pl_boat_detail.jsp?&units=Feet&checked_boats=1448887&slim=pp273655&" 'Yacht Detail
			print "<a href=\"javascript:history.back(1);\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";

			//To Open Printer Friendly version in Same Window remove comment from below print statment.
			//print "<div id=\"print\" style=\"float: right;\"><a href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
	  		//To Open Printer Friendly version in New Window remove comment from below print statment.
			print "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing ></a><div class=\"spacer\" style=\"height: 1px;\"></div>";
  		} 
  		if ($sURL!= "" && (strpos($_GET["rPage"],"pl_search_results.jsp") ? strpos($_GET["rPage"],"pl_search_results.jsp")+1 : 0)>0	)
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
	
	
		function drawImage($idNumber,$pp)
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
$imgPath="<a href=\"/privatelabel/listing/pl_boat_detail_handler.jsp?slim=$pp&units=Feet&boat_id=$idNumber&back=/privatelabel/listing/cache/pl_search_results.jsp?slim=$pp&sm=3&is=All&cit=true&searchtype=buy\"><img src=\"".$imgNewSrc."\" border=\"0\" style=\"max-width: 150px;\" onmouseover=\"showtrail(this.src);\" onmouseout=\"hidetrail();\" /></a>";  
}
else{
$imgPath="<a href=\"/privatelabel/listing/pl_boat_detail_handler.jsp?slim=$pp&units=Feet&boat_id=$idNumber&back=/privatelabel/listing/cache/pl_search_results.jsp?slim=$pp&sm=3&is=All&cit=true&searchtype=buy\"><img src=\"http://newimages.yachtworld.com/".$imgPath.$idNumber."_".$match[0]."_thumb.jpg?".time()."\" border=\"0\" style=\"max-width: 150px;\" onmouseover=\"showtrail(this.src);\" onmouseout=\"hidetrail();\" /></a>"; 
}

		  
			//$imgPath=str_replace("_1_thumb.jpg",$imgPath,$pageHTML);
			//							 |<---------- this 54 characters if boat_id is 7 digits	-------------->|
			$pageHTML=str_replace("<input type=\"checkbox\" name=\"checked\" value=\"".$idNumber."\">","<div style=\"width: 100%; min-width: 120px; padding-left: 2%;\">" . $imgPath . "</div>",$pageHTML);
			return;
		} 	
	
		//.gmmktime(0, 0, 0, 1, 1, 1970)."
		preg_match_all("<input type=\"checkbox\" name=\"checked\" value=\"(.*)\">" ,
		$pageHTML,$out, PREG_PATTERN_ORDER);
		//print_r($out);
		foreach ($out[1] as $tempID)
		{
			drawImage($tempID,$pp);
		}
	
		// hurrah , lets call the most confusing function . 
//		$strBackText="<img src=\"images/back.gif\" border=\"0\" alt=\"Back\" align=\"absmiddle\" />";
//		$strBackLinkClass="backLink";
		//die($_SERVER['QUERY_STRING']);
		$_SESSION['searchResultsURL']  = isset($_SESSION['searchResultsURL']) ?  $_SESSION['searchResultsURL'] : "";
		if (strpos($_SERVER['QUERY_STRING'],"pl_boat_detail_handler.jsp") == true) 
		{
  			if ($_SESSION['searchResultsURL']==FALSE )
  			{
    			$init_html  =  "<a href=\"javascript:history.back(1);".$_SESSION['searchResultsURL']."\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";
    			
				//To Open Printer Friendly Version in Same Window remove comment from below statment.
				//$init_html  .=  "<div id=\"print\" style=\"float: right;\"><a href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
				
				//To Open Printer Friendly version in New Window remove comment from below statment.
				$init_html  .=  "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing</a><div class=\"spacer\" style=\"height: 1px;\"></div>";
  			}
    		else
  			{
				//Response.Write("<a href=""default.asp?"" class=""btn"">Change Search Criteria</a><br><br>")
  			} 

		}
		
			
		if ((strpos($_GET["rPage"],"pl_search_results.jsp") ? strpos($_GET["rPage"],"pl_search_results.jsp")+1 : 0)>0)
		{
			//Response.Write("<a href=""default.asp?" & Session("searchResultsURL") & """ class=""btn"">Change Search Criteria</a><br><br>")
			print "<a href=\"javascript:history.back(1);\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";
			
			//To Open Printer Friendly version in Same Window remove comment from below print statment.
			//print "<div id=\"print\" style=\"float: right;\"><a href=\"http:falmouthyachtsales.com/print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
	  		//To Open Printer Friendly version in New Window remove comment from below print statment.
			print "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing</a><div class=\"spacer\" style=\"height: 1px;\"></div>";
			
		}
		
		if (strpos($_GET["rPage"],"pl_display_photo.jsp") == TRUE)
		{
			print "<a href=\"javascript:history.back(1);\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";
		  	//To Open Printer Friendly version in Same Window remove comment from below print statment.
			//print "<div id=\"print\" style=\"float: right;\"><a href=\"http:falmouthyachtsales.com/print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
			
			//To Open Printer Friendly version in New Window remove comment from below print statment.
			print "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing</a><div class=\"spacer\" style=\"height:1px;\"></div>";
			
		} 
		if ((strpos($_GET["rPage"],"photo_gallery.jsp") ? strpos($_GET["rPage"],"photo_gallery.jsp")+1 : 0)>0)
		{
	  		print "<a href=\"javascript:history.back(1);\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";
	  		//To Open Printer Friendly version in Same Window remove comment from below print statment.
			//print "<div id=\"print\" style=\"float: right;\"><a href=\"http:falmouthyachtsales.com/print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
			//To Open Printer Friendly version in New Window remove comment from below print statment.
			print "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing</a><div class=\"spacer\" style=\"height:1px;\"></div>";
						
		} 
		if ((strpos($_GET["rPage"],"pl_boat_full_detail.jsp") ? strpos($_GET["rPage"],"pl_boat_full_detail.jsp")+1 : 0)>0 || (strpos($_GET["rPage"],"pl_ts_boat_full_detail.jsp") ? strpos($_GET["rPage"],"pl_ts_boat_full_detail.jsp")+1 : 0)>0)
		{
	  		print "<a href=\"javascript:history.back(1);\" class=\"".$strBackLinkClass."\">".$strBackText."</a>";
	  		//To Open Printer Friendly version in Same Window remove comment from below print statment.
			//print "<div id=\"print\" style=\"float: right;\"><a href=\"http:falmouthyachtsales.com/print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">&nbsp;</a></div>";
			
			//To Open Printer Friendly version in New Window remove comment from below print statment.
			print "<a class=\"print\" target=\"_blank\" href=\"../print_results.php?".replace_query_ASP()."\" onclick=\"flvFPW1(this.href,'printWin','width=500,height=400,toolbar=yes,scrollbars=yes,resizable=yes',1);return document.MM_returnValue\">Print Listing</a><div class=\"spacer\" style=\"height:1px;\"></div>";
			
		} 
		//die();
		//Remove unnecessary html & change href's
		$pageHTML=str_replace("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">","",$pageHTML);
		$pageHTML=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"../../includes/css/brokerpages.css\">","",$pageHTML);
		$pageHTML=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"/core/includes/css/brokerpages.css\">","",$pageHTML);
		$pageHTML=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"../../includes/nauticastore.css\">","",$pageHTML);
	
	
		$pageHTML=str_replace("width=650 bgcolor=\"#FFFFFF\"","width=\"100%\"",$pageHTML);
		$pageHTML=str_replace("<!--".chr(10)."</body>".chr(10)."</html>".chr(10)."-->","",$pageHTML);
		$pageHTML=str_replace("<!-- /opt/weblogic/waeyw/ywcluster/public_html/broker_pages/boatbrokers/boats.header.html:/opt/weblogic/waeyw/ywcluster/public_html/broker_pages/boatbrokers/boats.footer.html:-->","",$pageHTML);
		$pageHTML=str_replace("logic/waeyw/ywcluster/public_html/broker_pages/boatbrokers/boats.header.html:/opt/weblogic/waeyw/ywcluster/public_html/broker_pages/boatbrokers/boats.footer.html:-->","",$pageHTML);
		$pageHTML=str_replace("summary=\"search_results\"","summary=\"search_results\" width=\"100%\"",$pageHTML);

		//Replace images
	
		// Remove comment of following line to hide Full specification's Available icon from listing.
		// $pageHTML=str_replace("<img border=\"0\" alt=\"*\" src=\"/privatelabel/images/star_2.gif\" />","",$pageHTML);
	
		// Replaces images of Full Specification available
		foreach ($out[1] as $tempID)
		{
			$pageHTML=preg_replace("/<img border=\"0\" alt=\"\*\" src=\"\/privatelabel\/images\/star_2.gif\" \/>/","",$pageHTML,1);
			
		}
		
		// Remove comment of following line to hide Photo Gallary icon from listing.
		// $pageHTML=str_replace("<img border=\"0\" src=http://newimages.yachtworld.com/images/camera.gif />","",$pageHTML);
		
		// Replace images of Photos available
		foreach ($out[1] as $tempID)
		{
			$pageHTML=preg_replace("/<img border=\"0\" src=http:\/\/newimages.yachtworld.com\/images\/camera.gif \/>/","",$pageHTML,1);
		}
		
		$pageHTML=str_replace("<img src=\"/graphics/camera.gif\" border=0>","",$pageHTML);
		$pageHTML=str_replace("<img src=\"/privatelabel/images/global/spacer.gif\"","<img src=\"http://newimages.yachtworld.com/images/spacer.gif\"",$pageHTML);
		
		$pageHTML=str_replace("<img src=\"/images/fl_approved_logo.gif\"/>","<img src=\"img/fl_approved_logo.gif\" alt=\"Fairline Approved\" border=\"0\" vspace=\"4\" />",$pageHTML);
		
		// Remove comment of following line to remove key of Full Specification at bottom
		$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/star_2.gif\" border=0>=Full&nbsp;Specs,","",$pageHTML);

		$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/star_2.gif\" border=0>","",$pageHTML);
				
		// Remove comment of following line to remove key of Photo Gallary at bottom
		$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/camera.gif\" border=0>=Photos,","",$pageHTML);

		$pageHTML=str_replace("<img src=\"http://www.yachtworld.com/graphics/camera.gif\" border=0>","",$pageHTML);

		// Remove comment of following line to remove key of Video Brochure at Bottom
		$pageHTML=str_replace("video_camera_small.jpg", "spacer.gif" , $pageHTML);
		$pageHTML=str_replace("=Videos", "" , $pageHTML);
		//$pageHTML=str_replace("<img src=\"http://newimages.yachtworld.com/images/video_camera_small.jpg\" alt=\"video brochure\" border=0>=Video&nbsp;Brochure", "" , $pageHTML);
		
		//Form
		$region  = isset($_GET["region"]) ?  $_GET["region"] : "" ;
		$pageHTML=str_replace("<form name=\"search_results\" method=get action=\"../../listing/pl_boat_detail_handler.jsp?\" >","<form name=\"search_results\" method=\"get\" action=\"default.php\"><input type=hidden name=\"rPage\" value=\"/privatelabel/listing/pl_boat_detail_handler.jsp?\"><input type=\"hidden\" value=\"".$region."\" />",$pageHTML);
		$pageHTML=str_replace("<td>".chr(10)."<input type=\"checkbox\"","<td class=\"hidden\"><input type=\"checkbox\"",$pageHTML);
		$pageHTML=str_replace("<td colspan=2></br>&nbsp;</td>","<td>&nbsp;</td><td>&nbsp;</td><td >&nbsp;</td>",$pageHTML);
		$pageHTML=str_replace("&nbsp;</b></a>","</b></a>",$pageHTML);
		
		// Responsive adjustment to boat make/model tabel column
		$pageHTML=str_replace("nowrap=\"nowrap\" colspan=\"2\"","nowrap=\"nowrap\" colspan=\"2\" style=\"height: 20px; margin-top: 3px\"",$pageHTML);

		// Below code will give border to existing HTML table which helps for modification
		// $pageHTML=str_replace("border=\"0\"","border=\"1\"",$pageHTML);
		
		
		

		// Replace hyperlinks
		$pageHTML=str_replace("href=\"../../","href=\"?rPage=/privatelabel/",$pageHTML);
		$pageHTML=str_replace("href='../","href='?rPage=/privatelabel/",$pageHTML);
		$pageHTML=str_replace("href=\"/privatelabel/","href=\"?rPage=/privatelabel/",$pageHTML);
		$pageHTML=str_replace("href='/privatelabel/","href='?rPage=/privatelabel/",$pageHTML);
		$pageHTML=str_replace("href=\"../listing/","href=\"?rPage=/privatelabel/listing/",$pageHTML);
		$pageHTML=str_replace("href=/privatelabel/","href=?rPage=/privatelabel/",$pageHTML);

		// other tags
		$pageHTML=str_replace("<tr bgcolor=\"#cce8ff\">","<tr class=\"approved\">",$pageHTML);

		$pageHTML=str_replace("type=\"button\"","type=\"button\" class=\"hidden\" style=\"margin-top: 4px; \"",$pageHTML);
		$pageHTML=str_replace("type=\"submit\"","type=\"submit\" class=\"hidden\" style=\"margin-top: 4px; \"",$pageHTML);
		$pageHTML=str_replace("<font FACE=\"verdana,helv,sans-serif\" size=2>","",$pageHTML);
		$pageHTML=str_replace("<font face=\"Verdana, Helvetica, sans-serif\">","",$pageHTML);
		$pageHTML=str_replace("<blockquote><FONT FACE=\"Verdana,helv,sans-serif\" size=2>","",$pageHTML);
		$pageHTML=str_replace("<img src=\"/graphics/button_foreign_exchange.gif\" border=\"0\" alt=\"Foreign Currency Exchange\">","",$pageHTML);
		$pageHTML=str_replace("<a target=\"_blank\" href=\"http://www.boats.com/util/redirect.serv?id=4010\">","<a target=\"_blank\" class=\"btn\" href=\"http://www.boats.com/util/redirect.serv?id=4010\">",$pageHTML);
		$pageHTML=str_replace("</font>","",$pageHTML);
		$pageHTML=str_replace("<hr>","",$pageHTML);
		$pageHTML=str_replace("<BR>","<br>",$pageHTML);


		// fix table width on specs page
		$pageHTML=str_replace("width=95%","",$pageHTML);
		$pageHTML=str_replace("width=90%","",$pageHTML);
		$pageHTML=str_replace("<table width=250 border=1 align=left>","<table width=250 border=1>",$pageHTML);

		// fix link target for contact-us.php link at bottom of boat details page
		$pageHTML=str_replace("target=\"_self\"","target=\"_blank\"",$pageHTML);


		// Remove Codes column
		$pageHTML=str_replace("<a href=\"#codes\"><b>Codes</b></a>","",$pageHTML);
		
		$codesArray = array("P&nbsp;U&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;FC&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;D&nbsp;FC&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;FC&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;D&nbsp;FC&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;O&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"&nbsp;&nbsp;U&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"&nbsp;&nbsp;U&nbsp;T&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;S&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;O&nbsp;D&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;T&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;D&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;D&nbsp;&nbsp;&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"&nbsp;&nbsp;U&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;G&nbsp;&nbsp;&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;D&nbsp;FC&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;T&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;G&nbsp;&nbsp;&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;O&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;S&nbsp;D&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;T&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;T&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;D&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;", 
			"&nbsp;&nbsp;U&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;G&nbsp;ST&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;G&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;S&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;AL&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;S&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;D&nbsp;O&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"S&nbsp;N&nbsp;O&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;&nbsp;&nbsp;AL&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;S&nbsp;G&nbsp;O&nbsp;&nbsp;", 
			"P&nbsp;U&nbsp;S&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;O&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;G&nbsp;FG&nbsp;&nbsp;", 
			"S&nbsp;U&nbsp;O&nbsp;G&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;S&nbsp;G&nbsp;AL&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"C&nbsp;N&nbsp;O&nbsp;O&nbsp;W&nbsp;&nbsp;", 
			"C&nbsp;U&nbsp;T&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"P&nbsp;N&nbsp;S&nbsp;O&nbsp;CP&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;S&nbsp;O&nbsp;FG&nbsp;&nbsp;", 
			"&nbsp;&nbsp;N&nbsp;O&nbsp;O&nbsp;O&nbsp;&nbsp;", 
			"&nbsp;&nbsp;U&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		
		$pageHTML=str_replace($codesArray, "", $pageHTML);	
		
	
		$pageHTML=str_replace("><img src=\"/graphics/button_finance.gif\" border=0 alt=\"Boat Loans\">" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_finance.gif' border=0 alt='Boat Loans'>" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/button_insure.gif\" border=0 alt=\"Boat Insurance\">" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_insure.gif' border=0 alt='Boat Insurance'>" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/button_ship.gif\" border=0 alt=\"Boat Transport\">" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_ship.gif' border=0 alt='Boat Transport'>" , "></a>", $pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_fullspec.gif' border=0 alt='Full specs'></a>"," class=\"btn\">Full Specification</a>",$pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/button_video.gif\" border=0 hspace=1 alt=\"Photo Gallery\"></a>" , " class=\"btn\">Video Brochure</a>", $pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_fullspec.gif' border=0 hspace=1 alt='Full specs'></a>"," class=\"btn\">Full Specification</a>",$pageHTML);

		preg_match_all("|<a(.*)http://newimages.yachtworld.com/images/video_camera_small.jpg(.*)a>|" ,$pageHTML,$out,PREG_OFFSET_CAPTURE);
		foreach($out[0] as $x) 
		{
			if(isset($x[0])) 
			{
				$pageHTML = str_replace($x[0],"" ,$pageHTML);
				
			}
		}
		$pageHTML=str_replace("><img src=\"/graphics/photo_gallery.gif\" border=0 hspace=1 alt=\"Photo Gallery\"></a>"," class=\"btn\">Photo Gallery</a>&nbsp;<a class=\"btn\" href=\"../contact-us/?subject=--replace--text--with--link--\">Contact Us About This Boat</a>",$pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/photo_gallery.gif\" border=0 alt=\"Photo Gallery\"></a>"," class=\"btn\">Photo Gallery</a>&nbsp;<a class=\"btn\" href=\"../contact-us/?subject=--replace--text--with--link--\">Contact Us About This Boat</a>",$pageHTML);
		$pageHTML=str_replace("><img src='/graphics/button_email.gif' border=0 alt=Email>",">",$pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/button_email.gif\" border=0 alt=\"Email\">",">",$pageHTML);
		$pageHTML=str_replace("><img src=\"/graphics/button_email.gif\" border=0 alt=\"Email\" />","/>",$pageHTML);
		$pageHTML=str_replace("<table align=\"center\"","<table",$pageHTML);
		$pageHTML=str_replace("<!-- This needs to be here in order to force the points table to float to the left -->","<div id=\"boatTitle\"></div>",$pageHTML);
	
		$pageHTML=str_replace("Click on one boat to view the full listing, or ","",$pageHTML);
		//End If	
		preg_match_all("/<h3>(.*)<\/h3>/" ,$pageHTML,$out,PREG_OFFSET_CAPTURE);
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

		// Search Results table column headings
		// preg_match_all("|<TABLE cellspacing=\"2\" width=\"100%\" id=\"table1\">(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n(.*)\n|" ,
		// $pageHTML,$out,PREG_OFFSET_CAPTURE);
		// $pageHTML=str_replace($out[0][0][0],"",$pageHTML);
		// $pageHTML=str_replace("<td class=\"hidden\"></td><td></td>","<td ></td><td ></td><td></td>",$pageHTML);
	
		$pageHTML=str_replace("class=blue","",$pageHTML);
	
		// Adding below line had aligned all the column heading in Listing page.Its very imp. for alignment of heading.
		$pageHTML=str_replace("<td colspan=2><a","<td><a",$pageHTML);
		
		$pageHTML=str_replace("><b>Boats</b></a>","style=\"text-align: right;\"><b> &nbsp;Boat Type</b></a>",$pageHTML);
		$pageHTML=str_replace("><b>Length</b></a>"," style=\"text-align: right;\"><b>Length</b></a>",$pageHTML);
	
		$pageHTML=str_replace("target=\"_self\"><img src=\"/graphics/button_email.gif\" border=0 hspace=1 alt=Email>", ">", $pageHTML);
	
		// Photo Gallery Page
		$pageHTML=str_replace("<BODY style=\"margin: 0px 0px 0px 0px\" onLoad=\"initForm();\">","",$pageHTML);
		$pageHTML=str_replace("href=../listing","href=?rPage=/privatelabel/listing",$pageHTML);
		$pageHTML=str_replace("<font face='verdana' size=2>","",$pageHTML);
		$pageHTML=str_replace("table width=\"616\"","table width=\"100%\"",$pageHTML);
		$pageHTML=str_replace("bgcolor=\"#5A79BB\"","class=\"galleryNav\"",$pageHTML);
		$pageHTML=str_replace("color:#ffff00;","color:white;",$pageHTML);
		$pageHTML=str_replace("style=\"width:615px;","style=\"width:600px;",$pageHTML);
		$pageHTML=str_replace("target=\"_blank\" >Email Us</a>",">Contact Us</a>",$pageHTML);
		$pageHTML=str_replace("style=\"text-decoration:none; color:white;\"","style=\"text-decoration: none; color: #555555; text-align: right;\"",$pageHTML);
		$pageHTML=str_replace("style=\"color:#ffff00; height:21px; overflow:auto; ","style=\"color: #555555; font-weight: bold;",$pageHTML);
		$pageHTML=str_replace("style=\"color:white; height:21px; overflow:auto; padding:1px\"","style=\"color:#555555; font-weight: bold; height:21px; overflow:auto; padding:1px\"",$pageHTML);
		preg_match_all("|The URL has moved <a href=(.*)a>|" ,$pageHTML,$out,PREG_OFFSET_CAPTURE);
		if(isset($out[0][0][0]))
		{
			$pageHTML = str_replace($out[0][0][0],"" ,$pageHTML);
		}
		preg_match_all("/<a (.*) view (.*) <\/a>/" ,$pageHTML,$out,PREG_OFFSET_CAPTURE);
		foreach($out[0] as $x => $y)
		{
			$pageHTML = str_replace($y[0],"",$pageHTML);
		}
		$pageHTML = str_replace("<a name=\"codes\">P=Power, S=Sail<br>N=New, U=Used<br>S=Single, T=Twin, D=Diesel, G=Gas/Petrol<br>W=Wood, ST=Steel, AL=Aluminum, FG=Fiberglass, CP=Composite, FC=Ferro-Cement","",$pageHTML);
		$pageHTML = str_replace("<br>O=Other/None,","",$pageHTML);
		// $pageHTML = str_replace(pageHTML, , "<div><img src=\"images/emphoto.gif\" border=\"0\" align=\"absmiddle\" alt=\"Photos available\" hspace=\"5\" vspace=\"3\" /> Photographs available</div><div><img src=\"images/full_listing.gif\" border=\"0\" align=\"absmiddle\" alt=\"Full Specification\" hspace=\"5\" vspace=\"3\" />Full Specification</div>") 
		$pageHTML = $init_html . $pageHTML;
		$pageHTML = str_replace("<a href=\"search_intrinsicyacht.php?rPage=\" class=\"backLink\">","<a href=\"javascript:history.back(0);\" class=\"backLink\">",$pageHTML);
		$pageHTML = str_replace("bgcolor=\"#FFFFFF\"", "", $pageHTML);
		
		$price_substr = substr($pageHTML, strpos($pageHTML, "<a href=\"http://www.boats.com/boat-insurance/index.jsp?price=") + strlen("<a href=\"http://www.boats.com/boat-insurance/index.jsp?price="), strpos($pageHTML, "\"></a></a>	<a rel=\"nofollow\" href=\"http://www.boats.com/boat-transport/index.jsp\"></a></a>	<a target=\"_blank\" class=\"btn\" href=\"http://www.boats.com/util/redirect.serv?id=4010\"></a></table>") - (strpos($pageHTML, "<a href=\"http://www.boats.com/boat-insurance/index.jsp?price=") + strlen("<a href=\"http://www.boats.com/boat-insurance/index.jsp?price=")));
		
		$pageHTML = str_replace("<a rel=\"nofollow\" href=\"http://www.yachtworld.com/boat-loans/index.jsp?\"></a></a>	<a href=\"http://www.boats.com/boat-insurance/index.jsp?price=" . $price_substr . "\"></a></a>	<a rel=\"nofollow\" href=\"http://www.boats.com/boat-transport/index.jsp\"></a></a>	<a target=\"_blank\" class=\"btn\" href=\"http://www.boats.com/util/redirect.serv?id=4010\"></a></table>
", "", $pageHTML);
		

		$pageHTML = str_replace("<a target=\"_blank\" class=\"btn\" href=\"http://www.boats.com/util/redirect.serv?id=4010\"></a>", "", $pageHTML);
		$pageHTML = str_replace("<img src=\"images/back.gif\" border=\"0\" alt=\"Back\" align=\"absmiddle\"></a>", "Back</a>", $pageHTML);
		$pageHTML = str_replace("<img src=\"http://newimages.yachtworld.com/images/spacer.gif\" width=\"5\" height=\"1\"/>", "&nbsp;", $pageHTML);
		$pageHTML = str_replace("<table width=\"90%\">", "<table width=\"100%\" style=\"font-weight: bold;\">", $pageHTML);
		$pageHTML = str_replace("<DIV id=\"ThumbnailDiv\" style=\"width: 600px; height: 130px; overflow: auto\">", "<div id=\"ThumbnailDiv\" style=\"width: 600px; height: 150px; overflow: auto\">", $pageHTML);
		
		//Change the color of the gallery images number count from yellow to whatever you like
		$pageHTML = str_replace("color:#ffff00;","color:#333333;" , $pageHTML);
		$pageHTML = str_replace("#ffff00;", "#333333", $pageHTML);
		
		//Change the broker email link
		$pageHTML=str_replace("http://www.yachtworld.com/intrinsicyacht/email.cgi?url=","../contact-us/?url=" , $pageHTML);	
		
	
		
		?>
        
        <?php
			if($_GET['boatname'] && $_GET['boat_id']){
				$boat_model_text = $_GET['boatname'];
				$boat_model_text = str_replace("\\'", "'", $boat_model_text);
			}
			else if($_GET['boat_id']){
				if(strpos($pageHTML, "innerHTML='<h3>")){
					$boat_model_text_start = strpos($pageHTML, "innerHTML='<h3>") + 15;
					$boat_model_text_end = strpos($pageHTML, "</h3>'");
					$boat_model_text = substr($pageHTML, $boat_model_text_start, ($boat_model_text_end - $boat_model_text_start));
					$boat_model_text = str_replace("&#39;", "'", $boat_model_text);
				}
				else{
					$boat_model_text_start = strpos($pageHTML, "Return to ") + 10;
					$boat_model_text_end = strpos($pageHTML, "</a>", $boat_model_text_start);
					$boat_model_text = substr($pageHTML, $boat_model_text_start, ($boat_model_text_end - $boat_model_text_start));
					$boat_model_text = str_replace("&#39;", "'", $boat_model_text);
				}
			}
			$message_fill_text = $boat_model_text . " (Boat ID: " . $_GET['boat_id'] . ").";
        	$pageHTML = str_replace("--replace--text--with--link--", $boat_model_text . " (Boat ID: " . $_GET['boat_id'] . ") " . "#contactform", $pageHTML);
		?>

        <?php
		echo $pageHTML;
			}  // this one is for the last else end if ,  though doesent make sense to me . 
		?>	

</div>