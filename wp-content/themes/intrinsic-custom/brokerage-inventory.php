<?php 
//This document displays the search results
ini_set('max_execution_time', '120');

//Include configuration parameters
require("setup/config.php");

//Set number of results per page
$results_per_page=12;

//Enter file path to search results page
$searchurl = $rootdirectoryurl . "our-inventory/";

//Include database file
require("classes/db.class.php");
$db = new db();

$Query = "SELECT * FROM boatdetails WHERE BoatID > 0";

if (@$_GET['makemodel'] && $_GET['makemodel'] != ""){
	$WholeMakeModel = $db->sanitise($_GET['makemodel']);
	$MakeModels = explode(" ", $WholeMakeModel);
	foreach($MakeModels as $SearchMakeModel){
		$Query.= " AND MakeModel LIKE '%$SearchMakeModel%'";
	}	
}				
if (@$_GET['make'] && $_GET['make'] != ""){
	$SearchMake = $db->sanitise($_GET['make']);
	$Query.= " AND Make ='$SearchMake'";
}
if (@$_GET['class'] && $_GET['class'] != ""){
	$SearchClass = $db->sanitise($_GET['class']);
	$Query.= " AND Class ='$SearchClass'";
}
if (@$_GET["type"] && $_GET["type"] != ""){
	$SearchType = $db->sanitise($_GET["type"]);
	$Query.= " AND Category ='$SearchType'";
}
if (@$_GET["Fuel"] && $_GET["Fuel"] != ""){
	$SearchFuel = $db->sanitise($_GET["Fuel"]);
	$Query.= " AND Fuel ='$SearchFuel'";
}
if (@$_GET["HullMaterial"] && $_GET["HullMaterial"] != ""){
	$SearchHullMaterial = $db->sanitise($_GET["HullMaterial"]);
	$Query.= " AND HullMaterial ='$SearchHullMaterial'";
}
if (@$_GET["minprice"] && $_GET["minprice"] != ""){
	$SearchMinPrice = $db->sanitise($_GET["minprice"]);
	$Query.= " AND Price >='$SearchMinPrice'";
}
if (@$_GET["maxprice"] && $_GET["maxprice"] != ""){
	$SearchMaxPrice = $db->sanitise($_GET["maxprice"]);
	$Query.= " AND Price <='$SearchMaxPrice'";
}
if (@$_GET["minlength"] && $_GET["minlength"] != ""){
	$SearchMinLength = $db->sanitise($_GET["minlength"]);
	$Query.= " AND Length_ft >='$SearchMinLength'";
}
if (@$_GET["maxlength"] && $_GET["maxlength"] != ""){
	$SearchMaxLength = $db->sanitise($_GET["maxlength"]);
	$Query.= " AND Length_ft <='$SearchMaxLength'";
}
if (@$_GET["location"] && $_GET["location"] != ""){
	$SearchLocation = $db->sanitise($_GET["location"]);
	$Query.= " AND LocationCountry ='$SearchLocation'";
}
if (@$_GET["locationst"] && $_GET["locationst"] != ""){
	$SearchLocationst = $db->sanitise($_GET["locationst"]);
	$Query.= " AND LocationState ='$SearchLocationst'";
}
if (@$_GET["minyear"] && $_GET["minyear"] != ""){
	$SearchMinYear = $_GET["minyear"];
	$Query.= " AND Year >='$SearchMinYear'";
}
if (@$_GET["maxyear"] && $_GET["maxyear"] != ""){
	$SearchMaxYear = $_GET["maxyear"];
	$Query.= " AND Year <='$SearchMaxYear'";
}
if (@$_GET["newused"] && $_GET["newused"] != ""){
	$SearchNewUsed = $db->sanitise($_GET["newused"]);
	$Query.= " AND NewUsed ='$SearchNewUsed'";
}
if (@$_GET["sort"] && $_GET["sort"] != ""){
	$SortListings = $_GET["sort"];
	if ($SortListings == "lengthdesc"){ $SortListings = "Length_ft DESC"; }
	if ($SortListings == "lengthasc"){ $SortListings = "Length_ft ASC"; }
	if ($SortListings == "pricedesc"){ $SortListings = "Price DESC"; }
	if ($SortListings == "priceasc"){ $SortListings = "Price ASC"; }
	if ($SortListings == "yeardesc"){ $SortListings = "Year DESC"; }
	if ($SortListings == "yearasc"){ $SortListings = "Year ASC"; }
	if ($SortListings == "makedesc"){ $SortListings = "Make DESC"; }
	if ($SortListings == "makeasc"){ $SortListings = "Make ASC"; }
	$Query.= " ORDER BY $SortListings";
	} else {
	$Query.= " ORDER BY Length_ft DESC";
	} 

?>

<!---------- middle content ----------->

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>

	<div id="top-search" class="sidebar-search">
            
		<!-- accordian function -->
    
		<script type="text/javascript">
            $(document).ready(function () {
                $('.accordion-toggle-xml-listings').on('click', function(event){
                    event.preventDefault();

                    var accordion = $(this);
                    var accordionContent = accordion.next('.xml-search-form-container');
                    var accordionToggleIcon = $(this).children('.toggle-icon-xml-listings');

                    accordion.toggleClass("open");

                    accordionContent.slideToggle(250);

                    if (accordion.hasClass("open")) {
                        accordionToggleIcon.html("<i class='fa fa-plus'></i>");
                    } else {
                        accordionToggleIcon.html("<i class='fa fa-minus'></i>");
                    }
                });
            });
        </script>
    
		<!-- end accordian function -->
        
		<!-- START SEARCH FORM -->
          
		<div class="accordian-guts-xml-listings">
			<div class="accordion-container-xml-listings">
				<a href="#" class="accordion-toggle-xml-listings"><h3>SEARCH BOATS FOR SALE</h4> <span class="toggle-icon-xml-listings"><i class="fa fa-minus"></i></span></a>
				<div class="xml-search-form-container">
					
					<form name="sortandfilter" class="xml-search-form" action="<?php echo $searchurl;?>" method="get">
                      
					<div class="option-row">
    
						<div class="option">
                        	Type<br>
							<select name="type" id="Type">
							<?php if (!$_GET['type'] || $_GET['type'] == ""){?>
                            <option value="" selected="selected">All Boat Types</option>
                            <? } else { ?>
                            <option value="">All Boat Types</option>
                            <? }
                            $Querysearch = "SELECT DISTINCT Category FROM boatdetails ORDER BY Category";
                            $result = $db->db_query($Querysearch);
                                while ( $row = $db->db_rs( $result ) ) {
                            $SearchType = $row["Category"];
                            if ($_GET['type'] == $SearchType){
                                echo "<option value=\"" . $SearchType . "\" selected=\"selected\">" . $SearchType . "</option>";
                            } else if ($SearchType != ""){	 
                                echo "<option value=\"" . $SearchType . "\">" . $SearchType . "</option>";
                                }
                            }?>
                            </select>
						</div>
                        
                        <div class="option">
                            Make/Model<br>
                            <?php if (@$_GET['makemodel']){
                                echo "<input style=\"width: 100%;\" name=\"makemodel\" type=\"text\" value=\"" . $_GET['makemodel'] . "\"/>&nbsp;&nbsp;";
                            } else {
                                echo "<input style=\"width: 100%;\" name=\"makemodel\" type=\"text\"/>&nbsp;&nbsp;";
                            }?>
                        </div>
                        
                    </div>
						
                    <div class="option-group">
                        <div class="option">
                            Min Price ($)<br>
                            <?php if (@$_GET['minprice']){ 
							echo "<input name=\"minprice\" type=\"text\" value=\"" . $_GET['minprice'] . "\"/>&nbsp;&nbsp;";
							} else {
							echo "<input name=\"minprice\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
                            
                        <div class="to">To</div>
                            
                        <div class="option">
							Max Price ($)<br>
                            <?php if (@$_GET['maxprice']){ 
								echo "<input name=\"maxprice\" type=\"text\" value=\"" . $_GET['maxprice'] . "\"/>&nbsp;&nbsp;";
							} else {
								echo "<input name=\"maxprice\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
    
                    </div>
        
                    <div class="option-group">
                        <div class="option">
                            Min Year<br>
                            <?php if (@$_GET['minyear']){ 
								echo "<input name=\"minyear\" type=\"text\" value=\"" . $_GET['minyear'] . "\"/>&nbsp;&nbsp;";
							} else {
								echo "<input name=\"minyear\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
    
                        <div class="to">To</div>
    
                        <div class="option">
                            Max Year<br>
                            <?php if (@$_GET['maxyear']){ 
								echo "<input name=\"maxyear\" type=\"text\" value=\"" . $_GET['maxyear'] . "\"/>&nbsp;&nbsp;";
							} else {
								echo "<input name=\"maxyear\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
    
                    </div>
        
                    <div class="option-group">
                        
                        <div class="option">
                            Min Length (ft)<br>
                            <?php if (@$_GET['minlength']){ 
								echo "<input name=\"minlength\" type=\"text\" value=\"" . $_GET['minlength'] . "\"/>&nbsp;&nbsp;";
							} else {
								echo "<input name=\"minlength\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
                    
                        <div class="to">To</div>
                     
                        <div class="option">
                            Max Length (ft)<br>
                            <?php if (@$_GET['maxlength']){ 
								echo "<input name=\"maxlength\" type=\"text\" value=\"" . $_GET['maxlength'] . "\"/>&nbsp;&nbsp;";
							} else {
								echo "<input name=\"maxlength\" type=\"text\"/>&nbsp;&nbsp;";
							}?>
                        </div>
                            
                    </div>
                        
                    <div class="option-group">
                        <center><input type="submit" class="button" name="SimpleSearch" value="Search" id="search-btn"></center>
                    </div>
                        
					<!-- END SEARCH FORM -->

				</div>
                
			</div>
                
		</div>

        <div id="boat-content">
	
			<!-- START PAGE NUMBERS -->
		
            <div id="page-numbers">				
                <?php					
                $result=$db->db_query($Query);
                $all_result=$db->db_rows($result);
                        
                // calculate total number of pages needed
                $pages=ceil($all_result/$results_per_page);
                        
                if (isset($_GET['page'])){
                    $offset=$results_per_page*($_GET['page']-1);
                }else{
                    $offset=0;
                }
                        
                $Query.= " LIMIT $offset, $results_per_page";
                        
                $get_first_result=$db->db_query($Query);
				
                // list page navgation ([1] 2 3 4 5)
                    echo $all_result . " Results found..." ;
                    $page=1;
                            
                    if (isset($_GET['page'])){
                        $currentpage = $_GET['page'];
                    }else{
                        $currentpage = 1;
                    }
                            
                    if ($currentpage != 1){
                        $previous = $currentpage - 1;
                        echo " <a href=\"javascript:goTo(".$previous.");\">&lt;&lt;</a>&nbsp;";
                    }
                            
                    while($pages) {
                        if ($page==$currentpage) {
                            echo " <a href=\"javascript:goTo(".$page.");\"><b>[".$page."]</b></a>&nbsp;\n";
                        } else {
                            echo " <a href=\"javascript:goTo(".$page.");\">".$page."</a>&nbsp;\n";
                        }
                        $pages--;
                        $page++;
                    }
    
                    $lastpage=ceil($all_result/$results_per_page);
                    
                    if ($currentpage != $lastpage){
                        $next = $currentpage + 1;
                        echo "<a href=\"javascript:goTo(".$next.");\">&gt;&gt;</a>&nbsp;";
                    }
    
                ?>
                <div id="sort">
                    Sort By: 
                    <select name="sort" onchange="Javascript:document.sortandfilter.submit()">
                    <option value="lengthdesc" <?php if (@$_GET['sort'] == "lengthdesc") { echo "selected=\"selected\"";}?>>Length (high to low)</option>
                    <option value="lengthasc" <?php if (@$_GET['sort'] == "lengthasc") { echo "selected=\"selected\"";}?>>Length (low to high)</option>
                    <option value="pricedesc" <?php if (@$_GET['sort'] == "pricedesc") { echo "selected=\"selected\"";}?>>Price (high to low)</option>
                    <option value="priceasc" <?php if (@$_GET['sort'] == "priceasc") { echo "selected=\"selected\"";}?>>Price (low to high)</option>		
                    <option value="yeardesc" <?php if (@$_GET['sort'] == "yeardesc") { echo "selected=\"selected\"";}?>>Year (newer to older)</option>
                    <option value="yearasc" <?php if (@$_GET['sort'] == "yearasc") { echo "selected=\"selected\"";}?>>Year (older to newer)</option>
                    <option value="makedesc" <?php if (@$_GET['sort'] == "makedesc") { echo "selected=\"selected\"";}?>>Make (Z to A)</option>
                    <option value="makeasc" <?php if (@$_GET['sort'] == "makeasc") { echo "selected=\"selected\"";}?>>Make (A to Z)</option>
                    </select>
                </div>
        
            </div>
			
            <!-- END PAGE NUMBERS -->
        
            </form>
			
            <!-- START BOATS RESULTS -->
            
			<div id="search-results">

				<ul class="search-result search-result-details">
                
				<?php if ($all_result < 1){ 
				echo "<li style=\"line-height:20px\">There are no boats in our database that match your search today, however if you contact us and let us know what you are looking for, we would be glad to help.</li>";
				} else { 
				$data_p = $db->db_query($Query); 
				while($info = $db->db_rs($data_p)) { 
					echo "<li class=\"hproduct\">";
					echo "<a href=\"" . $rootdirectoryurl . "boat-details/?BoatID=" . $info['BoatID'] . "\">"; 
					
				//Grab first image from listing
				$id = $info['BoatID'];
				$Queryboat = "SELECT * FROM images WHERE BoatID=$id ORDER BY ImageRanking LIMIT 0, 1";
				$imagedata = $db->db_query($Queryboat); 
				while($image = $db->db_rs($imagedata)) {
					echo "<img src=\"" . $image['ImageURL'] . "\" alt=\"" . $info['Make'] . " " . $info['Model'] . "\"></a><br/>";
				} 
					
				//Create H2 tag with Make and Model
				echo "<h2><a href=\"" . $rootdirectoryurl . "boat-details/?BoatID=" . $info['BoatID'] . "\"><span class=\"brand\">" . $info['Make'] . "</span> <span class=\"fn\">" .$info['Model'] . "</span></a></h2>";
					
				//Print Boat Details
				echo "<div id=\"details\">";
				echo "<p>Length: " . $info['Length_ft'] . "ft / " . $info['Length_mt'] . "m<br/>";
				echo "Year: " . $info['Year']. "<br/>";
				
				//Replace currency letters with the correct sign and print price
				if (@$_GET["currency"] && $_GET["currency"] != $info['PriceCurrency']){
					$fromcurrency = $info['PriceCurrency'];
					$tocurrency = $_GET['currency'];
					$price = $info['Price'];
					$Price = number_format($db->currency($fromcurrency,$tocurrency,$price));
					$PriceCurrency=$tocurrency;
					$PriceCurrency=str_replace("GBP","&pound;",$PriceCurrency);
					$PriceCurrency=str_replace("USD","&#36;",$PriceCurrency);
					$PriceCurrency=str_replace("AUD","AUD &#36;",$PriceCurrency); 
					$PriceCurrency=str_replace("NZD","NZD &#36;",$PriceCurrency); 
					$PriceCurrency=str_replace("EUR","&#8364;",$PriceCurrency);
					} else {
					$Price = number_format($info['Price']);
					$PriceCurrency=$info['PriceCurrency'];								
					$PriceCurrency=str_replace("GBP","&pound;",$PriceCurrency);
					$PriceCurrency=str_replace("USD","&#36;",$PriceCurrency);
					$PriceCurrency=str_replace("AUD","AUD &#36;",$PriceCurrency); 
					$PriceCurrency=str_replace("NZD","NZD &#36;",$PriceCurrency); 
					$PriceCurrency=str_replace("EUR","&#8364;",$PriceCurrency);
					} echo "Price: <span class=\"boatprice\">" ;
				if ($info['Price'] != "1" && $info['Price'] != "0"  && $info['PriceHide'] != "true"){ echo  "<span class=\"boatprice\">" . $PriceCurrency . $Price; 
					} else { echo "Contact us for price"; }
						
				//Generate Tax Status
				if ($info['TaxStatus'] == "Not Paid"){
					echo " ex Vat";
				} else if  ($info['TaxStatus'] == "Paid"){
					echo " inc Vat";
				}
				echo "</span><br/>";
							
				//Generate Location and View specs button
				if ($info['LocationCity'] != "Unknown"){
				echo "Location: " . $info['LocationCity'] . " " . $info[ 'LocationState'] . ", ";
					} else {
				echo "Location: ";	
					}			
				echo $info['LocationCountry'] . "<br/></p>";
				echo "</div>";
				echo "<div class=\"view-button\"><a href=\"" . $rootdirectoryurl . "boat-details/?BoatID=" . $info['BoatID'] . "\" title=\"" .$info['Make'] . " " . $info['Model'] . " for sale\">View Details</a></div>";
				echo "</li>";
				}
				}?>
				</ul>
                			
			</div>
            
			<!-- END BOAT RESULTS -->
            
			<!-- START PAGE NUMBERS -->
            
			<div id="page-numbers">				
				<?php					
				// list page navgation ([1] 2 3 4 5)
				$bottompages=ceil($all_result/$results_per_page);
					
				echo $all_result . " results found... ";
				$bottompage=1;
					    
				if (isset($_GET['page'])){
					$bottomcurrentpage = $_GET['page'];
				}else{
					$bottomcurrentpage = 1;
				}

				if ($bottomcurrentpage != 1){
					$bottomprevious = $bottomcurrentpage - 1;
					echo "<a href=\"javascript:goTo(".$bottomprevious.");\">&lt;&lt;</a>&nbsp;";
				}
					    
				while($bottompages) {
					if ($bottompage==$bottomcurrentpage) {
						echo "<a href=\"javascript:goTo(".$bottompage.");\"><b>[".$bottompage."]</b></a>&nbsp;\n";
					} else {
					    echo "<a href=\"javascript:goTo(".$bottompage.");\">".$bottompage."</a>&nbsp;\n";
					}
					$bottompages--;
					$bottompage++;
				}
				
				$lastpage=ceil($all_result/$results_per_page);
				
				if ($bottomcurrentpage != $lastpage){
					$bottomnext = $bottomcurrentpage + 1;
					echo "<a href=\"javascript:goTo(".$bottomnext.");\">&gt;&gt;</a>&nbsp;";
				}

				?>

			</div>

			<!-- END PAGE NUMBERS -->

		</div>

	</div>

</div>
