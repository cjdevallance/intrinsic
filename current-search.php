<?php

if($_GET['searched'] == "true"){
	$result = false;
echo "<p style=\"margin-left: 20px;\">";

//Manufacturer
if($_GET['man']){ echo "<b>Manufacturer/Model:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['man'] . "<br>";
	$result = true;
}

//Length
if($_GET['fromLength']){ echo "<b>Min Length:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['fromLength'] . " ft.<br>";
	$result = true;
}
if($_GET['toLength']){ echo "<b>Max Length:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['toLength'] . " ft.<br>";
	$result = true;
}

//Price
if($_GET['fromPrice']){ echo "<b>Min Price:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;$" . $_GET['fromPrice'] . "<br>";
	$result = true;
}
if($_GET['toPrice']){ echo "<b>Max Price:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;$" . $_GET['toPrice'] . "<br>";
	$result = true;
}

//Year
if($_GET['fromYear']){ echo "<b>Min Year:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['fromYear'] . "<br>";
	$result = true;
}
if($_GET['toYear']){ echo "<b>Max Year:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['toYear'] . "<br>";
	$result = true;
}

//Boat Type
if($_GET['type']){ echo "<b>Boat Type:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . $_GET['type'] . "<br>";
	$result = true;
}

//Hull Material
if($_GET['hmid'] == "100"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Aluminum<br>";
	$result = true;
}
else if($_GET['hmid'] == "110"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Carbon Fiber<br>";
	$result = true;
}
else if($_GET['hmid'] == "101"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Composite<br>";
	$result = true;
}
else if($_GET['hmid'] == "108"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Ferro-Cement<br>";
	$result = true;
}
else if($_GET['hmid'] == "102"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Fiberglass<br>";
	$result = true;
}
else if($_GET['hmid'] == "106"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Hypalon<br>";
	$result = true;
}
else if($_GET['hmid'] == "105"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Other<br>";
	$result = true;
}
else if($_GET['hmid'] == "107"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;PVC<br>";
	$result = true;
}
else if($_GET['hmid'] == "109"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Roplene<br>";
	$result = true;
}
else if($_GET['hmid'] == "103"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Steel<br>";
	$result = true;
}
else if($_GET['hmid'] == "104"){ echo "<b>Hull Material:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Wood<br>";
	$result = true;
}
		
//Number of Engines
if($_GET['enid'] == "100"){ echo "<b>Number of Engines:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;1<br>";
	$result = true;
}
else if($_GET['enid'] == "101"){ echo "<b>Number of Engines:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;2<br>";
	$result = true;
}
else if($_GET['enid'] == "103"){ echo "<b>Number of Engines:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;None<br>";
	$result = true;
}
else if($_GET['enid'] == "102"){ echo "<b>Number of Engines:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Other<br>";
	$result = true;
}
			
//Fuel Type
if($_GET['ftid'] == "101"){ echo "<b>Fuel Type:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Diesel<br>";
	$result = true;
}
else if($_GET['ftid'] == "100"){ echo "<b>Fuel Type:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Gas<br>";
	$result = true;
}
else if($_GET['ftid'] == "102"){ echo "<b>Fuel Type:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Other<br>";
	$result = true;
}	

//Condition
if($_GET['is'] == "new"){ echo "<b>Condition:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;New<br>";
	$result = true;
}
else if($_GET['is'] == "used"){ echo "<b>Condition:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Used<br>";
	$result = true;
}

//Worldwide Region

 if($_GET['rid'] == "153"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;United States<br>";
	$result = true;
}
else if($_GET['rid'] == "100"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Northeast<br>";
	$result = true;
}
else if($_GET['rid'] == "101"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Mid-Atlantic<br>";
	$result = true;
}
else if($_GET['rid'] == "102"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Great Lakes<br>";
	$result = true;
}
else if($_GET['rid'] == "103"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Midwest<br>";
	$result = true;
}
else if($_GET['rid'] == "158"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Heartland<br>";
	$result = true;
}
else if($_GET['rid'] == "104"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Southeast<br>";
	$result = true;
}
else if($_GET['rid'] == "105"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Gulf Coast<br>";
	$result = true;
}
else if($_GET['rid'] == "106"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Southwest<br>";
	$result = true;
}
else if($_GET['rid'] == "107"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;West<br>";
	$result = true;
}
else if($_GET['rid'] == "108"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Pacific Northwest<br>";
	$result = true;
}
else if($_GET['rid'] == "109"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Africa<br>";
	$result = true;
}
else if($_GET['rid'] == "110"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Asia<br>";
	$result = true;
}
else if($_GET['rid'] == "111"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Australia<br>";
	$result = true;
}
else if($_GET['rid'] == "112"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Bahamas<br>";
	$result = true;
}
else if($_GET['rid'] == "114"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Canada<br>";
$result = true;
}
else if($_GET['rid'] == "115"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Caribbean<br>";
	$result = true;
}
else if($_GET['rid'] == "116"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Central America<br>";
	$result = true;
}
else if($_GET['rid'] == "119"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Europe<br>";
	$result = true;
}
else if($_GET['rid'] == "10001"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Major European<br>";
	$result = true;
}
else if($_GET['rid'] == "122"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Japan<br>";
	$result = true;
}
else if($_GET['rid'] == "125"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Mexico<br>";
	$result = true;
}
else if($_GET['rid'] == "127"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;New Zealand<br>";
	$result = true;
}
else if($_GET['rid'] == "128"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;North America<br>";
	$result = true;
}
else if($_GET['rid'] == "129"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;North Sea<br>";
	$result = true;
}
else if($_GET['rid'] == "130"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;South America<br>";
	$result = true;
}
else if($_GET['rid'] == "131"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;South Pacific<br>";
	$result = true;
}
else if($_GET['rid'] == "132"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Bermuda<br>";
	$result = true;
}
else if($_GET['rid'] == "151"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Mediterranean<br>";
	$result = true;
}
else if($_GET['rid'] == "152"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Middle East<br>";
	$result = true;
}
else if($_GET['rid'] == "154"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Asia Pacific<br>";
	$result = true;
}
else if($_GET['rid'] == "155"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Korea<br>";
	$result = true;
}
else if($_GET['rid'] == "156"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Holland<br>";
	$result = true;
}
else if($_GET['rid'] == "157"){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Tahiti<br>";
	$result = true;
}
else if($_GET['rid']){ echo "<b>Worldwide Region:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;" . "" . "<br>";
	$result = true;
}

		
if($result == false){
	echo "You did not filter your search";
		}
	echo "</p>";
} else { 
?>

<p>No search has been submitted</p>

<? } ?>