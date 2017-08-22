<?php 

//        *********************                   !!!IMPORTANT!!!                    *********************
//        *********************         Wordpress MUST be updated to version         *********************
//        *********************           3.4.1 or higher before you begin           *********************
//        *********************                 adding XML inventory                 *********************

//		1. Fill out basic info about the brokerage below
			
			$brokername = "Intrinsic Yacht & Ship"; // Name of the Broker ex: "Pee Wee Herman's Yacht Sales"
			$brokeremail = "5576-Website@bwleadmanager.com"; // Email that leads are sent to ex: "p.herman@yachtworld.com"
			$errorsemail = "xmlerrors@yachtworld.com"; // Email that error messages are sent to, use your addy during the build then insert the following when live "xml-errors@yachtworld.com"
			$brokerphonenumber = "(410) 263-9288"; // Phone number of the brokerage
			$rootdirectoryurl = "http://intrinsicyacht.com/"; // URL to the root of the site ex: "http://65.213.231.100/~wizard/superfunwebsiteurl.com/"    ** MUST have "/" at the end. **
			$fulldirectoryurl = "http://intrinsicyacht.com/wp-content/themes/intrinsic-custom/"; // FULL url to the wordpress directory ex: "http://65.213.231.100/~wizard/superfunwebsiteurl.com/wp-content/themes/light-clean-blue/"    ** MUST have "/" at the end. **
			$absolutepath = "/home/wizard/public_html/intrinsicyacht.com/wp-content/themes/intrinsic-custom/"; // enter the absolute path to your theme folder ex: "/home/wizard/public_html/superfunwebsiteurl.com/wp-content/themes/light-clean-blue/"	
			$XMLpath = "xml/"; // Make sure that the "xml" folder AND the files inside of it are set to 777 permissions

//      2. Create 2 pages inside the wordpress website.
//      	- Call one page "Brokerage Inventory"
//      	- Call the other "boat deatails"
//      	- Leave the page template BLANK for now



//      3. Create a new database for the broker if they do not previously have one and fill out variables below 
			
			$databasename = "wizard_intrinsic2014"; // Name of the Database ex: "xml_sample"

			
//		4. Add the Database name referenced above "xml_sample" to db.class.php line #9


//		5. Create a new event in Provisioning and fill out variable below

			$boatfeed = "http://services.boatwizard.com/bridge/events/60b1ffb7-b84f-467a-8dbb-1ff656eebaa9/boats?status=on"; // Feed from boatwizard ex: https://services.boatwizard.com/bridge/events/4029c334-5d83-4bcc-b3c1-fbcabb0e4b11/boats?status=on

//		6. Locate the broker in Provisioning and add the newly created event to their profile.


//		7. Find the page number for the created pages and change the "0" in the "add-to-header.php" file to the corresponding page numbers. (can be found on or around line 2)
//			*** Note that ANY page that displays inventory needs to have that page number added to the header.php file ***
//			ex: if you add a Rinker only page, you will need to add the page # of that Rinker page to the header

//		8. Paste code from "add-to-header.php" into the THEME header.php after the stylesheet and jQuery links.

//		9. Edit "logo.jpg" to reflect the proper logo for the broker


//		10. Add all contents of the XML folder into the Wordpress THEME folder on the clients' site

//		11. Inside the client wordpress dashboard, edit the page templates for the 2 pages you created
//			- "boat details" gets the "XML Boat Details" template
//			- "Brokerage Inventory" gets the "XML Brokerage Inventory" template
 
//		12.  open the following files in your webrowser:
//            1.) createtable.php  i.e ( http://64.68.37.71/~wizard/superfunwebsiteurl.com/wp-content/themes/light-clean-blue/setup/create-table.php)
//            2.) import-local-xml.php i.e ( http://64.68.37.71/~wizard/superfunwebsiteurl.com/wp-content/themes/light-clean-blue/import-local-xml.php)


//		13.  Set up this cron job in Plesk
//			   0  0,12	*	*	*	/usr/bin/wget -O - -q www.thegreatoutdoorsmarine.com/wp-content/themes/greatoutdoors_custom/create-xml.php

//		14.  Set up this cron job in Cpanel
//			bash -x /home/wizard/public_html/####Domain####/wp-content/themes/###TemplateName###/create-xml.sh >> /home/wizard/public_html/####Domain####/wp-content/themes/###TemplateName###/XMLimport.log


//		15. Add the following code to the "Theme Directory" functions.php file
//			remove_filter('template_redirect', 'redirect_canonical');

//		16. Add "(WP - BLOGINFO URL)/brokerage-inventory/">Boats for sale</a>" to the header.php file for navigation

//      16. Add read/write permissions (777) to lastKnownWorking.xml and temporaryXml.xml

//      17. make sure ghost captch cache has read/write permissions (777)

//      18. Add Broker info and adjust logo & color on pdffullspec.php


//		*** FOOTNOTES ***

//		There is a file called brand-inventory-template.php that will allow you to add a page that is specific to a brand. 
//		   - Simply create a page in wordpress for that brand
//		   - Add the page number of that new page to the header file
//		   - Add content in the wordpress page editor
//		   - Select "XML Brand Inventory" as the page template
//		   - Make Sure to add: "?make=Example" to the page URL 



?>
