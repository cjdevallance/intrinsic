<?php
/*
* Template name: Contact Us
*/
get_header(); 

?>

<!---------- middle content ----------->

<?php $noslashsubj = $_GET["subject"]; ?>

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>
    
    <!-- sidebar -->
    
	<div class="third_last">
        
        <!-- CONTACT FORM DESKTOP -->

        <div class="contact-form-desktop">

            <h5>Contact Us</h5>
            
            

            <?php include ('contact-form-desktop.php'); ?>

            

        </div>

        <!-- END CONTACT FORM DESKTOP -->

	</div>
    
    <!-- end sidebar -->

	<!-- main content area -->
    
	<div class="two_thirds">
    
    	<div class="content-template-desktop">
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>

			<?php the_content(); ?>

			<?php endwhile; ?>

			<?php endif; ?>  
            
        </div>
        
    </div>
    
	<!-- end main content area -->

	<div class="content-template-mobile">

		<div class="content-template-mobile">
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>

			<?php the_content(); ?>

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
    
        <div class="accordian-guts-2">
            <div class="accordion-container-2">
                <a href="#" class="accordion-toggle-2"><h4>Contact Us</h4> <span class="toggle-icon-2"><i class="fa fa-plus"></i></span></a>
                <div class="contact-form-mobile">
    
                    
                    
					<?php include ('contact-form-mobile.php'); ?>
        
                    
    
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