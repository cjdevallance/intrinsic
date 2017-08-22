<?php
/**
* The template for displaying all pages
*/

get_header(); ?>

<!---------- middle content ----------->

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>
    
    <section class="full" style="min-height: 500px;">

		<?php while ( have_posts() ) : the_post(); ?>
    
        <?php the_content(); ?>
    
        <?php endwhile; ?>
	</section>

</div>

<!---------- end middle content ----------->

<?php get_footer(); ?>