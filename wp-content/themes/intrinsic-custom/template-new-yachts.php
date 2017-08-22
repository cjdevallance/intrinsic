<?php
/*
* Template name: New Yachts
*/
get_header(); 

?>

<!---------- middle content ----------->

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>

	<!-- sidebar -->

	<div class="third_last">

		<!-- CONTACT FORM DESKTOP -->

		<div class="contact-form-desktop">

			<h5>Contact Us</h5>
            
            <?php 
				if ($_GET['sent']){
				echo "<p>THANK YOU!</p>

				<p>Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
			} else { ?>
            
            <?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
			
           
            <?php include ('contact-form-desktop.php'); ?>

            

            <? } ?>

		</div>

		<!-- END CONTACT FORM DESKTOP -->

	</div>

	<!-- end sidebar -->

	<!-- main content area -->

	<div class="two_thirds">

		<div class="content-template-desktop">

			<?php query_posts( 'cat=15&posts_per_page=6&orderby=title&order=ASC' ); 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div class="half service">

				<div class="new-yacht-container">

					<a href="<?php echo $url; ?>"><img src="<?php bloginfo('template_url'); ?>/images/<?php echo get_post_meta($post->ID, 'Brand Logo', true); ?>"></a><br>

					<a href="<?php echo the_permalink() ?>"><button class="learn-more">Learn More <i class="fa fa-caret-right"></i></button></a>

				</div>

			</div>

			<?php endwhile; ?>

			<?php endif; ?>
            
            <?php wp_reset_query(); ?>

		</div>

	</div>

	<!-- end main content area desktop -->

	<!-- main content area mobile -->

	<div class="content-template-mobile">

		<script type="text/javascript">
		$(document).ready(function () {
			$('.accordion-toggle').on('click', function(event){
				event.preventDefault();

				var accordion = $(this);
				var accordionContent = accordion.next('.accordion-content');
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

		<div class="content-mobile">

			<?php query_posts( 'cat=15&posts_per_page=6&orderby=title&order=ASC' ); 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div class="accordion-container">

				<a href="#" class="accordion-toggle"><h3><?php the_title() ?></h3> <span class="toggle-icon"><i class="fa fa-plus"></i></span></a>
				<div class="accordion-content">

					<section class="content-template">

						<div class="new-yacht-container">

							<a href="<?php echo $url; ?>"><img src="<?php bloginfo('template_url'); ?>/images/<?php echo get_post_meta($post->ID, 'Brand Logo', true); ?>"></a><br>

							<a href="<?php echo the_permalink() ?>"><button class="learn-more">Learn More <i class="fa fa-caret-right"></i></button></a>

						</div>

					</section>

				</div>

			</div>

			<?php endwhile; ?>

			<?php endif; ?>

		</div>

		<!-- CONTACT FORM MOBILE-->

		<!-- accordian function -->

		<script type="text/javascript">
			$(document).ready(function () {
				$('.accordion-toggle-2').on('click', function(event){
					event.preventDefault();

					var accordion = $(this);
					var accordionContent = accordion.next('.contact-form-mobile');
					var accordionToggleIcon = $(this).children('.toggle-icon-2');

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

		<script type="text/javascript">
			function validate_contact_boat_details_mobile(){
				if(!document.contact_form_boat_mobile.name.value){
				alert("You did not enter a name. Please do so before continuing.");
			}
				else if(!document.contact_form_boat_mobile.email.value){
				alert("You did not enter an email. Please do so before continuing.");
			}
				else{
				document.contact_form_boat_mobile.submit();
				}
			}
			function showSubject(){
			}
		</script>

		<div class="accordian-guts-2">
			<div class="accordion-container-2">
				<a href="#" class="accordion-toggle-2"><h4>Contact Us</h4> <span class="toggle-icon-2"><i class="fa fa-plus"></i></span></a>
				<div class="contact-form-mobile">

					<?php 
						if ($_GET['sent']){
						echo "<p>THANK YOU!</p>

						<p>Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
					} else { ?>
                    
					<?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
			
					
					<?php include ('contact-form-mobile.php'); ?>

					

					<? } ?>

				</div>

			</div>

		</div>

		<!-- END CONTACT FORM MOBILE -->

		<!-- end main content area mobile -->

	</div>

<!---------- end middle content ----------->

</section>

</div>

<?php get_footer(); ?>