<?php

//Include configuration parameters
require("setup/config.php");

//This document controls the PDF full specifications print out, the only section you should need to change is the footer setup found on line 169
	ini_set('max_execution_time', '1200');

	define('FPDF_FONTPATH','scripts/font/');
	require 'scripts/fpdf.php';
	require("classes/db.class.php");
	$db = new db();
	
	//Include details php file
	require("includes/get-details.php");
	
	//Include countries php file
	require("includes/countries.php");




	define('A4WIDTH', 210);
	define('A4HEIGHT', 297);
	define('MARGIN', 5);
	define('TITLE_MARGIN', 7);
	
	define('PAGE_BORDER_WIDTH', A4WIDTH - (2 * MARGIN));
	define('HEAD_BORDER_PADDING', 35);
	define('PAGE_BORDER_LENGTH', 276 - HEAD_BORDER_PADDING);

	define('FOOT_BORDER_PADDING', A4HEIGHT - HEAD_BORDER_PADDING - PAGE_BORDER_LENGTH);
	define('FOOTER_CELL_HEIGHT', A4HEIGHT - (HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH + MARGIN + MARGIN));
	
	
	define('CONTENT_WIDTH', PAGE_BORDER_WIDTH - (2 * TITLE_MARGIN));
	
	define('MAX_IMAGE_WIDTH', CONTENT_WIDTH);
	define('MAX_IMAGE_HEIGHT', 125);
	
	
	define('INTRO_WIDTH', 90);
	define('INTRO1_WIDTH', 90);
	define('INTRO2_WIDTH', 90);
	define('INTRO_HEIGHT', 11);
	define('INTRO_TEXT', 4);
	
	define('OVERVIEW_TEXT', 5);
	
	define ('COLUMN_MARGIN', 2);
	define('COLUMN_WIDTH', (CONTENT_WIDTH / 1) - (1 * COLUMN_MARGIN));
	define('COLUMN_HEIGHT', 4);
	
	define('MAX_ATTACHMENT_HEIGHT', 59);
	define('MAX_ATTACHMENT_WIDTH', 86);
	define('ATTACHMENT_TEXT', 7);
	
	define('EURO', chr(128));
	define('POUND', chr(163));
	define('BULLET', chr(149));
	define('ANDSIGN', chr(38));
	
	class pdffullspecs extends FPDF {
		
		public $boat = array();
		var $column_mode = 0;
		var $column_start = 0;
		var $col = 0;
		
		function SetBoat ($boathash) {
			$this->boat = $boathash;
		}
		
		// changes the auto page break
		function SetColumnMode ($mode = 1)
		{
			$this->column_mode = $mode;
			if ($mode == 1)
			{
				$this->column_start = $this->GetY();
				$this->SetCol(0);
			}	
			else {
				$x = MARGIN + TITLE_MARGIN;
				$this->SetLeftMargin($x);
				$this->SetX($x);
			}
		}
		
		function SetCol($col)
		{
			//Set position at a given column
			$this->col = $col;
			$x = MARGIN + TITLE_MARGIN + COLUMN_MARGIN + ($col * (COLUMN_MARGIN + COLUMN_WIDTH + COLUMN_MARGIN));
			$this->SetLeftMargin($x);
			$this->SetX($x);
		}
		
		function AcceptPageBreak()
		{
			if ($this->column_mode == 1)
			{
				//Method accepting or not automatic page break
				if($this->col < 1)
				{
					//Go to next column
					$this->SetCol($this->col + 1);
					//Set ordinate to top
					//$this->SetY($this->y0);
					$this->SetY($this->column_start);
					//Keep on page
					return false;
				}
				else
				{
					$this->SetCol(0);
					//Page break
					return true;
				}
			}
			else {
				return true;
			}
		}
		
		function AddPage($explicitly_invoked = 0) {
			parent::AddPage();
			if ($explicitly_invoked == 0) {				$this->SetXY(MARGIN + TITLE_MARGIN, HEAD_BORDER_PADDING);
			}
		}
		
		function AddPageExplicit()
		{
			$this->AddPage(1);
		}
		
		//Page header
		function Header()
		{
		    //Logo
			$this->Ln(10);
		    $this->Image('logo.jpg', 150, 10, 50, 20); 
			$this->SetFont('verdana','', 15);
		    $this->Border();

		    if ($this->column_mode == 1)	{
				$this->Title("TECHNICAL SPECIFICATION AND INVENTORY");
		    	$this->SetY($this->column_start);
		    }
		}
		
		function Title ($line1 = "", $line2 = "")
		{
			$this->SetTextColor(0,0,0);
			$this->SetFont('verdana','',16);
			$this->SetXY(MARGIN + TITLE_MARGIN, HEAD_BORDER_PADDING + TITLE_MARGIN);
			$this->Cell(CONTENT_WIDTH, TITLE_MARGIN, $line1, 0, 1, "L");
			$this->Cell(CONTENT_WIDTH, TITLE_MARGIN,  $line2 , 0, 1, "L");
			$this->Line(MARGIN + TITLE_MARGIN, HEAD_BORDER_PADDING + TITLE_MARGIN, MARGIN + PAGE_BORDER_WIDTH - TITLE_MARGIN, HEAD_BORDER_PADDING + TITLE_MARGIN);
			$this->Line(MARGIN + TITLE_MARGIN, HEAD_BORDER_PADDING + TITLE_MARGIN + TITLE_MARGIN, MARGIN + PAGE_BORDER_WIDTH - TITLE_MARGIN, HEAD_BORDER_PADDING + TITLE_MARGIN + TITLE_MARGIN);
			
		}
		
		function Border() 
		{
			//top line
			$this->Line(MARGIN, HEAD_BORDER_PADDING, MARGIN + PAGE_BORDER_WIDTH, HEAD_BORDER_PADDING);
			//left line
			$this->Line(MARGIN, HEAD_BORDER_PADDING, MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH);
			//right line
			$this->Line(MARGIN + PAGE_BORDER_WIDTH, HEAD_BORDER_PADDING, MARGIN + PAGE_BORDER_WIDTH, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH);
			//bottom line
			$this->Line(MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH, MARGIN + PAGE_BORDER_WIDTH, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH);
		}
		
		function Footer()
		{
			
			$this->BrokerPnumber = strip_tags($this->boat['BrokerPnumber']);
			$this->BrokerTel = strip_tags($this->boat['BrokerTel']);
			$this->BrokerEmail = strip_tags($this->boat['BrokerEmail']);
			$this->BrokerName = strip_tags($this->boat['BrokerName']);
			$this->SetFillColor(6,62,111);
			$this->Rect(MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH + MARGIN, PAGE_BORDER_WIDTH, FOOTER_CELL_HEIGHT, "F");
			$this->SetFont('helvetica', '', 6);
			$this->SetTextColor(255,255,255);
			$this->SetXY(MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH + MARGIN + FOOTER_CELL_HEIGHT / 4);
						
			$this->Cell(200, 3, "$this->BrokerName", 0, 1, "C");		
			$this->SetX(MARGIN);			
			$this->Cell(200, 3,"$this->BrokerEmail" . " - " . "$this->BrokerTel" , 0, 1, "C");		
			$this->SetX(MARGIN);			
		}
		
	}
if ($boat['Price'] == 1) {
   $boat['Price'] = 'Call for price';
}
	if ($boat['Price'] == 0) {
   $boat['Price'] = 'Call for price';
}
if ($boat['Price'] == 1) {
   $boat['PriceCurrency'] = '';
}
	if ($boat['Price'] == 0) {
   $boat['PriceCurrency'] = '';
}	
	$pdf = new pdffullspecs('P','mm','A4');
	$pdf->SetDrawColor(153,153,153);
	$pdf->SetBoat($boat);
	$pdf->AddFont('Verdana', '', 'verdana.php');
	$pdf->AddFont('Verdana-Bold', '', 'verdanab.php');
	$pdf->SetMargins(MARGIN + TITLE_MARGIN, 0, MARGIN + TITLE_MARGIN);
	$pdf->SetTitle($boat['Year'] . " " . $boat['Make'] . " " . $boat['Model'] . " - " . $boat['PriceCurrency'] . " " . $boat['Price']);

	$pdf->AddPageExplicit();

	$pdf->SetTextColor(0,0,0);
		
	//create title
	$pdf->Title($boat['Make'] . " " . $boat['Model']);
	$pdf->Cell(CONTENT_WIDTH, 4, "Price: " . $boat['PriceCurrency'] . $boat['Price'], 0, 0, "L");
	$pdf->Ln(TITLE_MARGIN);
	
	
	// print main image
	$Queryboat = "SELECT * FROM images WHERE BoatID=$id ORDER BY ImageRanking LIMIT 0, 1";
	$imagedata = $db->db_query($Queryboat); 
	while($image = $db->db_rs($imagedata)) {


	list($width, $height) = getimagesize($image['ImageURL']);
	$height_ratio = MAX_IMAGE_HEIGHT / $height;
	$width_ratio = MAX_IMAGE_WIDTH / $width; 
	
	$scale = ($width_ratio < $height_ratio) ? $width_ratio : $height_ratio;

	$image_height = $height * $scale;
	$image_width  = $width  * $scale;
	
	$x_offset = (CONTENT_WIDTH - $image_width) / 2;
	
	$pdf->Image($image['ImageURL'], $x_offset + MARGIN + TITLE_MARGIN, null, $image_width, $image_height);
	
	}
	
	// Print out the introduction
	$pdf->Cell(INTRO1_WIDTH, INTRO_HEIGHT,  "" , 0, 0, "L");
	$pdf->Cell(INTRO2_WIDTH - INTRO1_WIDTH, INTRO_HEIGHT,  "" , 0, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$secondColumnX = $pdf->GetX() + INTRO1_WIDTH;
	$secondColumnY = $pdf->GetY();
	// Print out the overview
	$pdf->SetFont('helvetica','B',9);
	define('OVERVIEW_LABEL', 32);
	
	$pdf->SetFont('helvetica','B',9);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Builder/Designer", 10, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Year:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Year'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Builder:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Builder'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Designer:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Designer'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Construction:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['HullMaterial'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
	$pdf->SetFont('helvetica','B',9);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Engine", 0, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "No. of Engines:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineNo'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Make:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineMake'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Model:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineModel'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Year:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineYear'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Fuel Type:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineFuel'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Hours:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['EngineHours'], 0, 1, "L");
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Propeller Type:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $engine['PropellerType'], 0, 1, "L");

	// Print out the overview
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetXY($secondColumnX, $secondColumnY);
	switch ($boat['PriceCurrency']) {
		case "EUR":
			$currency = EURO;
			break;
		case "GBP":
			$currency = POUND;
			break;
		default:
			$currency = $boat['PriceCurrency'];
	}
	$pdf->SetFont('helvetica','B',9);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Dimensions", 10, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Length:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Length'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Beam:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Beam'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Min Draft:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['MinDraft'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Max Draft:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['MaxDraft'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Displacement:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Displacement'] . " " . $boat['DisplacementUnit'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Ballast:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['Ballast'] . " " . $boat['BallastUnit'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
	$pdf->SetFont('helvetica','B',9);
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Tanks", 0, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Water:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['WaterTankNo'] . " x " . $boat['WaterTankCap'] . " " . $boat['WaterTankCapUnit'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Fuel:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['FuelTankNo'] . " x " . $boat['FuelTankCap'] . " " . $boat['FuelTankCapUnit'], 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Holding:");
	$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['HoldingTankNo'] . " x " . $boat['HoldingTankCap'] . " " . $boat['HoldingTankCapUnit'], 0, 1, "L");
	$pdf->SetFont('helvetica','B',9);
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Location", 0, 1, "L");
	$pdf->SetFont('helvetica','',9);
	$pdf->SetX($secondColumnX);
	$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, $boat['LocationCity'] . ", " . $boat['LocationCountry'], 0, 1, "L");

	/* 
	 * SECOND PAGE!
	 */
	$pdf->AddPageExplicit();
	
	$pdf->Title("SPECIFICATION AND INVENTORY");

	$pdf->SetColumnMode(0);
	
	$pdf->SetFont('Verdana','',8);
	$bull = BULLET;
	$boat['Description'] = utf8_decode($boat['Description']);
		$boat['Description'] = preg_replace("/(\<lis*\/?\>){1,2}/","\n $bull ", $boat['Description']);
		$boat['Description'] = preg_replace("/(\<br\s*\/?\>){1,2}/","\n", $boat['Description']);
		$boat['Description'] = preg_replace("/\&amp;/",chr(38), $boat['Description']);
		$boat['Description'] = preg_replace("/\&nbsp;/"," ", $boat['Description']);
		$boat['Description'] = preg_replace("/\&bull;/",chr(149), $boat['Description']);
		$boat['Description'] = preg_replace("/\&rdquo;/",chr(34), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ldquo;/",chr(34), $boat['Description']);
		$boat['Description'] = preg_replace("/\&euro;/",chr(128), $boat['Description']);
		$boat['Description'] = preg_replace("/\&pound;/",chr(163), $boat['Description']);
		$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);	
		$boat['Description'] = preg_replace("/\&Agrave;/",chr(192), $boat['Description']);
		$boat['Description'] = preg_replace("/\&agrave;/",chr(192), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Aacute;/",chr(193), $boat['Description']);
		$boat['Description'] = preg_replace("/\&aacute;/",chr(193), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Acirc;/",chr(194), $boat['Description']);
		$boat['Description'] = preg_replace("/\&acirc;/",chr(194), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Atilde;/",chr(195), $boat['Description']);
		$boat['Description'] = preg_replace("/\&atilde;/",chr(195), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Egrave;/",chr(200), $boat['Description']);
		$boat['Description'] = preg_replace("/\&egrave;/",chr(200), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Eacute;/",chr(201), $boat['Description']);
		$boat['Description'] = preg_replace("/\&eacute;/",chr(201), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Ecirc;/",chr(202), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ecirc;/",chr(202), $boat['Description']);
		$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);
		$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);
		$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);
		$boat['Description'] = preg_replace("/\&macr;/",chr(175), $boat['Description']);
		$boat['Description'] = preg_replace("/\&frac12;/",chr(189), $boat['Description']);
		$boat['Description'] = preg_replace("/\&rsquo;/",chr(39), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ndash;/",chr(45), $boat['Description']);

	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strip_tags($boat['Description']), 0, "L");
	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");
			
	$Query = "SELECT * FROM descriptions WHERE BoatID=$id";
	$textdata = $db->db_query($Query); 
	while($text = $db->db_rs( $textdata )) {
	
		$pdf->SetFont('Verdana-Bold','',8);
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strtoupper(strip_tags($text['AddTitle'])), 0, "L");
		$pdf->SetFont('Verdana','',8);
		$bull = BULLET;
		$text['AddDescription'] = utf8_decode($text['AddDescription']);
		$text['AddDescription'] = preg_replace("/(\<lis*\/?\>){1,2}/","\n $bull ", $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/(\<br\s*\/?\>){1,2}/","\n", $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&amp;/",chr(38), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&nbsp;/"," ", $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&bull;/",chr(149), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&rdquo;/",chr(34), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&ldquo;/",chr(34), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&euro;/",chr(128), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&pound;/",chr(163), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&iquest;/",chr(191), $text['AddDescription']);	
		$text['AddDescription'] = preg_replace("/\&Agrave;/",chr(192), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&agrave;/",chr(192), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Aacute;/",chr(193), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&aacute;/",chr(193), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Acirc;/",chr(194), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&acirc;/",chr(194), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Atilde;/",chr(195), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&atilde;/",chr(195), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Egrave;/",chr(200), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&egrave;/",chr(200), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Eacute;/",chr(201), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&eacute;/",chr(201), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&Ecirc;/",chr(202), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&ecirc;/",chr(202), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&iquest;/",chr(191), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&iquest;/",chr(191), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&iquest;/",chr(191), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&macr;/",chr(175), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&frac12;/",chr(189), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&rsquo;/",chr(39), $text['AddDescription']);
		$text['AddDescription'] = preg_replace("/\&ndash;/",chr(45), $text['AddDescription']);
		
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strip_tags($text['AddDescription']), 0, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");
	}
	
	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");
	
	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strip_tags($boat['SalesMessage']), 0, "L");

	$name = $boat['Make'] . $boat['Model'] . ".pdf";

	$pdf->Output($name, 'D');
	
	?>