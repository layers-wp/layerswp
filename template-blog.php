<?php
/**
 * Template Name: Blog
 * The template for displaying post archives
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header();
do_action( 'layers_before_blog_template' );
get_template_part( 'partials/header' , 'page-title' ); ?>
<div class="container content-main archive clearfix">
	<div class="grid">
		<?php get_sidebar( 'left' ); ?>

		<?php
		$page = ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
		$paged = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : $page );
		$wp_query = new WP_Query( array(
			'post_type' => 'post',
			'paged'     => $paged,
			'page'      => $paged,
		) );

		if ( $wp_query->have_posts() ) : ?>
			<div id="post-list" <?php layers_center_column_class(); ?>>
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
					global $post; ?>
					<?php get_template_part( 'partials/content' , 'list' ); ?>
				<?php endwhile; // while has_post(); ?>
				<?php layers_pagination( array( 'query' => $wp_query ) ); ?>
			</div>
		<?php endif; // if has_post() ?>

		<?php get_sidebar( 'right' ); ?>
	</div>
</div>
<?php do_action( 'layers_after_blog_template' );
get_footer();