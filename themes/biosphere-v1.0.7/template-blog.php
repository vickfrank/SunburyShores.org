<?php 
/*
	Template Name: Blog
*/

get_header(); 

// Get Options
$layout = get_post_meta( get_the_ID(), $dd_sn . 'layout', true );
$post_width = get_post_meta( get_the_ID(), $dd_sn . 'post_width', true );
$posts_per_page = get_post_meta( get_the_ID(), $dd_sn . 'posts_per_page', true );

// Set vars
$dd_count = 0;
$dd_max_count = 4;

// Set vars (with sidebar)
if ( $layout == 'cs' ) {
	
	// In page vars
	$content_class = 'two-thirds column ';
	$blog_posts_class = 'blog-listing-style-2';
	$has_sidebar = true;

	// Template vars (globals)
	$dd_post_class = '';
	$dd_thumb_size = 'dd-one-fourth';
	$dd_style = '2';

// Set vars (without sidebar)
} else {

	// In page vars
	$content_class = '';
	$blog_posts_class = 'masonry';
	$has_sidebar = false;

	// Template vars (globals)

	if ( $post_width == 'one_half' ) {
		$dd_post_class = 'eight columns ';
		$dd_thumb_size = 'dd-one-half';
		$dd_max_count = 2;
	} elseif ( $post_width == 'one_third' ) {
		$dd_post_class = 'one-third column ';
		$dd_thumb_size = 'dd-one-third';
		$dd_max_count = 3;
	} elseif ( $post_width == 'one_fourth' ) {
		$dd_post_class = 'four columns ';
		$dd_thumb_size = 'dd-one-fourth';
		$dd_max_count = 4;
	} else {
		$dd_post_class = 'four columns ';
		$dd_thumb_size = 'dd-one-fourth';
	}

	$dd_style = '1';

}


?>

	<div class="container clearfix">

		<div id="content" class="<?php echo $content_class; ?>">

			<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>

			<div class="blog-posts blog-listing <?php echo $blog_posts_class; ?> clearfix">

				<?php

					if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }
					$args = array(
						'paged' => $paged, 
						'post_type' => 'post',
						'posts_per_page' => $posts_per_page
					);
					$dd_query = new WP_Query($args);

					if ($dd_query->have_posts()) : while ($dd_query->have_posts()) : $dd_query->the_post(); $dd_count++;
						
							get_template_part( 'templates/content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) );

					endwhile; else:

						?><div class="align-center">The blog is empty. Go to WP admin &rarr; Posts &rarr; Add New.<br>You can read more about creating blog posts in the Documentation.</div><?php

					endif;

				?>

			</div><!-- .blog-posts -->

			<?php
				$num_pages = $dd_query->max_num_pages;
				dd_theme_pagination( $num_pages ); 
				wp_reset_postdata(); 
			?>

		</div><!-- #content -->

		<?php if ( $has_sidebar ) { get_sidebar(); } ?>

	</div><!-- .container -->

<?php get_footer(); ?>