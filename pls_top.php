<?php 
	ini_set('display_errors', '1');
	if (isset($_GET["slim"]))
	{
		$pp=$_GET["slim"];
	}
	else
	{
		$qs= $_SERVER['QUERY_STRING'];
		$ppStart=(strpos($qs,"slim=") ? strpos($qs,"slim=")+1 : 0);
		$ppEnd=substr($qs,strlen($qs)-(strlen($qs)-$ppStart-4));
		$pp=substr($ppEnd,0,8);
	} 

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

	// Reads a file called  dealer_PLS.txt , Assuming it to be in the same directory. 
	$PLSids=file_get_contents("dealer_PLS.txt");
	//die($PLSids);

	$PLSids=str_replace(chr(10),"",$PLSids);
	$PLSids=str_replace(chr(13),"",$PLSids);

	$arrPLS=explode("||",$PLSids);
	for ($i=0; $i<=count($arrPLS)-1; $i++)
	{
		if ((substr(trim($arrPLS[$i]),0,2))==("pp") && (substr($arrPLS[$i],0,3))!=("pp "))
		{
			$arrPLSDetails=explode("|",$arrPLS[$i]);
			//print_r($arrPLSDetails);
			if ((trim($arrPLSDetails[0]))==($pp))
			{
				//pp numbers match, set style sheet and iframe details
				$strStyleSheet=trim($arrPLSDetails[1]);
				$strIframe = trim($arrPLSDetails[2]);
			} 
		} 
	}
	//die($strStyleSheet  . " ---------------- ". $strIframe);
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
		foreach($_GET as $x => $Y)
		{
			$tmp .= $x."=".$Y."&";
		}
		return $tmp ;// find out how request.querystring behaves . 
	}
?>