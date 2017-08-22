<?php
/**
 * The template for displaying 404 pages (Not Found)
*/

get_header(); ?>

<section class="middle-section-downlevel">

	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>

	<div class="page-wrapper">

		<div class="page-content">

			<h2><?php _e( 'Page not found', 'twentythirteen' ); ?></h2>
			
            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentythirteen' ); ?></p>

			<?php get_search_form(); ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>