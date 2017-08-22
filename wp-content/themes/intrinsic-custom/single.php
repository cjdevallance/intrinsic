<?php
/**
* The template for displaying all single posts
*/

get_header(); ?>

<!---------- middle content ----------->

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>
    
    <a class="previous-page" href="javascript:javascript:history.go(-1)">< Back to previous page</a>
    
    <section class="full">

		<?php while ( have_posts() ) : the_post(); ?>
    
        <?php the_content(); ?>
    
        <?php endwhile; ?>
	</section>

</div>

<!---------- end middle content ----------->

<?php get_footer(); ?>