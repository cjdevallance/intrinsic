<?php
/*
* Template name: Worldwide Yacht Search (PLS)
*/
get_header(); 

?>

<!---------- middle content ----------->

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>   
    
    <?php $brandurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	if (false !== strpos($brandurl,'Albemarle')) { ?>
    
	<h5>Albemarle Boats</h5>

	<p>When you purchase an Albemarle Boat you and your family become members of our family, the Albemarle Family. Members will receive a gift pack of our Seabag Gear, including shirts, keychains, hats, and license plates. Also, twice a year family members will receive our bi-annual newsletter. Check out our online edition! If you are an Albemarle Family member drop us a line and send us a photo and we will post it in our Letters section.</p>

	<?php } elseif (false !== strpos($brandurl,'Bonadeo')) { ?>
	<h5>Bonadeo Boatworks</h5>
    
    <p>Bonadeo Boatworks began 20 plus years ago when Larry Bonadeo started sport fishing on the great lakes. After many years of both tournament fishing in Michigan and sport fishing in Florida and the Bahamas, water sports and especially boat handling, travel, fishing and renovation became both a hobby and passion.</p>
    
    <?php } elseif (false !== strpos($brandurl,'Cabo')) { ?>
	<h5>Cabo Yachts</h5>
    
    <p>CABO Yachts is an iconic American brand with an exciting past and rich history. The brand is known worldwide and has grown to represent the very best in the segments in which it competes. As the boating industry grows and changes we are constantly looking for ways to improve our products and incorporate innovative design without jeopardizing the fundamentals of the CABO heritage in being a high quality, “purpose built” sport fishing platform.</p>
    
    <?php } elseif (false !== strpos($brandurl,'Hatteras')) { ?>
	<h5>Hatteras Yachts</h5>
    
    <p>Hatteras Yachts was born out of the treacherous waters that surround Cape Hatteras. It was here, in the fabled Graveyard of the Atlantic, that Willis Slane was inspired to construct a yacht to conquer seas subject to the wrath of nature. Over 50 years later, perseverance to achieve excellence is more than tradition - it is the Hatteras promise.</p>
    
    <?php } elseif (false !== strpos($brandurl,'Jupiter')) { ?>
	<h5>Jupiter Boats</h5>

	<p>With over 35 years of boat building experience, the Jupiter Team is committed to building the finest, most technologically advanced offshore sportfishing boats available today. Every Jupiter is individually built to the exacting specifications of the sportsman who demands the very best in offshore performance, styling and reliability.</p>
    
    <?php } elseif (false !== strpos($brandurl,'Ocean+Yachts')) { ?>
	<h5>Ocean Yachts</h5>
		
	<p>Ocean Yachts has been building premium high-performance sport-fishing yachts in the 40′ to 73′ class since 1977 and are known for their unbeatable combination of performance, speed, power, luxury, styling and durability.</p>
 
	<?php } ?>

	<section id="pls" class="third_last">

		<!-- accordian function -->
    
		<script type="text/javascript">
            $(document).ready(function () {
                $('.accordion-toggle-pls').on('click', function(event){
                    event.preventDefault();

                    var accordion = $(this);
                    var accordionContent = accordion.next('.accordion-content-pls');
                    var accordionToggleIcon = $(this).children('.toggle-icon-pls');

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
        
        <!-- yacht search box -->

        <div class="accordian-guts-pls">
        
            <div class="accordion-container-pls">
                
                <a href="#" class="accordion-toggle-pls"><h3>Worldwide Yacht Search</h3> <span class="toggle-icon-pls"><i class="fa fa-plus"></i></span></a>
                
                <div class="accordion-content-pls">
                
                    <form action="<?php bloginfo( 'url' ); ?>/compile_search.php" method="post" name="searchform">
                    <input type="hidden" name="urlx" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>">
                    <input type="hidden" id="inv" name="source" value="inv">

                    <div id="Search_Body_Table">
                    
                        <div style="width: 97%; display: inline-block;">
                            Make/Model:<br>
                            <input type="text" name="man" style="width: 100%;">
                        </div>
                        
                        <div style="width: 100%; display: inline-block;">
                            Boat Type:<br>
                            <select name="type" style="width: 100%;">
                            <option value="">All Boat Types</option>
                            <option value=""> ----------------</option>
                            <option value="(Power)">All Power</option>
                            <option value="(Power) Aft Cabin">Aft Cabin</option>
                            <option value="(Power) Antique and Classic">Antique and Classic</option>
                            <option value="(Power) Barge">Barge</option>
                            <option value="(Power) Bowrider">Bowrider</option>
                            <option value="(Power) Cargo Ship">Cargo Ship</option>
                            <option value="(Power) Center Console">Center Console</option>
                            <option value="(Power) Commercial Boat">Commercial Boat</option>
                            <option value="(Power) Convertible Boat">Convertible Boat</option>
                            <option value="(Power) Cruise Ship">Cruise Ship</option>
                            <option value="(Power) Cruiser">Cruiser</option>
                            <option value="(Power) Cuddy Cabin">Cuddy Cabin</option>
                            <option value="(Power) Dive Boat">Dive Boat</option>
                            <option value="(Power) Downeast">Downeast</option>
                            <option value="(Power) Dragger">Dragger</option>
                            <option value="(Power) Express Cruiser">Express Cruiser</option>
                            <option value="(Power) Flybridge">Flybridge</option>
                            <option value="(Power) Freshwater Fishing">Freshwater Fishing</option>
                            <option value="(Power) House Boat">House Boat</option>
                            <option value="(Power) Jet Boat">Jet Boat</option>
                            <option value="(Power) Lobster Boat">Lobster Boat</option>
                            <option value="(Power) Mega Yacht">Mega Yacht</option>
                            <option value="(Power) Motor Yacht">Motor Yacht</option>
                            <option value="(Power) Motorsailer">Motorsailer</option>
                            <option value="(Power) Passenger">Passenger</option>
                            <option value="(Power) Pontoon Boat">Pontoon Boat</option>
                            <option value="(Power) Pilothouse">Pilothouse</option>
                            <option value="(Power) Power Catamaran">Power Catamaran</option>
                            <option value="(Power) Racing/High Performance">Racing/High Performance</option>
                            <option value="(Power) Rigid Inflatable Boat (RIB)">Rigid Inflatable Boat (RIB)</option>
                            <option value="(Power) Saltwater Fishing">Saltwater Fishing</option>
                            <option value="(Power) Sport Fishing">Sport Fishing</option>
                            <option value="(Power) Sports Cruiser">Sports Cruiser</option>
                            <option value="(Power) Tender">Tender</option>
                            <option value="(Power) Trawler">Trawler</option>
                            <option value="(Power) Troller">Troller</option>
                            <option value="(Power) Tug">Tug</option>
                            <option value="(Power) Other">Other</option>
                            <option value=""> ----------------</option>
                            <option value="(Sail)">All Sail</option>
                            <option value="(Sail) Antique and Classic">Antique and Classic</option>
                            <option value="(Sail) Barge">Barge</option>
                            <option value="(Sail) Catamaran">Catamaran</option>
                            <option value="(Sail) Center Cockpit">Center Cockpit</option>
                            <option value="(Sail) Commercial Boat">Commercial Boat</option>
                            <option value="(Sail) Cruiser">Cruiser</option>
                            <option value="(Sail) Cruiser/Racer">Cruiser/Racer</option>
                            <option value="(Sail) Cutter">Cutter</option>
                            <option value="(Sail) Daysailer">Daysailer</option>
                            <option value="(Sail) Deck Saloon">Deck Saloon</option>
                            <option value="(Sail) Ketch">Ketch</option>
                            <option value="(Sail) Motorsailer">Motorsailer</option>
                            <option value="(Sail) Multi-Hull">Multi-Hull</option>
                            <option value="(Sail) Pilothouse">Pilothouse</option>
                            <option value="(Sail) Racing Sailboat">Racing Sailboat</option>
                            <option value="(Sail) Schooner">Schooner</option>
                            <option value="(Sail) Sloop">Sloop</option>
                            <option value="(Sail) Trimaran">Trimaran</option>
                            <option value="(Sail) Yawl">Yawl</option>
                            <option value="(Sail) Other">Other</option>
                            </select>
                        </div>
                            
                        <div style="width: 100%; display: inline-block;">
                            Condition:<br>
                            <select name="cond" style="width: 100%;">
                            <option value="">Any</option>
                            <option value="true">New</option>
                            <option value="false">Used</option>
                            </select>
                        </div>

                        <div class="search-table-div">
                            Length:<br>
                            <input type="text" name="minLn" value="" style="width: 100%;">
                        </div>
                        
                        <div style="width: 7%; max-width: 70px; font-size: 80%; text-align: center; padding: 6px; display: inline-block;">
                            &nbsp;<br>
                            to
                        </div>
                        
                        <div class="search-table-div" style="margin-right: 2%">
                            &nbsp;<br>
                            <input type="text" name="maxLn" value="" style="width: 100%;">
                        </div>
                    
                        <div class="search-table-div">
                            Price:<br>
                            <input type="text" name="minPr" value="" style="width: 100%;">
                        </div>
                        
                        <div style="width: 7%; max-width: 70px; font-size: 80%; text-align: center; padding: 6px; display: inline-block;">
                            &nbsp;<br>
                            to
                        </div>
                            
                        <div class="search-table-div">
                            &nbsp;<br>
                            <input type="text" name="maxPr" value="" style="width: 100%;">
                        </div>
                    
                        <div class="search-table-div">
                            Year:<br>
                            <input type="text" name="minYr" value="">
                        </div>
                        
                        <div style="width: 7%; max-width: 70px; font-size: 80%; text-align: center; padding: 6px; display: inline-block;">
                            &nbsp;<br>
                            to
                        </div>
                    
                        <div class="search-table-div" style="margin-right: 2%">
                            &nbsp;<br>
                            <input type="text" name="maxYr" value="" style="width: 100%;">
                        </div>
                        
                        <div class="search-table-button">
                            <input value="Search" class="search-form-button" type="submit">
                        </div>
                        
                    </div>
                    
                    </form>
                        
                </div>

            </div>

        </div>
        <!-- end yacht search box -->
        
        <!-- accordian function -->

        <script type="text/javascript">
            $(document).ready(function () {
                $('.accordion-toggle-bbs').on('click', function(event){
                    event.preventDefault();

                    var accordion = $(this);
                    var accordionContent = accordion.next('.accordion-content-bbs');
                    var accordionToggleIcon = $(this).children('.toggle-icon-pls');

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
        
        <!-- branded boat shopper box -->
        
        <div class="accordian-guts-bbs">
        
            <div class="accordion-container-bbs">
                
                <a href="#" class="accordion-toggle-bbs"><h3>Save Your Search</h3> <span class="toggle-icon-bbs"><i class="fa fa-plus"></i></span></a>
                
                <div class="accordion-content-bbs">

                    <div class="save-your-search-form">

                        <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; if(false == strpos($url,'&searched=true')){ ?>

                        <p>When you search for yachts you can sign up to have us automatically email you whenever a boat is added to our database that matches your search criteria.

                        <br>
                        <br>

                        Submit a search to activate the form.</p>

                        <?php } ?> 

                        <?
                        if($_GET['ywcn'] == "3"){
                        $trade_in_val = "3";
                        }
                        else{
                        $trade_in_val = "";
                        }
                        include("pbs/settings.php");
                        include("pbs/code.php");
                        ?>

                        <?
                        if ( !$_GET["rPage"] ) { //Only show this on "Boats search result" page
                        if ( $_POST["pbsposted"] && isValidEmail($_POST["email"]) ) { ?>

                        <?
                        // The actual place where we send PBS XML to LM !!!
                        $result = sendPbsData(LM_URL, composeXml($trade_in_val));
                        if($result['response'] == "OK: your message has been accepted."){
                        echo "<p>You have been added to our Personal Boat Shopper program. Whenever a boat is added or has a price change that matches your current search criteria you will receive an update via email.

                        <br>
                        <br>

                        Thank you for using Personal Boat Shopper and trusting us to help you find your next boat.</p>";
                        }
                        ?>

                        <? } else { ?>


                        <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; if(true == strpos($url,'&searched=true')){ ?>

                        <form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">

                        <div>
                            <p>Let us do the searching for you. Fill out and submit this form in order to have an email sent to you whenever boats matching your search criteria are added to our database. It is fast and easy. You can stop it at any time and subscribe to as many searches as you want.</p>
                        </div>

                        <? if ( $_POST["pbsposted"] && !isValidEmail($_POST["email"]) ) { ?>

                        <div class="required-star">Please enter valid email address!</div>

                        <? } ?>


                        <div class="search-form-div">
                            First Name:<br>
                            <input name="firstname" value="" type="text" value="<?=$_POST["firstname"]?>"><br>
                        </div>

                        <div class="search-form-div">
                            Last Name:<br>
                            <input name="lastname" value="" type="text" value="<?=$_POST["lastname"]?>"><br>
                        </div>

                        <div class="search-form-div">
                            Email Address:<span class="required-star">*</span><br>
                            <input name="email" value="" type="text" value="<?=$_POST["email"]?>"><br>
                        </div>

                        <div>
                            <input value="Submit" class="search-form-button" type="submit">
                        </div>
                        
                        <input type="hidden" name="pbsposted" value="true">

						</form>

						<? } } ?>

						<?php } ?>

						<!--****************  PBS CODE ENDS HERE *****************-->   
                        
					</div>
                
                </div>

            </div>
        
			<p>YOUR CURRENT SEARCH:</p>
        
			<?php include ('current-search.php'); ?>
        
			<!-- end branded boat shopper box -->
    
		</div>
        
	</section>

	<!-- main content area -->
    
	<section id="pls" class="two_thirds">
        
		<div class="PLSinventory-area">

			<?php include ('pls_top.php'); ?>
                    
			<?php include('pls_bottom.php'); ?>

		</div>

	</section>

	<!-- end main content area -->	

<!---------- end middle content ----------->

</section>

</div>

<?php get_footer(); ?>