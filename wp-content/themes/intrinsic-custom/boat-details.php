<?php 
//This document displays the individual boat spec
ini_set('max_execution_time', '60');

//Include configuration parameters
require("setup/config.php");

//Include database class
require("classes/db.class.php");
$db = new db();

//Include details php file
require("includes/get-details.php");

//Contact form redirect code
function curPageURL() {
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
$url = curPageURL();
?>

<!---------- middle content ----------->

<?php

function youtubeEmbedFromUrl($youtube_url, $width, $height){
	$vid_id = extractUTubeVidId($youtube_url);
	return generateYoutubeEmbedCode($vid_id, $width, $height);
}
 
function extractUTubeVidId($url){
	/*
	* type1: http://www.youtube.com/watch?v=H1ImndT0fC8
	* type2: http://www.youtube.com/watch?v=4nrxbHyJp9k&feature=related
	* type3: http://youtu.be/H1ImndT0fC8
	*/
	$vid_id = "";
	$flag = false;
	if(isset($url) && !empty($url)){

	/*case1 and 2*/
	$parts = explode("?", $url);
	if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){
		$params = explode("&", $parts[1]);
		if(isset($params) && !empty($params) && is_array($params)){
			foreach($params as $param){
				$kv = explode("=", $param);
				if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){
					if($kv[0]=='v'){
						$vid_id = $kv[1];
						$flag = true;
						break;
						}
					}
				}
			}
		}

	/*case 3*/
	if(!$flag){
		$needle = "youtu.be/";
		$pos = null;
		$pos = strpos($url, $needle);
		if ($pos !== false) {
			$start = $pos + strlen($needle);
			$vid_id = substr($url, $start, 11);
			$flag = true;
			}
		}
	}
	return $vid_id;
}

function generateYoutubeEmbedCode($vid_id, $width, $height){
	$w = $width;
	$h = $height;
	$html = '<iframe id="iplayer" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$vid_id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	return $html;
}

?>
<section class="middle-section-downlevel">

	<div class="page-title">
		<h1 class="boat-title"><?php echo $boat['Make'] . " " . $boat['Model']; ?></h1>
	</div>

	<div id="boat-details-container">

		<div id="container-left">

			<!-- START IMAGE GALLERY -->
	
			<?php $boatid = $_GET['BoatID'];?>

			<div id="Display_content" onload="change('h1')"></div>

			<div id="image-gallery" class="image-gallery">
            
				<ul id="content-slider-inside" style="">
				<li id="tab1">
                
				<div id="gallery">
					<?php 
					$Query = "SELECT * FROM images WHERE BoatID=$id";
					$imagedata = $db->db_query($Query); 
					while($image = $db->db_rs($imagedata)) {?>
					<img src="<?php echo $image['ImageURL'] ?>" title="<?php echo $image['ImageTitle'] ?>" /><br/>
					<?php }?>
				</div>
                
				<script>
					Galleria.loadTheme('<?php bloginfo( 'template_url' ); ?>/galleria/themes/classic/galleria.classic.min.js');
					Galleria.run('#gallery');
					Galleria.configure({
					width: 610,
					height: 400,
					autoplay: 5000
					});
				</script>
				</li>

				<li id="tab3"><?php if ($video['Video2']){echo "<iframe id=\"iframevd\" wmode=\"opaque\" width=\"610\" height=\"410\" frameborder=\"0\" allowfullscreen=\"\" src=\""; echo $video['Video2']; echo "?wmode=opaque\" > </iframe>";}?></li>
				</ul>
			</div>

			<!-- END IMAGE GALLERY -->

			<!-- VIDEO GALLERY -->

			<div id="details-video" style="display: none;">
				<div></div>
			</div>

			<?php if ($video['BoatID'] = $boat['BoatID']) { ?>

			<div id="below-slide">

				<div class="details-buttons"></div>

				<ul>
				<li class="vidlink" id="slides"><a id="t1" onClick="change('tab1')" class="bd-sshow-btn"> Slideshow</a></li>
				<?php if ($video['UniqueMediaURL']){echo "<li class=\"vidlink\"><a rel=\"shadowbox;width=700;height=400;\" href=\"" . $video['UniqueMediaURL'] . "\" id=\"t3\" onClick=\"change('tab3')\" class=\"bd-vrit-tour-btn\";>360 Tour(unique media)</a></li>";}?>
				<?php if ($video['VideoBrochure']){echo "<li class=\"vidlink\"><a rel=\"shadowbox;width=700;height=400;\" href=\"" . $video['VideoBrochure'] . "\" id=\"t3\" onClick=\"change('tab3')\" class=\"bd-vrit-tour-btn\";>Video Brochure</a></li>";}?>

				<?php 
				$Query = "SELECT * FROM videos WHERE BoatID=$id";
				$videodata = $db->db_query($Query); 
				while($video = $db->db_rs($videodata)) { ?>
				<?php if ($video['VideoURL']){ ?>
				<li id="num<?php echo $i; ?>" class="vidlink"><img style="float: left;" src="<?php bloginfo( 'template_url' ); ?>/images/movie-icn.png"><?php echo $video['VideoTitle']?></li>

				<?php
				$theVideo = $video['VideoURL'];
				$embed_code = youtubeEmbedFromUrl($theVideo, 610, 390);
				echo "" . $embed_code . "</p>" ;
				?>
				<?php } ?>
                </ul>
                
                <? } ?>
                
			</div>
            
			<?php } ?>

			<!-- END VIDEO GALLERY -->

		</div>

		<div id="container-right">

		<!-- START SIDEBAR -->

			<div id="sidebar" style="height: 600px;">

				<div class="xml-contact-form-container">

					<h5>Contact us about this yacht</h5>
				
					<!-- CONTACT FORM DESKTOP -->

					<div class="xml-contact-form-desktop">
                    
                    	<style>

						span#bravo
								{display: none;}
						
						input.criticalinformation
								{display: none;}
						
						</style>
						
						<?php
						$int0 = rand(1,9);
						$int1 = rand(1,9);
						$int2 = rand(1,9);
						$sum = $int1 + $int2;
						?>
                        
						<?php 
						if ($_GET['sent']){
						echo "<hr><p style=\"font-size: 130%; margin: 0px; color: #333333;\">THANK YOU!</p>

						<p style=\"color: #333333;\">Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
						} else { ?>
                        
                        <?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
			
                        <form id="contact-main-form" name="contact_boat_details" method="post" action="<?php bloginfo( 'template_url' ); ?>/contact-form-boat-details.php">
                        <input class="starfish" type="text" name="starfish">
                        <input type="hidden" name="reference" value="<?php echo $reference; ?>">

						<div id="option">
							Full Name<span class="required-star">*</span>: <input type="text" name="name">
						</div>

						<div id="option">
							Telephone: <input type="text" name="phone">
						</div>

						<div id="option">
							Email Address<span class="required-star">*</span>: <input type="text" name="email">
						</div>

						<div id="option">
							Subject: <br>
							<input type="text" name="subject" value="<?php echo $boat['BoatID'] . " - " . $boat['Year'] . " " . $boat['Length_ft'] . " " . $boat['Make'] . " " . $boat['Model']; ?>">
						</div>

						<div id="option">
							Your question or message:<br>
                            <textarea name="comments" style="height: 65px;" cols="20"></textarea>
						</div>
                        
                        <!-- new CAPTCHA
                        <div style="width: 97%; margin: 5% 0 0; display: inline-block;">
                            <span>Enter the code in the box below:</span>
                            <div class="verification">
                                <img id ="vimage" src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/captcha.php" alt="Verification code" width="99">
                                <a class="refresh" href="#" onclick="document.getElementById('vimage').src = 'http://intrinsicyacht.com/wp-content/themes/intrinsic-custom/captcha-form/library/captcha.php?' + Math.random(); return false">
                                <img src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/images/refresh.png" alt="Anti Spam">
                                </a>
                              
                                <input type="text" name="verify" class="text" id="verify" placeholder="Enter the code" title="This confirms you are a human user and not a bot.">
                            </div>
                        </div>
                        end new CAPTCHA -->
                        
                        <!-- Math CAPTCHA -->
                        <div id="option">
                            Solve: <?php echo "<span id='alpha'>" . $int1 . "</span>" . " + " . "<span id='bravo'>" . $int0  . " + " . "</span>" . "<span id='charlie'>" . $int2  . "</span>" . " = ";?><br>
                            <input type="text" name="result">
                            <input type="text" name="criticalinfo" class="criticalinformation" value="">
                            <input type="hidden" name="check0" value="13">
                            <input type="hidden" name="check1" value="5">
                            <input type="hidden" name="check2" value="13">
                            <input type="hidden" name="check3" value="<?php echo $int1; ?>">
                            <input type="hidden" name="check4" value="17">
                            <input type="hidden" name="check5" value="<?php echo $int2; ?>">
                            <input type="hidden" name="check6" value="10">
                            <input type="hidden" name="check7" value="<?php echo $sum; ?>">
                            <input type="hidden" name="check8" value="6">
                            <input type="hidden" name="check9" value="<?php echo $int0; ?>">
                        </div>
                        <!-- end Math CAPTCHA -->

                        <div class="search-table-button" style="width: 97%; margin: 0px auto; display: inline-block;">
                            <a href="javascript:validate_contact_boat_details();" class="search-form-button" id="search-btn">Submit</a>
                        </div>
	
						<p class="required-text"><span class="required-star">*</span> required fields</p>

						</form>

						<? } ?>

					</div>

					<!-- END CONTACT FORM DESKTOP -->

				</div>

			</div>

			<!-- END SIDEBAR -->

		</div>

	<!--</div>-->

	<!-- CONTACT FORM MOBILE-->

	<!-- accordian function -->

	<script type="text/javascript">
		$(document).ready(function () {
			$('.accordion-toggle-xml').on('click', function(event){
				event.preventDefault();

				var accordion = $(this);
				var accordionContent = accordion.next('.xml-contact-form-mobile');
				var accordionToggleIcon = $(this).children('.toggle-icon-xml');

				accordion.toggleClass("open");

				accordionContent.slideToggle(250);

				if (accordion.hasClass("open")) {
					accordionToggleIcon.html("<i class='fa fa-minus'></i>");
				} else {
					accordionToggleIcon.html("<i class='fa fa-plus'></i>");
				}
			});
		});
	</script>

	<!-- end accordian function -->
	
	<div class="accordian-guts-xml">
		<div class="accordion-container-xml">
			<a href="#" class="accordion-toggle-xml"><h4>Contact us about this yacht</h4> <span class="toggle-icon-xml"><i class="fa fa-plus"></i></span></a>
			<div class="xml-contact-form-mobile">

				<?php 
				if ($_GET['sent']){
				echo "<hr><p style=\"font-size: 130%; margin: 0px; color: #333333;\">THANK YOU!</p>

				<p style=\"color: #333333;\">Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
				} else { ?>
				
				<?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
	
				<form id="contact-main-form" name="contact_boat_details2" method="post" action="<?php bloginfo( 'template_url' ); ?>/contact-form-boat-details.php">
				<input class="starfish" type="text" name="starfish">
				<input type="hidden" name="reference" value="<?php echo $reference; ?>">

				<div id="option">
					Full Name<span class="required-star">*</span>: <input type="text" name="name">
				</div>

				<div id="option">
					Telephone: <input type="text" name="phone">
				</div>

				<div id="option">
					Email Address<span class="required-star">*</span>: <input type="text" name="email">
				</div>

				<div id="option">
					Subject: <br>
					<input type="text" name="subject" value="<?php echo $boat['BoatID'] . " - " . $boat['Year'] . " " . $boat['Length_ft'] . " " . $boat['Make'] . " " . $boat['Model']; ?>">
				</div>

				<div id="option">
					Your question or message:<br>
					<textarea name="comments" style="height: 65px;" cols="20"></textarea>
				</div>
                        
                <!-- new CAPTCHA
                <div style="width: 97%; margin: 5% 0 0; display: inline-block;">
                    <span>Enter the code in the box below:</span>
                    <div class="verification">
                        <img id ="vimage" src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/captcha.php" alt="Verification code" width="99">
                        <a class="refresh" href="#" onclick="document.getElementById('vimage').src = 'http://intrinsicyacht.com/wp-content/themes/intrinsic-custom/captcha-form/library/captcha.php?' + Math.random(); return false">
                        <img src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/images/refresh.png" alt="Anti Spam">
                        </a>
                      
                        <input type="text" name="verify" class="text" id="verify" placeholder="Enter the code" title="This confirms you are a human user and not a bot.">
                    </div>
                </div>
                end new CAPTCHA -->
                
                <!-- Math CAPTCHA -->
                <div id="option">
                    Solve: <?php echo "<span id='alpha'>" . $int1 . "</span>" . " + " . "<span id='bravo'>" . $int0  . " + " . "</span>" . "<span id='charlie'>" . $int2  . "</span>" . " = ";?><br>
                    <input type="text" name="result">
                    <input type="text" name="criticalinfo" class="criticalinformation" value="">
                    <input type="hidden" name="check0" value="13">
                    <input type="hidden" name="check1" value="5">
                    <input type="hidden" name="check2" value="13">
                    <input type="hidden" name="check3" value="<?php echo $int1; ?>">
                    <input type="hidden" name="check4" value="17">
                    <input type="hidden" name="check5" value="<?php echo $int2; ?>">
                    <input type="hidden" name="check6" value="10">
                    <input type="hidden" name="check7" value="<?php echo $sum; ?>">
                    <input type="hidden" name="check8" value="6">
                    <input type="hidden" name="check9" value="<?php echo $int0; ?>">
                </div>
                <!-- end Math CAPTCHA -->

                <div class="search-table-button" style="width: 97%; margin: 0px auto; display: inline-block;">
                    <a href="javascript:validate_contact_boat_details2();" class="search-form-button" id="search-btn">Submit</a>
                </div>

                <p class="required-text"><span class="required-star">*</span> required fields</p>

                </form>

                <? } ?>

			</div>

		</div>

	</div>

	<!-- END CONTACT FORM MOBILE -->

	<div id="boat-content-details">

		<a class="details-back" href="javascript:history.back(1);">&lt; Back to Previous Page</a>

		<br>
		<br>

		<!--START BASIC DETAILS-->

		<h1 class="boat-title"><?php echo $boat['Make'] . " " . $boat['Model']; ?></h1>

		<div id="essentials">

			<ul class="essentials">
			<?php if ($boat['Price'] != "1" && $boat['Price'] != "0" && $boat['PriceHide'] != "true"){ echo "<li><strong>Price: </strong>" . $boat['PriceCurrency']; echo $boat['Price'] . "</li>"; 
			} else { echo "Contact us for price" . "</li>"; }?>
			<?php if ($boat['Year'] != "" && $boat['Year'] != "0"){ echo "<li><strong>Model Year: </strong>" . $boat['Year'] . "</li>"; } else { echo ""; }?>
			<?php if ($boat['BoatID'] != "" && $boat['BoatID'] != "0"){ echo "<li><strong>Boat Ref: </strong>" . $boat['BoatID'] . "</li>"; } else { echo ""; }?>
			<?php if ($boat['Name'] != "" && $boat['Name'] != "0"){ echo "<li><strong>Boat Name: </strong>" . $boat['Name'] . "</li>"; } else { echo ""; }?>
			<?php if ($boat['Class'] != "" && $boat['Class'] != "0"){ echo "<li><strong>Boat Class: </strong>" . $boat['Class'] . "</li>"; } else { echo ""; }?>
			<?php if ($boat['LocationCity'] != "Unknown"){
				echo "<li><strong>Location:</strong> " . $boat['LocationCity'] . " " . $boat[ 'LocationState'] . ", </li>";;
			} else {
				echo "<li><strong>Location:</strong>";
			$boat['LocationCountry'] . "</li>"; }	 ?>
			</ul>

		</div>

		<p><?php echo strip_tags($boat['Description'],"<p><br>"); ?></p>

		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js#appId=228358150539054&amp;xfbml=1"></script>

		<fb:like href="<?php echo $url; ?>" send="true" width="470" show_faces="true" font=""></fb:like>

		<br>
		<br>

		<?php if ($boat['NotForSale'] != "" && $boat['NotForSale'] != "0"){ echo "<h3>*Not For Sale In "; echo $boat['NotForSale'] . " Waters</h3>"; } else { echo ""; }?>

		<div class="details-buttons">

			<a href="<?php bloginfo( 'template_url' ); ?>/pdffullspec.php?BoatID=<?php echo $boat['BoatID']; ?>" target="_blank">Print Details</a>

			<?php if ($video['VideoURL']){
				echo "<a rel=\"shadowbox;width=700;height=400;\" href=\"" . $video['VideoURL'] . "\">View Video</a>";
			} ?>

		</div>

		<?php if ($boat['SalesMessage'] !="") {
			echo "<div id=\"sales-message\">" . "<h2>Broker Information</h2>" . $boat['SalesMessage'] . "</div>";
		} ?>

		<div id="descriptions">
			<?php 
			$Query = "SELECT * FROM descriptions WHERE BoatID=$id";
			$textdata = $db->db_query($Query); 
			while($text = $db->db_rs($textdata)) {
				if ($text['AddTitle'] == "customContactInformation" ){
					$text['AddTitle']=str_replace("customContactInformation","Additional Contact Information",$text['AddTitle']);
					echo "<h4>" . $text['AddTitle'] . "</h4>";
					$text['AddDescription']=str_replace("Ã¢","'",$text['AddDescription']);
					echo "<p>". strip_tags($text['AddDescription'], '<strong><p><br>') . "</p>";
				}
			}?>

		</div>

		<div id="full-specs">

			<div class="column1">

				<span class="heading">Construction</span>

				<ul class="specs">
				<?php if ($boat['Builder'] != "" && $boat['Builder'] != "0"){ echo "<li><strong>Builder: </strong>"; echo $boat['Builder'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Designer'] != "" && $boat['Designer'] != "0"){ echo "<li><strong>Designer: </strong>"; echo $boat['Designer'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['HullMaterial'] != "" && $boat['HullMaterial'] != "0"){ echo "<li><strong>Construction: </strong>"; echo $boat['HullMaterial'] . "</li>"; } else { echo ""; }?>
				</ul>

				<span class="heading">Measurements</span>

				<ul class="specs">
				<?php if ($boat['Length_ft'] != "" && $boat['Length_ft'] != "0"){ echo "<li><strong>Length: </strong>"; echo $boat['Length_ft'] ."&nbsp;ft </li>"; } else { echo ""; }?>
				<?php if ($boat['Beam'] != "" && $boat['Beam'] != "0"){ echo "<li><strong>Beam: </strong>"; echo $boat['Beam'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Displacement'] != "" && $boat['Displacement'] != "0"){ echo "<li><strong>Displacement: </strong>" . $boat['Displacement'] . " ". $boat['DisplacementUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['MinDraft'] != "" && $boat['MinDraft'] != "0"){ echo "<li><strong>Min Draft:</strong>"; echo $boat['MinDraft'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['MaxDraft'] != "" && $boat['MaxDraft'] != "0"){ echo "<li><strong>Max Draft:</strong>"; echo $boat['MaxDraft'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Ballast'] != "" && $boat['Ballast'] != "0"){ echo "<li><strong>Ballast: </strong>" . $boat['Ballast'] . " ". $boat['BallastUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['DryWeight'] != "" && $boat['DryWeight'] != "0"){ echo "<li><strong>Dry Weight: </strong>" . $boat['DryWeight'] . " ". $boat['DryWeightUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['LOA'] != "" && $boat['LOA'] != "0"){ echo "<li><strong>LOA: </strong>" . $boat['LOA'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['LWL'] != "" && $boat['LWL'] != "0"){ echo "<li><strong>LWL: </strong>" . $boat['LWL'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['BridgeClearance'] != "" && $boat['BridgeClearance'] != "0"){ echo "<li><strong>Bridge Clearance: </strong></strong>" . $boat['BridgeClearance'] . " ". $boat['BridgeClearanceUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['LengthOnDeck'] != "" && $boat['LengthOnDeck'] != "0"){ echo "<li><strong>Length On Deck: </strong>" . $boat['LengthOnDeck'] . " ". $boat['LengthOnDeckUnit'] . "</li>"; } else { echo ""; }?>

				</ul>

				<? if ($boat['CruisingSpeed'] != "" && $boat['CruisingSpeed'] != "0" || $boat['MaxSpeed'] != "" && $boat['MaxSpeed'] != "0" || $boat['Range'] != "" && $boat['Range'] != "0"){ echo "<span class=\"heading\">Speed and Distance</span>"; } else { echo ""; }?>

				<ul class="specs">
				<?php if ($boat['CruisingSpeed'] != "" && $boat['CruisingSpeed'] != "0"){ echo "<li><strong>Cruising Speed: </strong>" . $boat['CruisingSpeed'] . " ". $boat['CruisingSpeedUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['MaxSpeed'] != "" && $boat['MaxSpeed'] != "0"){ echo "<li><strong>Max Speed: </strong>" . $boat['MaxSpeed'] . " ". $boat['MaxSpeedUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Range'] != "" && $boat['Range'] != "0"){ echo "<li><strong>Range: </strong>" . $boat['Range'] . " ". $boat['RangeUnit'] . "</li>"; } else { echo ""; }?>
				</ul>

				<? if ($boat['SingleBerthNo'] != "" && $boat['SingleBerthNo'] != "0" || $boat['DoubleBerthNo'] != "" && $boat['DoubleBerthNo'] != "0" || $boat['TwinBerthNo'] != "" && $boat['TwinBerthNo'] != "0" || $boat['CabinNo'] != "" && $boat['CabinNo'] != "0" || $boat['BathroomNo'] != "" && $boat['BathroomNo'] != "0"|| $boat['HeadNo'] != "" && $boat['HeadNo'] != "0"){ echo "<span class=\"heading\">Accommodations</span>"; } else { echo ""; }?>

				<ul class="specs">
				<?php if ($boat['SingleBerthNo'] != "" && $boat['SingleBerthNo'] != "0"){ echo "<li><strong>Single Berth No.: </strong>"; echo $boat['SingleBerthNo'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['DoubleBerthNo'] != "" && $boat['DoubleBerthNo'] != "0"){ echo "<li><strong>Double Berth No.: </strong>"; echo $boat['DoubleBerthNo'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['TwinBerthNo'] != "" && $boat['TwinBerthNo'] != "0"){ echo "<li><strong>Twin Berth No.: </strong>"; echo $boat['TwinBerthNo'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['CabinNo'] != "" && $boat['CabinNo'] != "0"){ echo "<li><strong>Cabin No.: </strong>"; echo $boat['CabinNo'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['BathroomNo'] != "" && $boat['BathroomNo'] != "0"){ echo "<li><strong>Bathroom No.: </strong>"; echo $boat['BathroomNo'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['HeadNo'] != "" && $boat['HeadNo'] != "0"){ echo "<li><strong>Head No.: </strong>"; echo $boat['HeadNo'] . "</li>"; } else { echo ""; }?>
				</ul>

			</div>

			<div class="column2">

				<span class="heading">Engines</span>

				<ul class="specs" style="margin-bottom: 10px;">
				<?php 
					$Query = "SELECT * FROM engines WHERE BoatID=$id";

					$textdata = $db->db_query($Query); 
					while($text = $db->db_rs($textdata)) {
					if ($text['EngineNo'] != ""){
						echo "<strong><li>Engine Number: " . $text['EngineNo'] . "</li></strong>";}
					if ($text['EngineMake'] != ""){
						echo "<li>Engine Make: " . $text['EngineMake'] . "</li>";}
					if ($text['EngineModel'] != ""){
						echo "<li>Engine Model: " . $text['EngineModel'] . "</li>";}
					if ($text['EngineYear'] != "" && $text['EngineYear'] != "0000" || $text['EngineYear'] != "0"){
						echo "<li>Engine Year: " . $text['EngineYear'] . "</li>";}
					if ($text['EngineFuel'] != ""){
						echo "<li>Engine Fuel Type: " . $text['EngineFuel'] . "</li>";}
					if ($text['PropellerType'] != ""){
						echo "<li>Engine Propeller Type: " . $text['PropellerType'] . "</li>";}
					if ($text['DriveType'] != ""){
						echo "<li>Engine Drive Type: " . $text['DriveType'] . "</li>";}
					if ($text['EngineHours'] != ""){
						echo "<li>Engine Hours: " . $text['EngineHours'] . "</li>";}
					if ($text['HorsePower'] != "" && $text['HorsePower'] != "0" ){
						echo "<li>Engine Horsepower: " . $text['HorsePower'] . " ". $text['HorsePowerUnit'] . "</li>";}
						echo '<div class="spacer" style="height:20px;"></div>';
					}
				?>
				</ul>

				<span class="heading">Tankage</span>

				<ul class="specs">
				<?php if ($boat['FuelTankNo'] != "" && $boat['FuelTankNo'] != "0") if ($boat['FuelTankCap'] != "" && $boat['FuelTankCap'] != "0"){ echo "<li><strong>Fuel: </strong>" . $boat['FuelTankNo'] . " x " . $boat['FuelTankCap'] . " ". $boat['FuelTankCapUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['WaterTankNo'] != "" && $boat['WaterTankNo'] != "0") if ($boat['WaterTankCap'] != "" && $boat['WaterTankCap'] != "0"){ echo "<li><strong>Water: </strong>" . $boat['WaterTankNo'] . " x " . $boat['WaterTankCap'] . " ". $boat['WaterTankCapUnit'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['HoldingTankNo'] != "" && $boat['HoldingTankNo'] != "0") if ($boat['HoldingTankCap'] != "" && $boat['HoldingTankCap'] != "0"){ echo "<li><strong>Holding: </strong>" . $boat['HoldingTankNo'] . " x " . $boat['HoldingTankCap'] . " ". $boat['HoldingTankCapUnit'] . "</li>"; } else { echo ""; }?>
				</ul>

				<? if ($boat['SeatingCapacity'] != "" && $boat['SeatingCapacity'] != "0" || $boat['Windlass'] != "" && $boat['Windlass'] != "0" || $boat['LifeRaftCapacity'] != "" && $boat['LifeRaftCapacity'] != "0" || $boat['Deadrise'] != "" && $boat['Deadrise'] != "0" || $boat['ElectricalCircut'] != "" && $boat['ElectricalCircut'] != "0" || $boat['TrimTabs'] != "" && $boat['TrimTabs'] != "0"){ echo "<span class=\"heading\">Miscellaneous</span>"; } else { echo ""; }?>

				<ul class="specs">
				<?php if ($boat['SeatingCapacity'] != "" && $boat['SeatingCapacity'] != "0"){ echo "<li><strong>Seating Capacity:</strong> "; echo $boat['SeatingCapacity'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Windlass'] != "" && $boat['Windlass'] != "0"){ echo "<li><strong>Windlass:</strong> "; echo $boat['Windlass'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['LifeRaftCapacity'] != "" && $boat['LifeRaftCapacity'] != "0"){ echo "<li><strong>Life Raft Capacity:</strong> "; echo $boat['LifeRaftCapacity'] . "</li>"; } else { echo ""; }?>
				<?php if ($boat['Deadrise'] != "" && $boat['Deadrise'] != "0"){ echo "<li><strong>Deadrise:</strong> "; echo $boat['Deadrise'] . "°" . "</li>"; } else { echo ""; }?>
				<?php if ($boat['ElectricalCircut'] != "" && $boat['ElectricalCircut'] != "0"){ echo "<li><strong>Electrical Circut:</strong> "; echo $boat['ElectricalCircut'] . " V" . "</li>"; } else { echo ""; }?>
				<?php if ($boat['TrimTabs'] != "" && $boat['TrimTabs'] != "0"){ echo "<li><strong>Trim Tabs:</strong> "; echo "Yes" . "</li>"; } else { echo ""; }?>
				</ul>

			</div>

		</div>

		<div id="external-links">

			<?php
				$Query = "SELECT * FROM links WHERE BoatID=$id";
				$linksdata = $db->db_query($Query); 
				while($link = $db->db_rs($linksdata)) {
					if ($link['ExternalLinkTitle'] !="") {
				echo "<h4>External Link</h4>" . "<a href=\"" . $link['ExternalLinkUrl'] . "\">" . $link['ExternalLinkTitle'] . "</a>" . "<br>"; }
			} ?>

		</div>

		<div id="descriptions">
			
			<?php 
				$Query = "SELECT * FROM descriptions WHERE BoatID=$id";
				$textdata = $db->db_query($Query); 
				while($text = $db->db_rs($textdata)) {
					if ($text['AddTitle'] != "customContactInformation" && $text['AddTitle'] != "Disclaimer"){
						echo "<h4>" . $text['AddTitle'] . "</h4>";
						$text['AddDescription']=str_replace("â","'",$text['AddDescription']);
						echo "<p>" . strip_tags($text['AddDescription']) . "<br></p>";
					}
				}
				$Query = "select lft2.translated_value as category, lft.translated_value as feature 
				from features f, lookup_features lf, lookup_feature_categories lfc, lookup_feature_translations lft, lookup_feature_translations lft2 
				where REPLACE(f.feature,'_','') = lf.label_name and lf.key_text = lft.key_text and lf.feature_category_id = lfc.feature_category_id and
				lfc.key_text = lft2.key_text and lft.language_name = 'en' and lft2.language_name = 'en' and f.boatid = $id 
				order by lfc.sort_order, lf.sort_order";

				$featuredata = $db->db_query($Query); 
				if ($db->db_rows($featuredata) > 0){
					echo "<h4>Features</h4><p>";
				$currentCategory = '';
				while($feature = $db->db_rs($featuredata)) {
				if ($feature['category'] != $currentCategory) {
				if ($currentCategory != '')
					echo '</ul></p><p>';
				$currentCategory = $feature['category'];
					echo "<strong>$currentCategory</strong><ul>";
				}
					echo "<li>" . $feature['feature'] . "</li>";
				}
					echo"</ul></div></p>";
				}
				$Query = "SELECT * FROM descriptions WHERE BoatID=$id";
				$textdata = $db->db_query($Query); 
				while($text = $db->db_rs($textdata)) {
					if ($text['AddTitle'] == "Disclaimer"){
						echo "<h4>" . $text['AddTitle'] . "</h4>";
						echo "<p>" . $text['AddDescription'] . "</p>";
					}
				}
			?>

		</div>

	</div>

	<!--END BASIC DETAILS-->

</div>

</div>

<script type="text/javascript">
	$("#num").click(function() {
		$("#details-video").show();
		$("#details-video div").empty();
		$("#num.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num0").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num0.vidbox div").clone().appendTo("#details-video div");
	});	
	$("#num1").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num1.vidbox div").clone().appendTo("#details-video div");
	});	
	$("#num2").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num2.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num3").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num3.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num4").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num4.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num5").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num5.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num6").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num6.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num7").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num7.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num8").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num8.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num9").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num9.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num10").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num10.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num11").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num11.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num12").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num12.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num13").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num13.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num14").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num14.vidbox div").clone().appendTo("#details-video div");
	});
	$("#num15").click(function() {
			$("#details-video").show();
			$("#details-video div").empty();
			$("#num15.vidbox div").clone().appendTo("#details-video div");
	});
	$("#slides").click(function() {
	$("#details-video div").empty();
	$("#details-video").hide();
	});

</script>