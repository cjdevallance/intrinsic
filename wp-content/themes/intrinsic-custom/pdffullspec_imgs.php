<?php
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
	define('MAX_IMAGE_HEIGHT', 200);
	
	
	define('INTRO_WIDTH', 90);
	define('INTRO1_WIDTH', 90);
	define('INTRO2_WIDTH', 90);
	define('INTRO_HEIGHT', 11);
	define('INTRO_TEXT', 4);
	
	define('OVERVIEW_TEXT', 5);
	define('OVERVIEW_LABEL', 45);

	
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
		    $this->Image('logo.jpg', 130, 5, 65,35); 
			$this->SetFont('verdana','', 15);

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
		
			
		function Footer ()
		{
			
			//$this->Year = trim($this->boat['Year']);
			$this->SetFillColor(255,255,255);
			$this->Rect(MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH + MARGIN, PAGE_BORDER_WIDTH, FOOTER_CELL_HEIGHT, "F");
			$this->SetFont('helvetica', '', 8);
			$this->SetTextColor(0,0,0);
			$this->SetXY(MARGIN, HEAD_BORDER_PADDING + PAGE_BORDER_LENGTH + MARGIN + FOOTER_CELL_HEIGHT / 10);
			$this->Cell(200, 3, /*$this->Year*/"Sailing Machines" , 0, 1, "C");		
			$this->SetX(MARGIN);
			$this->Cell(200, 3, "Tel:  (888)855-9511, Email: dprince@sailingmachines.com", 0, 1, "C");
			$this->SetX(MARGIN);			
			$this->Cell(200, 3, "sailingmachines.com" , 0, 1, "C");		
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
	
	switch ($boat['PriceCurrency']) {
		case "&euro;":
			$currency = EURO;
			break;
		case "&pound;":
			$currency = POUND;
			break;
		default:
			$currency = $boat['PriceCurrency'];
	}
		
	//create title
	$pdf->SetFont('helvetica','B',14);
	$pdf->Title($boat['Make'] . " " . $boat['Model']);
	$pdf->SetFont('helvetica','',13);
	$pdf->Cell(CONTENT_WIDTH, 4, "Price: " . $currency . $boat['Price'], 0, 0, "L");
	$pdf->Ln(TITLE_MARGIN);
	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n\n", 0, "L");
	
	
	// print main image
	$Queryboat = "SELECT * FROM images WHERE BoatID=$id ORDER BY ImageRanking";
	$imagedata = $db->db_query($Queryboat);
	while($image = $db->db_rs($imagedata)) {

		list($width, $height) = getimagesize($image['ImageURL']);
		$height_ratio = MAX_IMAGE_HEIGHT / $height;
		$width_ratio = MAX_IMAGE_WIDTH / $width; 
		
		$scale = ($width_ratio < $height_ratio) ? $width_ratio : $height_ratio;
	
		$image_height = $height * $scale;
		$image_width  = $width  * $scale;
		
		$x_offset = (CONTENT_WIDTH - $image_width) / 4;
		
		$pdf->Image($image['ImageURL'], $x_offset + MARGIN + TITLE_MARGIN, null, $image_width, $image_height);
		break; //Only output the first image at this point
	}
	
	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");
	// Print out the introduction
	
		$pdf->SetFont('Verdana-Bold','',9);
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strtoupper(strip_tags($text['AddTitle'])), 0, "L");
			$pdf->SetFont('Verdana','',9);
			$bull = BULLET;
			$boat['Description'] = utf8_decode($boat['Description']);
			$boat['Description'] = preg_replace("/(\<li\s*\/?\>){1,2}/","\n $bull ", $boat['Description']);
			$boat['Description'] = preg_replace("/(\<br\s*\/?\>){1,2}/","\n", $boat['Description']);
			$boat['Description'] = preg_replace("/(\<p\s*\/?\>){1,2}/","", $boat['Description']);
			$boat['Description'] = preg_replace("/(\<\/p\s*\>){1,2}/","\n", $boat['Description']);
			$boat['Description'] = preg_replace("/\&amp;/",chr(38), $boat['Description']);
			$boat['Description'] = preg_replace("/\&nbsp;/"," ", $boat['Description']);
			$boat['Description'] = preg_replace("/\&bull;/",chr(149), $boat['Description']);
			$boat['Description'] = preg_replace("/\&rdquo;/",chr(34), $boat['Description']);
			$boat['Description'] = preg_replace("/\&ldquo;/",chr(34), $boat['Description']);
			$boat['Description'] = preg_replace("/\&euro;/",chr(128), $boat['Description']);
			$boat['Description'] = preg_replace("/\&pound;/",chr(163), $boat['Description']);
			$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);	
			$boat['Description'] = preg_replace("/\&Agrave;/",chr(192), $boat['Description']);
			$boat['Description'] = preg_replace("/\&agrave;/",chr(224), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Aacute;/",chr(193), $boat['Description']);
			$boat['Description'] = preg_replace("/\&aacute;/",chr(225), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Acirc;/",chr(194), $boat['Description']);
			$boat['Description'] = preg_replace("/\&acirc;/",chr(226), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Atilde;/",chr(195), $boat['Description']);
			$boat['Description'] = preg_replace("/\&atilde;/",chr(227), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Ccedil;/",chr(199), $boat['Description']);
			$boat['Description'] = preg_replace("/\&ccedil;/",chr(231), $boat['Description']);			
			$boat['Description'] = preg_replace("/\&Egrave;/",chr(200), $boat['Description']);
			$boat['Description'] = preg_replace("/\&egrave;/",chr(232), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Eacute;/",chr(201), $boat['Description']);
			$boat['Description'] = preg_replace("/\&eacute;/",chr(233), $boat['Description']);
			$boat['Description'] = preg_replace("/\&Ecirc;/",chr(202), $boat['Description']);
			$boat['Description'] = preg_replace("/\&ecirc;/",chr(234), $boat['Description']);
			$boat['Description'] = preg_replace("/\&macr;/",chr(175), $boat['Description']);
			$boat['Description'] = preg_replace("/\&frac12;/",chr(189), $boat['Description']);
			$boat['Description'] = preg_replace("/\&rsquo;/",chr(39), $boat['Description']);
			$boat['Description'] = preg_replace("/\&ndash;/",chr(45), $boat['Description']);
			
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strip_tags($boat['Description']), 0, "L");
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");

	
	// Print out the overview
	
	
	
	$pdf->AddPageExplicit();
	
	$pdf->Title("Specification");
	
	// Print out the introduction
	$pdf->Cell(INTRO1_WIDTH, INTRO_HEIGHT,  "" , 0, 0, "L");
	$pdf->Cell(INTRO2_WIDTH - INTRO1_WIDTH, INTRO_HEIGHT,  "" , 0, 1, "L");
	$pdf->SetFont('Helvetica','',9);
	$secondColumnX = $pdf->GetX() + INTRO1_WIDTH;
	$secondColumnY = $pdf->GetY();

	$pdf->SetFont('helvetica','B',9);
	define('OVERVIEW_LABEL', 32);
	$Year = trim($boat['Year']);
	$Builder = trim($boat['Builder']);
	$Designer = trim($boat['Designer']);
	$HullMaterial = trim($boat['HullMaterial']);
	if (! (empty($Year) && empty($Builder) && empty($Designer) && empty($HullMaterial))) {
		$pdf->SetFont('helvetica','B',11);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Builder/Designer", 10, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");

		$pdf->SetFont('helvetica','',9);
		if (!empty($Year)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Year:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Year, 0, 1, "L");
		}
		if (!empty($Builder)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Builder:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Builder, 0, 1, "L");
		}
		if (!empty($Designer)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Designer:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Designer, 0, 1, "L");
		}
		if (!empty($HullMaterial)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Construction:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $HullMaterial, 0, 1, "L");
		}
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		
	}
	$EngineNo = trim($engine['EngineNo']);
	$EngineMake = trim($engine['EngineMake']);
	$EngineModel = trim($engine['EngineModel']);
	$EngineYear = trim($engine['EngineYear']);
	$EngineFuel = trim($engine['EngineFuel']);
	$EngineHours = trim($engine['EngineHours']);
	$PropellerType = trim($engine['PropellerType']);
	$MaxSpeed = trim($boat['MaxSpeed']);
	$CruisingSpeed = trim($boat['CruisingSpeed']);
	$TotalPower = trim($engine['TotalPower']);
	$Range = trim($boat['Range']);

	if (! (empty($EngineNo) && empty($EngineMake) && empty($EngineModel) && empty($EngineYear) && empty($EngineFuel) && empty($EngineHours) && empty($TotalPower) && empty($MaxSpeed) && empty($CruisingSpeed) && empty($Range) && empty($PropellerType))) {
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
		$pdf->SetFont('helvetica','B',11);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Engines", 0, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		if (!empty($EngineNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "No. of Engines:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $EngineNo, 0, 1, "L");
		}
		if (!empty($EngineMake)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Make:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $EngineMake, 0, 1, "L");
		}
		if (!empty($EngineModel)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Model:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $EngineModel, 0, 1, "L");
		}
		if (!empty($EngineFuel)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Fuel Type:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $EngineFuel, 0, 1, "L");
		}
		if (!empty($EngineHours)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Hours:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $EngineHours, 0, 1, "L");
		}
		if (!empty($TotalPower)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Total Power:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $TotalPower . " hp", 0, 1, "L");
		}
		if (!empty($MaxSpeed)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Max Speed:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $MaxSpeed . " knots", 0, 1, "L");
		}
		if (!empty($CruisingSpeed)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Cruising Speed:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $CruisingSpeed . " knots", 0, 1, "L");
		}
		if (!empty($Range)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Range:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Range . " nm", 0, 1, "L");
		}
		if (!empty($PropellerType)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Propeller Type:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $PropellerType, 0, 1, "L");
		}
		
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
	}
	
	$SingleBerthNo = trim($boat['SingleBerthNo']);
	$DoubleBerthNo = trim($boat['DoubleBerthNo']);
	$TwinBerthNo = trim($boat['TwinBerthNo']);
	$CabinNo = trim($boat['CabinNo']);
	$BathroomNo = trim($boat['BathroomNo']);
	$HeadNo = trim($boat['HeadNo']);
	if (! (empty($SingleBerthNo) && empty($DoubleBerthNo) && empty($TwinBerthNo) && empty($CabinNo) && empty($BathroomNo) && empty($HeadNo))) {
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
		$pdf->SetFont('helvetica','B',11);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Accommodation", 0, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		if (!empty($SingleBerthNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Single Berths:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $SingleBerthNo, 0, 1, "L");
		}
		if (!empty($DoubleBerthNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Double Berths:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $DoubleBerthNo, 0, 1, "L");
		}
		if (!empty($TwinBerthNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Twin Berths:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $TwinBerthNo, 0, 1, "L");
		}
		if (!empty($CabinNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Cabins:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $CabinNo, 0, 1, "L");
		}
		if (!empty($BathroomNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Bathrooms:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $BathroomNo, 0, 1, "L");
		}
		if (!empty($HeadNo)) {
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Heads:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $HeadNo, 0, 1, "L");
		}
				
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
	}

	
	
	// Print out the overview
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetXY($secondColumnX, $secondColumnY);
	switch ($boat['PriceCurrency']) {
		case "&euro;":
			$currency = EURO;
			break;
		case "&pound;":
			$currency = POUND;
			break;
		default:
			$currency = $boat['PriceCurrency'];
	}
	$Length_mt = trim($boat['Length_ft']);
	$Beam = trim($boat['Beam']);
	$MinDraft = trim($boat['MinDraft']);
	$MaxDraft = trim($boat['MaxDraft']);
	$LOA = trim($boat['LOA']);
	$LOD = trim($boat['LOD']);
	$LWL = trim($boat['LWL']);
	$BridgeClearance = trim($boat['BridgeClearance']);
	$Displacement = trim($boat['Displacement']);
	$Ballast = trim($boat['Ballast']);
	$DryWeight = trim($boat['DryWeight']);
	if (! (empty($Length_mt) && empty($Beam) && empty($MinDraft) && empty($MaxDraft) && empty($LOA) && empty($LOD) && empty($LWL) && empty($BridgeClearance) && empty($Displacement) && empty($Ballast))) {
		$pdf->SetFont('helvetica','B',11);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Dimensions", 10, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		if (!empty($Length_mt)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Length:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Length_ft . " feet", 0, 1, "L");
		}
		if (!empty($Beam)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Beam:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Beam, 0, 1, "L");
		}
		if (!empty($MinDraft)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Min Draft:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $MinDraft, 0, 1, "L");
		}
		if (!empty($MaxDraft)) {					
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Max Draft:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $MaxDraft, 0, 1, "L");
		}
		if (!empty($LOA)) {					
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Length Overall:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $LOA, 0, 1, "L");
		}
		if (!empty($LOD)) {					
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Length on Deck:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $LOD, 0, 1, "L");
		}
		if (!empty($LWL)) {					
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Length at Waterline:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $LWL, 0, 1, "L");
		}
		if (!empty($BridgeClearance)) {					
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Bridge Clearance:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $BridgeClearance, 0, 1, "L");
		}
		if (!empty($DryWeight)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Dry Weight:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $DryWeight . " " . $boat['DryWeightUnit'], 0, 1, "L");
		}
		if (!empty($Ballast)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Ballast:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $Ballast . " " . $boat['BallastUnit'], 0, 1, "L");
		}
		
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
	}
	
	
	

	
	$WaterTankNo = trim($boat['WaterTankNo']); 
	$FuelTankNo = trim($boat['FuelTankNo']);
	$HoldingTankNo = trim($boat['HoldingTankNo']);
	
	if (! (empty($WaterTankNo) && empty($FuelTankNo) && empty($HoldingTankNo))) {
		$pdf->SetFont('helvetica','B',11);
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Tanks: ", 0, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		$pdf->SetX($secondColumnX);
		if (!empty($WaterTankNo)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Water:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $WaterTankNo . " x " . $boat['WaterTankCap'] . " " . $boat['WaterTankCapUnit'], 0, 1, "L");
		}
		if (!empty($FuelTankNo)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Fuel:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $FuelTankNo . " x " . $boat['FuelTankCap'] . " " . $boat['FuelTankCapUnit'], 0, 1, "L");
		}
		if (!empty($HoldingTankNo)) {
			$pdf->SetX($secondColumnX);
			$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Holding:");
			$pdf->Cell(CONTENT_WIDTH - INTRO_WIDTH - OVERVIEW_LABEL, OVERVIEW_TEXT, $HoldingTankNo . " x " . $boat['HoldingTankCap'] . " " . $boat['HoldingTankCapUnit'], 0, 1, "L");
		}
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
	}
	
		//$pdf->SetFont('helvetica','B',9);
		//define('OVERVIEW_LABEL', 32);
		$BoatName = trim($boat['Name']);
		if (! (empty($BoatName))) {
		$pdf->SetFont('helvetica','B',11);
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Boat Name:", 0, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		$pdf->SetX($secondColumnX);
		if (!empty($BoatName)) {
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, $BoatName, 0, 1, "L");
		}	

	$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
	
	}
	
	$LocationCity = trim($boat['LocationCity']);
	$LocationCountry = trim($boat['LocationCountry']);
	if (! (empty($LocationCity) && empty($LocationCountry))) {
		$pdf->SetFont('helvetica','B',11);
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "", 0, 1, "L");
		$pdf->SetX($secondColumnX);
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, "Location: ", 0, 1, "L");
		$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n", 0, "L");
		$pdf->SetFont('helvetica','',9);
		$pdf->SetX($secondColumnX);
		if (empty($LocationCity)) {
			$location = $LocationCountry;
		} else if (empty($LocationCountry)) {
			$location = $LocationCity;
		} else {
			$location = $LocationCity . ", " . $LocationCountry;
		}
		$pdf->Cell(OVERVIEW_LABEL, OVERVIEW_TEXT, $location, 0, 1, "L");
	}
	/* 
	 * SECOND PAGE!
	 */
	$pdf->AddPageExplicit();
	
	
	$pdf->Title("Inventory");

	
	$pdf->SetFont('Verdana','',8);
	$bull = BULLET;
	$boat['Description'] = utf8_decode($boat['Description']);
		$boat['Description'] = preg_replace("/(\<lis*\/?\>){1,2}/","\n $bull ", $boat['Description']);
		$boat['Description'] = preg_replace("/(\<br\s*\/?\>){1,2}/","\n", $boat['Description']);
		$boat['Description'] = preg_replace("/(\<p\s*\/?\>){1,2}/","", $text['Description']);
		$boat['Description'] = preg_replace("/(\<\/p\s*\>){1,2}/","\n", $text['Description']);
		$boat['Description'] = preg_replace("/\&amp;/",chr(38), $boat['Description']);
		$boat['Description'] = preg_replace("/\&nbsp;/"," ", $boat['Description']);
		$boat['Description'] = preg_replace("/\&bull;/",chr(149), $boat['Description']);
		$boat['Description'] = preg_replace("/\&rdquo;/",chr(34), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ldquo;/",chr(34), $boat['Description']);
		$boat['Description'] = preg_replace("/\&euro;/",chr(128), $boat['Description']);
		$boat['Description'] = preg_replace("/\&pound;/",chr(163), $boat['Description']);
		$boat['Description'] = preg_replace("/\&iquest;/",chr(191), $boat['Description']);	
		$boat['Description'] = preg_replace("/\&Agrave;/",chr(192), $boat['Description']);
		$boat['Description'] = preg_replace("/\&agrave;/",chr(224), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Aacute;/",chr(193), $boat['Description']);
		$boat['Description'] = preg_replace("/\&aacute;/",chr(225), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Acirc;/",chr(194), $boat['Description']);
		$boat['Description'] = preg_replace("/\&acirc;/",chr(226), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Atilde;/",chr(195), $boat['Description']);
		$boat['Description'] = preg_replace("/\&atilde;/",chr(227), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Ccedil;/",chr(199), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ccedil;/",chr(231), $boat['Description']);		
		$boat['Description'] = preg_replace("/\&Egrave;/",chr(200), $boat['Description']);
		$boat['Description'] = preg_replace("/\&egrave;/",chr(232), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Eacute;/",chr(201), $boat['Description']);
		$boat['Description'] = preg_replace("/\&eacute;/",chr(233), $boat['Description']);
		$boat['Description'] = preg_replace("/\&Ecirc;/",chr(202), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ecirc;/",chr(234), $boat['Description']);
		$boat['Description'] = preg_replace("/\&macr;/",chr(175), $boat['Description']);
		$boat['Description'] = preg_replace("/\&frac12;/",chr(189), $boat['Description']);
		$boat['Description'] = preg_replace("/\&rsquo;/",chr(39), $boat['Description']);
		$boat['Description'] = preg_replace("/\&ndash;/",chr(45), $boat['Description']);

	
			
	$Query = "SELECT * FROM descriptions WHERE BoatID=$id AND AddTitle != 'Pricing Details' AND AddTitle != 'customContactInformation' AND  AddTitle not like 'french %' AND AddTitle not like 'german %' AND AddTitle not like 'russian %' ";
	$textdata = $db->db_query($Query); 
	while($text = $db->db_rs( $textdata )) {
		if ($text['AddTitle'] != 'customContactInformation') {
			$pdf->SetFont('Verdana-Bold','',8);
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strtoupper(strip_tags($text['AddTitle'])), 0, "L");
			$pdf->SetFont('Verdana','',8);
			$bull = BULLET;
			$text['AddDescription'] = utf8_decode($text['AddDescription']);
			$text['AddDescription'] = preg_replace("/(\<li\s*\/?\>){1,2}/","\n $bull ", $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/(\<br\s*\/?\>){1,2}/","\n", $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/(\<p\s*\/?\>){1,2}/","", $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/(\<\/p\s*\>){1,2}/","\n", $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&amp;/",chr(38), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&nbsp;/"," ", $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&bull;/",chr(149), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&rdquo;/",chr(34), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&ldquo;/",chr(34), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&euro;/",chr(128), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&pound;/",chr(163), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&iquest;/",chr(191), $text['AddDescription']);	
			$text['AddDescription'] = preg_replace("/\&Agrave;/",chr(192), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&agrave;/",chr(224), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Aacute;/",chr(193), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&aacute;/",chr(225), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Acirc;/",chr(194), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&acirc;/",chr(226), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Atilde;/",chr(195), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&atilde;/",chr(227), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Ccedil;/",chr(199), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&ccedil;/",chr(231), $text['AddDescription']);			
			$text['AddDescription'] = preg_replace("/\&Egrave;/",chr(200), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&egrave;/",chr(232), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Eacute;/",chr(201), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&eacute;/",chr(233), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&Ecirc;/",chr(202), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&ecirc;/",chr(234), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&macr;/",chr(175), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&frac12;/",chr(189), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&rsquo;/",chr(39), $text['AddDescription']);
			$text['AddDescription'] = preg_replace("/\&ndash;/",chr(45), $text['AddDescription']);
			
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, strip_tags($text['AddDescription']), 0, "L");
			$pdf->MultiCell(COLUMN_WIDTH, COLUMN_HEIGHT, "\n\n", 0, "L");
		}
	}


	
	/*
	 * PHOTO GALLERY
	 */
	$pdf->SetColumnMode(0);

	$half_way = CONTENT_WIDTH / 2;
	
	$attachments_printed = 6;
	$i=0;
	$num_pics = $db->db_rows($imagedata);
//	echo "Num Pics: $num_pics\n\n";
	for($i = 1; $i < $num_pics; $i++) {
		// do we need to start a new page?
		if ($attachments_printed == 6){
			$pdf->AddPage();
			$pdf->Title("Photo Gallery");
			$attachments_printed = 0;
		}
		if($i % 2 == 0){
			$image1 = $db->db_rs($imagedata);
//			echo "Image1\n";
//			print_r($image1);
			$image2 = $db->db_rs($imagedata);
//			echo "Image2\n";
//			print_r($image2);
			// we have a row
			// so process the images in it
			list($width, $height) = getimagesize($image1[ImageURL]);
			$height_ratio = MAX_ATTACHMENT_HEIGHT / $height;
			$width_ratio = MAX_ATTACHMENT_WIDTH / $width;
			$scale1 = ($width_ratio < $height_ratio) ? $width_ratio : $height_ratio;
			$image_height1 = $height * $scale1;
			$image_width1  = $width  * $scale1;
			$image_margin1 = ($half_way - $image_width1) / 2;
			
			list($width, $height) = getimagesize($image2[ImageURL]);
			$height_ratio = MAX_ATTACHMENT_HEIGHT / $height;
			$width_ratio = MAX_ATTACHMENT_WIDTH / $width;
			$scale2 = ($width_ratio < $height_ratio) ? $width_ratio : $height_ratio;
			$image_height2 = $height * $scale2;
			$image_width2  = $width * $scale2;
			$image_margin2 = ($half_way - $image_width2) / 2;
			
			$pdf->Cell($image_margin1, $image_height1, "", 0, 0);
			$yvalue = $pdf->GetY();
			$pdf->Image($image1[ImageURL], null, $yvalue, $image_width1, $image_height1);
			$pdf->Cell($image_width1, $image_height1, "", 0, 0);
			$pdf->Cell($image_margin1, $image_height1, "", 0, 0);
			
			$pdf->Cell($image_margin2, $image_height2, "", 0, 0);
			$pdf->Image($image2[ImageURL], null, $yvalue, $image_width2, $image_height2);
			$pdf->Cell($image_width2, $image_height2, "", 0, 0);
			$larger_height = $image_height1 > $image_height2 ? $image_height1 :
			$image_height2;
			$pdf->Cell($image_margin2, $larger_height, "", 0, 1);


			
			$pdf->SetFont('helvetica', '', ATTACHMENT_TEXT);
			$pdf->Cell($image_margin1, ATTACHMENT_TEXT, "", 0, 0);
			$pdf->Cell($image_width1, ATTACHMENT_TEXT, $image1[ImageTitle], 0, 0, "L");
			$pdf->Cell($image_margin1, ATTACHMENT_TEXT, "", 0, 0);
			
			$pdf->Cell($image_margin2, ATTACHMENT_TEXT, "", 0, 0);
			$pdf->Cell($image_width2, ATTACHMENT_TEXT, $image2[ImageTitle], 0, 0, "L");
			$pdf->Cell($image_margin2, ATTACHMENT_TEXT, "", 0, 1);	

			$attachments_printed += 2;
		}
	}
	
	if ($num_pics % 2 == 0) {
			//need to do the last one
			if ($attachments_printed == 6){
				$pdf->AddPage();
				$pdf->Title("Photo Gallery");
			}
			$image = $db->db_rs($imagedata);
//			echo "\n\nFinal Image\n";
//			print_r($image);
			$pdf->SetTextColor(0,0,0);
			
			// so process the images in it
			list($width, $height) = getimagesize($image[ImageURL]);
			$height_ratio = MAX_ATTACHMENT_HEIGHT / $height;
			$width_ratio = MAX_ATTACHMENT_WIDTH / $width;
			$scale1 = ($width_ratio < $height_ratio) ? $width_ratio : $height_ratio;			
			$image_height1 = $height * $scale1;
			$image_width1  = $width  * $scale1;
			$image_margin1 = ($half_way - $image_width1) / 2;
			
			$pdf->Cell($image_margin1, $image_height1, "", 0, 0);
			$yvalue = $pdf->GetY();
			$pdf->Image($image[ImageURL], null, $yvalue, $image_width1, $image_height1);
			$pdf->SetX($image_width1 + $image_margin1 + MARGIN);
			$pdf->Cell($image_margin1, $image_height1, "", 0, 1);

			$pdf->SetFont('helvetica', '', ATTACHMENT_TEXT);
			$pdf->Cell($image_margin1, ATTACHMENT_TEXT, "", 0, 0);
			$pdf->Cell($image_width1, ATTACHMENT_TEXT, $image[ImageTitle], 0, 0, "L");
			$pdf->Cell($image_margin1, ATTACHMENT_TEXT, "", 0, 1, "L");
	}
	
	
	$name = $boat['Make'] . $boat['Model'] . ".pdf";

	$pdf->Output($name, 'D');
	
	?>