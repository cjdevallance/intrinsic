			<?php query_posts("cat=14&posts_per_page=2");
			while (have_posts()) : the_post(); ?>	
            
            <?php 
			if(has_post_thumbnail($post->ID)){ 
				$thumbsrc = get_the_post_thumbnail($post->ID,'full'); 
			} else {
				$thumbsrc = "<img src=\"images/no_image_1.jpg\" alt=\"" . get_the_title() . "\">";
			}
			$url = get_post_meta($post->ID, "Listing URL", true);
			?>

			<div class="featured-yacht">
            
            	<a href="<?php echo $url; ?>"><?php echo $thumbsrc; ?></a>
				
                <a class="featured-yacht-title" href="<?php echo $url; ?>"><?php the_title(); ?></a>

				<a class="arrow-button" href="<?php echo $url; ?>"><i class="fa fa-caret-right"></i></a>

			</div>
            
            <?php endwhile; ?>