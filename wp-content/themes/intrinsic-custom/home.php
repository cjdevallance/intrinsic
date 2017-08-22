<?php
/*
* Template name: Homepage
Description: This is the home page template.
*/
get_header(); ?>

	<div class="slideshow-container">
    	<?php echo do_shortcode('[wonderplugin_slider id="1"]'); ?>
	</div>

	<section class="middle-section-1">

		<div class="welcome-message-container">
			<h1>Welcome to Intrinsic Yacht & Ship</h1>
            
            <?php query_posts( 'page_id=411' ); 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<p><?php the_content(); ?></p>

			<?php endwhile; ?>

			<?php endif; ?>
			
		</div>

		<div class="search-box-container-desktop">

			<h3>Find a Yacht</h3>

			<form action="<?php bloginfo( 'url' ); ?>/compile_search.php" method="post" name="searchform">
			<input type="hidden" name="urlx" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>">
			<input type="hidden" id="inv" name="source" value="inv">

			<div class="inventory-search-form">

				<div class="search-form-div">
					Make/Model/Keyword:<br>
					<input type="text" name="man" value="">
				</div>

				<div class="search-form-div-2">
					Length:<br>
					<input type="text" name="minLn" value="">
				</div>

				<div class="to">
					<br>to
				</div>

				<div class="search-form-div-2">
					<br>
					<input type="text" name="maxLn" value="">
				</div>

				<div class="search-form-div-2">
					Year:<br>
					<input type="text" name="minYr" value="">
				</div>

				<div class="to">
					<br>to
				</div>

				<div class="search-form-div-2">
					<br>
					<input type="text" name="maxYr" value="">
				</div>

				<div class="search-form-div-2">
					Price:<br>
					<input type="text" name="minPr" value="">
				</div>

				<div class="to">
					<br>to
				</div>

				<div class="search-form-div-2">
					<br>
					<input type="text" name="maxPr" value="">
				</div>

				<div class="search-form-div">
					<input value="Search" class="search-form-button" type="submit">
				</div>

			</div>

			</form>

		</div>

		<!-- accordian function -->

		<script type="text/javascript">
			$(document).ready(function () {
				$('.accordion-toggle').on('click', function(event){
					event.preventDefault();

					var accordion = $(this);
					var accordionContent = accordion.next('.inventory-search-form');
					var accordionToggleIcon = $(this).children('.toggle-icon');

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

		<div class="accordian-guts">
			<div class="accordion-container">
				<a href="#" class="accordion-toggle"><h3>Find a Yacht</h3> <span class="toggle-icon-pls"><i class="fa fa-plus"></i></span></a>

				<div class="inventory-search-form">

					<form action="<?php bloginfo( 'url' ); ?>/compile_search.php" method="post" name="searchform">
                    <input type="hidden" name="urlx" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>">
                    <input type="hidden" id="inv" name="source" value="inv">

					<div class="search-form-div">
						Make/Model/Keyword:<br>
						<input type="text" name="man" value="">
					</div>

					<div class="search-form-div-2">
						Length:<br>
						<input type="text" name="minLn" value="">
					</div>

					<div class="to">
						<br>to
					</div>

					<div class="search-form-div-2">
						<br>
						<input type="text" name="maxLn" value="">
					</div>

					<div class="search-form-div-2">
						Year:<br>
						<input type="text" name="minYr" value="">
					</div>

					<div class="to">
						<br>to
					</div>

					<div class="search-form-div-2">
						<br>
						<input type="text" name="maxYr" value="">
					</div>

					<div class="search-form-div-2">
						Price:<br>
						<input type="text" name="minPr" value="">
					</div>

					<div class="to">
						<br>to
					</div>

					<div class="search-form-div-2">
						<br>
						<input type="text" name="maxPr" value="">
					</div>

					<div class="search-form-div">
						<input value="Search" class="search-form-button" type="submit"><!--<a href="#" class="search-form-button">Search <i class="fa fa-caret-right"></i></a>-->
					</div>

					</form>

				</div>

			</div>

		</div>

		<!-- end accordian find a yacht search form -->

		<div class="brand-logo-container-desktop">
			<h5>Authorized dealer of these fine brands:</h5>

			<a href="<?php bloginfo( 'url' ); ?>/albemarle"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-albemarle.png"></a>
            <a href="<?php bloginfo( 'url' ); ?>/bonadeo-boatworks"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-bonadeo.png"></a>
            <a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Cabo&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-cabo.png"></a>
            <a href="<?php bloginfo( 'url' ); ?>/hatteras"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-hatteras.png"></a>
            <a href="<?php bloginfo( 'url' ); ?>/jupiter"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-jupiter.png"></a>
            <a href="<?php bloginfo( 'url' ); ?>/ocean-yachts"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-ocean-yachts.png"></a>
		</div>

		<a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&lineonly&ps=20&lineonly">
        <div class="pbs-button-container-desktop">
			<div class="pbs-headline">
				<h3>Sign up for</h3>
				<h4>personal boat shopper</h4>
			</div>

			<div class="arrow-button"><i class="fa fa-caret-right"></i></div>
		</div>
		</a>

	</section>

	<section class="middle-section-2">

		<div class="featured-yachts-container-desktop">
			<h3>Featured Yachts</h3>
            
            <?php include('wp-content/themes/intrinsic-custom/featured_home_feed.php'); ?>

		</div>

		<a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&lineonly&ps=20&lineonly">
        <div class="pbs-button-container-mobile">
			<div class="pbs-headline">
				<h3>Sign up for</h3>
				<h4>personal boat shopper</h4>
			</div>

			<div class="arrow-button"><i class="fa fa-caret-right"></i></div>
		</div>
        </a>
        
		<div class="search-by-brand-container-desktop">
			<h3>Search by Brand</h3>

			<p><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Albemarle&lineonly">Albemarle</a><br>
            <a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Bonadeo&lineonly">Bonadeo Boatworks</a><br>
            <a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Cabo&lineonly">Cabo Yachts</a><br>
            <a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Hatteras&lineonly">Hatteras Yachts</a><br>
			<a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Jupiter&lineonly">Jupiter</a><br>
			<a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Ocean+Yachts&is=false&rid=128&lineonly">Ocean Yachts</a><br>
			<a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Viking&lineonly">Viking Yachts</a></p>

		</div>
        
        <div class="facebook-container">
        
        	<div id="fb-root" style="background-color: #FFFFFF;"></div>
			<script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        
        	<div class="fb-like-box" data-href="https://www.facebook.com/intrinsicyacht" data-height="390" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="true" style="background-color: #FFFFFF;"></div>
            
		</div>

		<!-- mobile brand logo slider -->

		<script>
		$(document).ready(function(){
		var doc = $( ".middle-section-2" ).width()
		var slidewidthx = doc;
		  $('.slider1').bxSlider({
			slideWidth: slidewidthx,
			minSlides: 1,
			maxSlides: 1,
			moveSlides: 1,
			slideMargin: 5
		  });
		});
		</script>

		<div class="brand-logo-container-mobile">

			<div class="slider1">
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Albemarle&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-albemarle.png"></a></div>
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Bonadeo&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-bonadeo.png"></a></div>
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Cabo&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-cabo.png"></a></div>
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Hatteras&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-hatteras.png"></a></div>
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Jupiter&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-jupiter.png"></a></div>
				<div class="slide"><a href="<?php bloginfo( 'url' ); ?>/yacht-search/?slim=pp283659&searched=true&man=Ocean+Yachts&is=false&rid=128&lineonly"><img src="<?php bloginfo( 'template_url' ); ?>/images/brand-logo-ocean-yachts.png"></a></div>
			</div>

		</div>

		<!-- end mobile brand logo slider -->
		
		<div class="news-events-container-desktop">
			<h3>News & Events</h3>
            
            <?php query_posts( 'cat=11&posts_per_page=2&orderby=date&order=DSC' );
			if ( have_posts() ) while ( have_posts() ) : the_post(); 
			$news_excerpt = substr(get_the_excerpt(), 0, 250); ?>

			<div class="news-story">
	
				<a href="<?php echo the_permalink() ?>"><span class="news-headline"><?php the_title(); ?></span></a>
				
				<p><?php echo $news_excerpt; ?>...</p>
                    
				<a class="read-more-button" href="<?php echo the_permalink() ?>">Read More <i class="fa fa-caret-right"></i></a>
			</div>
            
            <?php endwhile; ?>

		</div>

		<a href="<?php bloginfo( 'url' ); ?>/intrinsic-news-events-promotions/">
        <div class="news-events-container-mobile">
			<h3>News & Events</h3>
			<div class="arrow-button"><i class="fa fa-caret-right"></i></div>
		</div>		
		</a>

		<a href="<?php bloginfo( 'url' ); ?>/manufacturer-search/">
        <div class="search-by-brand-container-mobile">
			<h3>Search by Brand</h3>
		<div class="arrow-button"><i class="fa fa-caret-right"></i></div>
        </a>

	</section>

</div>

<?php get_footer(); ?>