<?php
/*
*Header template: Intrinsic Yacht & Ship
*/
?>

<!DOCTYPE html>

<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="google-site-verification" content="7IrtKCZG4BsO8zaeUgU9DieuZg-H1uORQGIx7c99jHc">
<meta name="p:domain_verify" content="c1b4eff95770bf3f66b398216d17c70a"/>

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/intrinsic-styles.css">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

<link href="<?php bloginfo( 'url' ); ?>/favicon-intrinsic.ico" rel="shortcut icon">
<link rel="apple-touch-icon" href="<?php bloginfo( 'url' ); ?>/images/apple-touch-icon.png">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<!-- bxslider -->
<link href="<?php bloginfo( 'template_url' ); ?>/bxslider/jquery.bxslider.css" rel="stylesheet">
<script src="<?php bloginfo( 'template_url' ); ?>/bxslider/jquery.bxslider.min.js"></script>

<!-- accordian -->
<script src="<?php bloginfo( 'template_url' ); ?>/js/accordion.js"></script>

<script>
$(function() {
	$( "#accordion" ).accordion(
	collapsible: false
	});
});
</script>

<link href='http://fonts.googleapis.com/css?family=Fjord+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Old+Standard+TT:700,400' rel='stylesheet' type='text/css'>

<title><?php wp_title( '|', true, 'right' ); ?></title>

<!-- captcha -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/css/contact.css">
<!--<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/js/jquery.js"></script>-->
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/js/form.js"></script>

<?php if ((is_page( 4 ))) { ?>

<link href="<?php bloginfo( 'url' ); ?>/intrinsic_search.css" rel="stylesheet" type="text/css">

<? } ?>

<?php if ( is_home() ) { ?>

<!-- slideshow -->
<link href="<?php bloginfo( 'template_url' ); ?>/css/superslides.css" rel="stylesheet">

<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.easing.1.3.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.animate-enhanced.min.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.superslides.js" type="text/javascript" charset="utf-8"></script>

<style>

@media only screen and (max-width: 767px) {

.bx-slider
		{display: block;}

}

</style>

<?php } ?>



<?php if (is_page( array( 26, 67 ) )) { ?>

<title><?php echo $boat['Make'] . " " . $boat['Model']; ?> boat for sale</title>
<meta name="keywords" content="<?php echo $boat['Make']; ?>, <?php echo $boat['Model']; ?>, <?php echo $boat['LocationCountry']; ?>, boat for sale, used boat, brokerage, yacht" />
<meta name="description" content="<?php strip_tags ($boat['Description']); ?>" />
<?php } else { ?>
<title><?php  wp_title(''); ?></title>

<?php } ?>



<?php if (is_page( array( 26, 67 ) )) { 

//Include configuration parameters
require("setup/config.php");

?>   

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">

<title><?php echo $boat['Make'] . " " . $boat['Model']; ?> boat for sale</title>

<meta name="keywords" content="<?php echo $boat['Make']; ?>, <?php echo $boat['Model']; ?>, <?php echo $boat['LocationCountry']; ?>, boat for sale, used boat, brokerage, yacht">
<meta name="description" content="<?php strip_tags ($boat['Description']); ?>">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/galleria/themes/classic/galleria.classic.css">
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/galleria/galleria-1.2.8.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/galleria/themes/classic/galleria.classic.min.js"></script>

<style>

.galleria-errors
		{visibility: hidden;
		display: none;}

</style>

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/includes/brokerage-boats.css">
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/shadowbox/shadowbox.css">

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({ language: 'en', players: ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv'] });
</script>

<!-- Facebook Opengraph -->
<meta property="og:title" content="<?php echo $boat['Make'] . " " . $boat['Model']; ?> for sale">
<meta property="og:type" content="product">
<meta property="og:url" content="<?php echo $url; ?>">
<meta property="og:description" content="View this boat for sale. Includes price information, photos, downloadable PDF brochure, videos (where available) and more!">
<meta property="og:site_name" content="<?php echo $brokername; ?>">
<meta property="fb:admins" content="100002748181602">
<meta property="fb:app_id" content="228358150539054">

<div id="fb-root"></div>

<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({appId: '228358150539054', status: true, cookie: true, xfbml: true});
		};
window.setTimeout(function() {
	FB.Canvas.setAutoResize();
		}, 250);
	};
(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol +
		'http://connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
}());
</script>

<?php } ?>
   
<script type="text/javascript">
function goTo(page) {
	var url="";
	hu=window.location.search.substring(1);
	query=hu.replace(/page=[0-9][0-9]/g,"");
	query=query.replace(/page=[0-9]/g,"");
		url=url+"?page="+page+"&"+query;
		url=url.replace(/&&/g,'&');
	document.location.href = url;
	return false;
}
</script>

<!-- removes commas in price searches  -->
<? $_GET['maxprice']=str_replace(",","",$_GET['maxprice']);
$_GET['minprice']=str_replace(",","",$_GET['minprice']);?> 

<script type="text/javascript">
	function validate_contact_boat_details(){
		if(!document.contact_boat_details.name.value){
		alert("You did not enter a name. Please do so before continuing.");
	}
		else if(!document.contact_boat_details.email.value){
		alert("You did not enter an email. Please do so before continuing.");
	}
		else{
		document.contact_boat_details.submit();
		}
	}
	function showSubject(){
	}

	function validate_contact_boat_details2(){
		if(!document.contact_boat_details2.name.value){
		alert("You did not enter a name. Please do so before continuing.");
	}
		else if(!document.contact_boat_details2.email.value){
		alert("You did not enter an email. Please do so before continuing.");
	}
		else{
		document.contact_boat_details2.submit();
		}
	}
	function showSubject(){
	}

	function validate_contact_us_desktop(){
		if(!document.contact_us_desktop.name.value){
		alert("You did not enter a name. Please do so before continuing.");
	}
		else if(!document.contact_us_desktop.email.value){
		alert("You did not enter an email. Please do so before continuing.");
	}
		else{
		document.contact_us_desktop.submit();
		}
	}
	function showSubject(){
	}

	function validate_contact_us_mobile(){
		if(!document.contact_us_mobile.name.value){
		alert("You did not enter a name. Please do so before continuing.");
	}
		else if(!document.contact_us_mobile.email.value){
		alert("You did not enter an email. Please do so before continuing.");
	}
		else{
		document.contact_us_mobile.submit();
		}
	}
	function showSubject(){
	}
</script>


<?php wp_head(); ?>
<script type="text/javascript">
//<![CDATA[

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-12111807-23']);
    _gaq.push(['_trackPageview']);

    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    //]]>
</script>
</head>


<body>


<div id="container">

	<header id="header">

		<div class="header-logo-container">

			<div class="header-logo">
				<a href="<?php bloginfo( 'url' ); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/header-logo.jpg" width="100%" height="100%" alt="Intrinsic Yacht & Ship"></a>
			</div>

		</div>

		<div id="mobile-menu-box">

			<div id="mobile-menu-toggle">
				<h4>Menu</h4>
			</div>

            <div class="navigation-mobile-container">
    
                <nav class="navigation-mobile">
                    <ul>
                    <li><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&lineonly&ps=20&lineonly">CO-BROKERAGE SEARCH</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/manufacturer-search/">MANUFACTURER SEARCH</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/our-inventory/">OUR INVENTORY</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/new-yachts/">NEW YACHTS</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/intrinsic-news-events-promotions/">INTRINSIC NEWS, EVENTS & PROMOTIONS</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/intrinsic-360o/">INTRINSIC 360º</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/service/">SERVICE</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/store/">STORE</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/contact-us/">CONTACT US</a></li>
                    </ul>
                </nav>
    
			</div>

		</div>

		<div class="header-contact-info-container">
			<h4>Call us toll free</h4>
            <h2 class="header-phone">1.866.617.BOAT</a></h2>
			<h2><a class="header-phone-mobile" href="tel:18666172628">1.866.617.BOAT</a></h2>
		</div>

		<div class="header-service-button-container">
			<a href="<?php bloginfo( 'url' ); ?>/boat-service-repair-mechanical/" class="header-service-button" alt="Need Service 24/7?">
				Need Service 24/7?
			</a>
		</div>

		<div class="navigation-desktop-container">

			<div class="navigation-desktop">
            
            	<?php wp_nav_menu( array( 
				'sort_column' => 'menu_order', 
				'menu' => 'Desktop menu',
				'container' => false, 
				'theme_location' => 'header-menu' ) ); ?>

			</div>

		</div>

		<div style="clear: both;"></div>
        
	</header>