***Quickstart Guide for BWWS XML Solution 1.4***

#Changelog version 1.4#
New database fields added:
- MakeModel is an additional field with fulltext search which can be used to run a keyword search on Make and Model.
- Length_mt and Length_ft replace Length and Length_Units in order to provide more accurate searching on length
- New code to populate Length_mt, Length_ft and MakeModel added
- Added reference to includes/contries.php in order to convert country codes before database insertion
- Addition to pdf settings which causes a pop up prompt open/save pdf
- Changed how the country conversion works so that it converts to readable countries from country code when input to the database.
- Changed all called to $_GET to use the santise function to clear the data before it is used in a db query. eg:
$SearchMake = $_GET['make']; becomes $SearchMake = $db->sanitise($_GET['make']);
- New function 'sanitise string' added to increase security and prevent malicious SQL injection
- Changed search form to include MakeModel keyword search, you can also still use the old Make and Model searches seperately.
- Changed printing of length to use new Length_ft and Length_mt fields
- Layout: Moved sidebar below content code for better semantic layout
- CSS file: Set container to overflow:auto and boat-content to float:left as part of semantic structure changes
- Featured boat ready, this template will take the Stock Number from the XML file to use for Featured boats. Just get the client to enter 'fb' in the 'Stock Number' field in BW.

***

This guide assumes that you have already uploaded to package to your server and set up a blank database to be used for the XML listings.
This release comes with one standard template that can be altered using CSS. Additional templates will be provided with future releases.

Step 1 - Open classes/dc.class.php and enter database details
Step 2 - Run setup/create-table.php once in your browser, this will create the 6 tables with all the columns and rows needed to take the data import.
Step 3 - Ensure that the file paths for includes and header content in the following files are correct for your server:
- boat-details.php
- import-xml.sh (New shell script file)
- import-local-xml.php
- index.php
- pdffullspecs.php
Step 4 - Enter Bridge GUID into the import-xml.sh file. This file is a shell script file which simply checks that it can get the XML from the Bridge service and downloads it, once sucessfull downloaded, it will run the import php. 
Step 5 - Set up a cron job to run import-xml.sh, you can't run it through the browser. Check the database in phpmyadmin to verify that the listings are there.
TROUBLESHOOTING - If the listings are not there, check in the /used-boats-for-sale/ folder to see if the .xml file is there, if it is, run import-local-xml.php in the browser to see if you get an error message.
Step 6 - Navigate to the index of your xml listings folder and you should be able to see the boat listings and use the search and sort functions.

-- These are the basic details needed to get the XML listings system up and running, the following are for futher customisation ---

PDF Full Specs
The current PDF generator will be updated to use the same templating system used in BoatWizard, this is currently still is development and we will provide code updates when available.
- in pdffullspecs.php, edit the footer around line 169, you can edit the background colour and change the text that displays in the footer
- To change the logo used in the pdf, open logo.jpg in your favourite image editor and use this as a basis to paste in a new logo and resave the file.

A raw version of the files working can be found at http://www.boatwizardwebsolutions.co.uk/used-boats-for-sale
This is how the system should look before you apply any site template to the code.
To see what the template system looks like within a site template, go to http://www.williamsandsmithells.co.uk/used-boats-for-sale

For bug reporting, enhancement requests and questions, please contact bpiper@boats.com 
or use the Boatwizardwebsolutions Forum at http://www.boatwizardwebsolutions.com/forum. I have created a new section for XML system support.

