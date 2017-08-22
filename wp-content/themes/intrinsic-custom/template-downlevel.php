<?php
/*
Single Post Template: [Downlevel Page Template]
Description: This is the downlevel page template.  It contains a 66% content area and 33% sidebar with contact form.
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

	<!-- main content area desktop -->
    
	<div class="two_thirds">
    
    	<div class="content-template-desktop">
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large' );
			} else { 
			//no image ?>
            
			<?php } ?>

			<?php the_content(); ?>

			<?php endwhile; ?>

			<?php endif; ?>
            
        </div>
        
    </div>
    
	<!-- end main content area desktop -->
    
    <!-- main content area mobile -->

	<div class="content-template-mobile">
    
		<div class="content-mobile">
        
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large' );
			} else { 
			//no image ?>
            
			<?php } ?>

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