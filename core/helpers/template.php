<?php  /**
 * Template helper funtions
 *
 * This file is used to display general template elements, such as breadcrumbs, site-wide pagination,  etc.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

/**
* Print breadcrumbs
*
* @param    string         $wrapper        Type of html wrapper
* @param    string         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/
global $wp_customize;

if( !function_exists( 'layers_bread_crumbs' ) ) {
	function layers_bread_crumbs( $wrapper = 'nav', $wrapper_class = 'bread-crumbs', $seperator = '/' ) {
		global $post; ?>
		<<?php echo $wrapper; ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<ul>
				<?php /* Home */ ?>
				<li><a href="<?php echo home_url(); ?>"><?php _e('Home' , 'layerswp' ); ?></a></li>

				<?php

				/* Base Page
					- Shop
					- Search
					- Post type parent page
				*/
				if( is_search() ) { ?>
					<li><?php echo esc_html( $seperator ); ?></li>
					<li><?php _e('Search' , 'layerswp' ); ?></li>
				<?php } elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) { ?>
					<li><?php echo esc_html( $seperator ); ?></li>
					<?php if( function_exists( 'woocommerce_get_page_id' )  && '-1' != woocommerce_get_page_id('shop') ) { ?>
						<?php $shop_page_id = woocommerce_get_page_id('shop'); ?>
						<?php $shop_page = get_post( $shop_page_id ); ?>
						<?php if( is_object ( $shop_page ) ) { ?>
							<li><a href="<?php echo get_permalink( $shop_page->ID ); ?>"><?php echo $shop_page->post_title; ?></a></li>
						<?php } ?>
					<?php } else { ?>
						<li><a href="#"><?php _e( 'Shop' , 'layerswp' ); ?></a></li>
					<?php }
				} elseif( is_post_type_archive() || is_singular() || is_tax() ) {

					// Get the post type object
					$post_type = get_post_type_object( get_post_type() );

					// Check if we have the relevant information we need to query the page
					if( !empty( $post_type ) && isset( $post_type->labels->slug ) ) {

						// Query template
						$parentpage = get_template_link( $post_type->labels->slug .".php");

						// Display page if it has been found
						if( !empty( $parentpage ) ) { ?>
							<li><?php echo esc_html( $seperator ); ?></li>
							<li><a href="<?php echo get_permalink($parentpage->ID); ?>"><?php echo $parentpage->post_title; ?></a></li>
						<?php }
					};

				}

				/* Categories, Taxonomies & Parent Pages

					- Page parents
					- Category & Taxonomy parents
					- Category for current post
					- Taxonomy for current post
				*/

				if( is_page() ) {

					// Start with this page's parent ID
					$parent_id = $post->post_parent;

					// Loop through parent pages and grab their IDs
					while( $parent_id ) {
						$page = get_post($parent_id);
						$parent_pages[] = $page->ID;
						$parent_id = $page->post_parent;
					}

					// If there are parent pages, output them
					if( isset( $parent_pages ) && is_array($parent_pages) ) {
						$parent_pages = array_reverse($parent_pages);
						foreach ( $parent_pages as $page_id ) { ?>
							<!-- Parent page title -->
							<li><?php echo esc_html( $seperator ); ?></li>
							<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo get_the_title( $page_id ); ?></a></li>
						<?php }
					}

				} elseif( is_category() || is_tax() ) {

					// Get the taxonomy object
					if( is_category() ) {
						$category_title = single_cat_title( "", false );
						$category_id = get_cat_ID( $category_title );
						$category_object = get_category( $category_id );

						if( is_object( $category_object ) ) {
							$term = $category_object->slug;
						} else {
							$term = '';
						}

						$taxonomy = 'category';
						$term_object = get_term_by( 'slug', $term , $taxonomy );
					} else {
						$term = get_query_var('term' );
						$taxonomy = get_query_var( 'taxonomy' );
						$term_object = get_term_by( 'slug', $term , $taxonomy );
					}

					if( is_object( $term_object ) )
						$parent_id = $term_object->parent;
					else
						$parent_id = FALSE;

					// Start with this terms's parent ID

					// Loop through parent terms and grab their IDs
					while( $parent_id ) {
						$cat = get_term_by( 'id' , $parent_id , $taxonomy );
						$parent_terms[] = $cat->term_id;
						$parent_id = $cat->parent;
					}

					// If there are parent terms, output them
					if( isset( $parent_terms ) && is_array($parent_terms) ) {
						$parent_terms = array_reverse($parent_terms);

						foreach ( $parent_terms as $term_id ) {
							$term = get_term_by( 'id' , $term_id , $taxonomy ); ?>

							<li><?php echo esc_html( $seperator ); ?></li>
							<li><a href="<?php echo get_term_link( $term_id , $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

						<?php }
					}

				} elseif ( is_single() && get_post_type() == 'post' ) {

					// Get all post categories but use the first one in the array
					$category_array = get_the_category();

					foreach ( $category_array as $category ) { ?>

						<li><?php echo esc_html( $seperator ); ?></li>
						<li><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo get_cat_name( $category->term_id ); ?></a></li>

					<?php }

				} elseif( is_singular() ) {

					// Get the post type object
					$post_type = get_post_type_object( get_post_type() );

					// If this is a product, make sure we're using the right term slug
					if( is_post_type_archive( 'product' ) || ( get_post_type() == "product" ) ) {
						$taxonomy = 'product_cat';
					} elseif( !empty( $post_type ) && isset( $post_type->taxonomies[0] ) ) {
						$taxonomy = $post_type->taxonomies[0];
					};

					if( isset( $taxonomy ) && !is_wp_error( $taxonomy ) ) {
						// Get the terms
						$terms = get_the_terms( get_the_ID(), $taxonomy );

						// If this term is legal, proceed
						if( is_array( $terms ) ) {

							// Loop over the terms for this post
							foreach ( $terms as $term ) { ?>

								<li><?php echo esc_html( $seperator ); ?></li>
								<li><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

							<?php }
						}
					}
				} ?>

				<?php /* Current Page / Post / Post Type

					- Page / Page / Post type title
					- Search term
					- Curreny Taxonomy
					- Current Tag
					- Current Category
				*/

				if( is_singular() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span></li>

				<?php } elseif ( is_search() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current">"<?php echo get_search_query(); ?>"</span></li>

				<?php } elseif( is_tax() ) {

					// Get this term's details
					$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) ); ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo $term->name; ?></span></li>

				<?php  } elseif( is_tag() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo single_tag_title(); ?></span></li>

				<?php } elseif( is_category() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo single_cat_title(); ?></span></li>

				<?php } elseif ( is_archive() && is_month() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo get_the_date( 'F Y' ); ?></span></li>

				<?php } elseif ( is_archive() && is_year() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo get_the_date( 'Y' ); ?></span></li>

				<?php } elseif ( is_archive() && is_author() ) { ?>

					<li><?php echo esc_html( $seperator ); ?></li>
					<li><span class="current"><?php echo get_the_author(); ?></span></li>

				<?php } ?>
			</ul>
		</<?php echo $wrapper; ?>>
	<?php }
} // layers_post_meta

/**
* Print pagination
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @param    string         $wrapper        Type of html wrapper
* @param    string         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/
if( !function_exists( 'layers_pagination' ) ) {
	function layers_pagination( $args = NULL , $wrapper = 'div', $wrapper_class = 'pagination' ) {

		// Set up some globals
		global $wp_query, $paged;

		// Get the current page
		if( empty($paged ) ) $paged = ( get_query_var('page') ? get_query_var('page') : 1 );

		// Set a large number for the 'base' argument
		$big = 99999;

		// Get the correct post query
		if( !isset( $args[ 'query' ] ) ){
			$use_query = $wp_query;
		} else {
			$use_query = $args[ 'query' ];
		} ?>

		<<?php echo $wrapper; ?> class="<?php echo $wrapper_class; ?>">
			<?php echo paginate_links( array(
				'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
				'prev_next' => true,
				'mid_size' => ( isset( $args[ 'range' ] ) ? $args[ 'range' ] : 3 ) ,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type' => 'list',
				'current' => $paged,
				'total' => $use_query->max_num_pages
			) ); ?>
		</<?php echo $wrapper; ?>>
	<?php }
} // layers_pagination

/**
* Get Page Title
*
* Returns an array including the title and excerpt used across the site
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @echo     array           $title_array    Section Title & Excerpt
*/
if( !function_exists( 'layers_get_page_title' ) ) {
	function layers_get_page_title() {
		global $post;

		// Setup return
		$title_array = array();

		if(!empty($parentpage) && !is_search()) {
			$parentpage = get_template_link(get_post_type().".php");
			$title_array['title'] = $parentpage->post_title;
			if($parentpage->post_excerpt != ''){ $title_array['excerpt'] = $parentpage->post_excerpt; }

		} elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) {
			if( function_exists( 'woocommerce_get_page_id' )  && -1 != woocommerce_get_page_id('shop') ) {
				$shop_page = get_post( woocommerce_get_page_id('shop') );
				if( is_object( $shop_page ) ) {
					$title_array['title' ] = $shop_page->post_title;
				}
			} else {
				$title_array['title' ] = __( 'Shop' , 'layerswp' );
			}
		} elseif( is_page() ) {
			while ( have_posts() ) { the_post();
				$title_array['title'] = get_the_title();
				if( $post->post_excerpt != "") $title_array['excerpt'] = strip_tags( get_the_excerpt() );
			};
		} elseif( is_search() ) {
			$title_array['title'] = __( 'Search' , 'layerswp' );
			$title_array['excerpt'] = get_search_query();
		} elseif( is_tag() ) {
			$title_array['title'] = single_tag_title( '' , false );
			$title_array['excerpt'] = get_the_archive_description();
		} elseif( !is_page() && is_category() ) {
			$title_array['title'] = single_cat_title( '', false );
			$title_array['excerpt'] = get_the_archive_description();
		} elseif (!is_page() && get_query_var('term' ) != '' ) {
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );
			$title_array['title'] = $term->name;
			$title_array['excerpt'] = $term->description;
		} elseif( is_author() ) {
			$title_array['title'] = get_the_author();
			$title_array['excerpt'] =  get_the_author_meta('user_description');
		} elseif ( is_day() ) {
			$title_array['title' ] = sprintf( __( 'Daily Archives: %s' , 'layerswp' ), get_the_date() );
		} elseif ( is_month() ) {
			$title_array['title' ] = sprintf( __( 'Monthly Archives: %s' , 'layerswp' ), get_the_date( _x( 'F Y', 'monthly archives date format' , 'layerswp' ) ) );
		} elseif ( is_year() ) {
			$title_array['title' ] = sprintf( __( 'Yearly Archives: %s' , 'layerswp' ), get_the_date( _x( 'Y', 'yearly archives date format' , 'layerswp' ) ) );
		} elseif( is_single() ) {
			$title_array['title' ] = get_the_title();
		} else {
			$title_array['title' ] = __( 'Archives' , 'layerswp' );
		}

		return apply_filters( 'layers_get_page_title' , $title_array );
	}
} // layers_get_page_title

/**
 * Set body classes.
 */
if( !function_exists( 'layers_body_class' ) ) {
	function layers_body_class( $classes ){

		$header_sticky_option	= layers_get_theme_mod( 'header-sticky' );
		$header_overlay_option	= layers_get_theme_mod( 'header-overlay');

		// Handle sticky / not sticky
		if( TRUE == $header_sticky_option ){
			$classes[] = 'layers-header-sticky';
		}

		// Handle overlay / not overlay
		if( TRUE == $header_overlay_option ){
			$classes[] = 'layers-header-overlay';
		}

		// Add class that spans across all post archives and single pages
		if( layers_is_post_list_template() || is_archive() || is_singular( 'post' ) ) {
			$classes[] = 'layers-post-page';
		}

		return apply_filters( 'layers_body_class', $classes );
	}
} // layers_body_class
add_action( 'body_class', 'layers_body_class' );

/**
 * Check for a Layers Blog List Page
 */
if( !function_exists( 'layers_is_post_list_template' ) ) {
	function layers_is_post_list_template() {
		if(
			is_page_template( 'template-blog.php' ) ||
			is_page_template( 'template-both-sidebar.php' ) ||
			is_page_template( 'template-left-sidebar.php' ) ||
			is_page_template( 'template-right-sidebar.php' ) ){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/**
 * Apply Customizer settings to site housing
 */
if( !function_exists( 'layers_apply_customizer_styles' ) ) {
	function layers_apply_customizer_styles() {

		/**
		* Setup the colors to use below
		*/
		$main_color = layers_get_theme_mod( 'site-accent-color' , TRUE );
		$header_color = layers_get_theme_mod( 'header-background-color', FALSE );
		$header_color_no_default = layers_get_theme_mod( 'header-background-color', TRUE );
		$footer_color = layers_get_theme_mod( 'footer-background-color', FALSE );

		/**
		* Header Colors
		*/

		$bg_opacity = 1;

		// Apply the BG Color
		if( '' != $header_color ) {
			layers_inline_styles( '.header-site, .header-site.header-sticky', 'css', array(
				'css' => 'background-color: rgba(' . implode( ', ' , layers_hex2rgb( $header_color ) ) . ', ' . $bg_opacity . '); '
			));

			// Add Invert if the color is not light
			if ( 'dark' == layers_is_light_or_dark( $header_color ) ){
				add_filter( 'layers_header_class', 'layers_add_invert_class' );
			}
		}

		/**
		* General Colors
		*/

		if( '' != $header_color ) {
			// Title Container
			layers_inline_styles( '.title-container', 'background', array( 'background' => array( 'color' => $header_color ) ) );
			if ( 'dark' == layers_is_light_or_dark( $header_color ) ){
				add_filter( 'layers_title_container_class', 'layers_add_invert_class' );
			}
		}

		if( '' != $main_color ) {
			// Buttons
			layers_inline_button_styles( '', 'button', array(
				'selectors' => array(
					'input[type="button"]', 'input[type="submit"]', 'button', '.button', '.form-submit input[type="submit"]',
					// Inverts
					'.invert input[type="button"]', '.invert input[type="submit"]', '.invert button', '.invert .button', '.invert .form-submit input[type="submit"]',
				),
				'button' => array(
					'background-color' => $main_color,
				)
			));

			// Content - Links
			layers_inline_styles( array(
				'selectors' => array( '.copy a:not(.button)', '.story a:not(.button)' ),
				'css' => array(
					'color' => $main_color,
					'border-bottom-color' => $main_color,
				),
			));
			layers_inline_styles( array(
				'selectors' => array( '.copy a:not(.button):hover', '.story a:not(.button):hover' ),
				'css' => array(
					'color' => layers_too_light_then_dark( $main_color ),
					'border-bottom-color' => layers_too_light_then_dark( $main_color ),
				),
			));
		}

/**
		* Footer Colors
 */

		if( '' != $footer_color ) {
			// Apply the BG Color
		layers_inline_styles( '.footer-site', 'background', array(
			'background' => array(
					'color' => $footer_color,
			),
		));

			// Add Invert if the color is dark
			if ( 'dark' == layers_is_light_or_dark( $footer_color ) ){
				add_filter( 'layers_footer_site_class', 'layers_add_invert_class' );
	}
}

	}
}
add_action( 'wp_enqueue_scripts', 'layers_apply_customizer_styles', 50 );

/**
 * Helper that simply adds an invert class to an array of classes.
 * For use in conjunction with Filters.
 *
 * @param array $class Existing array of classes passed by the filter.
 */
if( !function_exists( 'layers_add_invert_class' ) ) {
	function layers_add_invert_class( $classes ) {
		$classes[] = 'invert';

		return $classes;
	}
}

/**
 * Helper that checks if a color is light or dark then hooks an invert filter to a get_class.
 *
 * @param string $color Hex color to check aginst.
 * @param string $hook  Name of the to add the 'invert' to if the color is dark.
 *
 * @return bool Whether the color was dark, hook exists, invert was hooked successfuly
 */
if( !function_exists( 'layers_maybe_set_invert' ) ) {
	function layers_maybe_set_invert( $color, $hook ) {

		if ( 'dark' == layers_is_light_or_dark( $color ) ){
			return add_filter( $hook, 'layers_add_invert_class' );
		}
	}
}

/**
 * Retrieve the classes for the header element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
if( !function_exists( 'layers_get_header_class' ) ) {
	function layers_get_header_class( $class = '' ){

		$header_align_option = layers_get_theme_mod( 'header-menu-layout' );
		$header_sticky_option = layers_get_theme_mod( 'header-sticky' );
		$header_overlay_option = layers_get_theme_mod( 'header-overlay');
		$header_full_width_option = layers_get_theme_mod( 'header-width' );
		$header_background_color_option = layers_get_theme_mod( 'header-background-color' );

		$classes = array();

		// Add the general site header class
		$classes[] = 'header-site';

		// Handle sticky / not sticky
		if( TRUE == $header_sticky_option ){
			$classes[] = 'header-sticky';
		}

		// Handle overlay / not overlay
		if( TRUE == $header_overlay_option ){
			$classes[] = 'header-overlay';
		}

		// Add full-width class
		if( 'layout-fullwidth' == $header_full_width_option ) {
			$classes[] = 'content';
		}

		// Add alignment classes
		if( 'header-logo-left' == $header_align_option ){
			$classes[] = 'header-left';
		} else if( 'header-logo-right' == $header_align_option ){
			$classes[] = 'header-right';
		} else if( 'header-logo-top' == $header_align_option ){
			$classes[] = 'nav-clear';
		} else if( 'header-logo-center-top' == $header_align_option ){
			$classes[] = 'header-center';
		} else if( 'header-logo-center' == $header_align_option ){
			$classes[] = 'header-inline';
		}

		if ( ! empty( $class ) ) {
			if ( !is_array( $class ) )
				$class = preg_split( '#\s+#', $class );

			$classes[] = array_merge( $classes, $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		// Default to Header Left if there are no matches above
		if( empty( $classes ) ) $classes[] = 'header-left';

		$classes = apply_filters( 'layers_header_class', $classes, $class );

		return $classes;

	}
} // layers_get_header_class

/**
 * Display the classes for the header element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */
if( !function_exists( 'layers_header_class' ) ) {
	function layers_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for body element
		echo 'class="' , join( ' ', layers_get_header_class( $class ) ) , '"';
	}
} // layers_header_class

/**
 * Retrieve the classes for the wrapper element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
if( !function_exists( 'layers_get_site_wrapper_class' ) ) {
	function layers_get_site_wrapper_class( $class = '' ){

		$classes = array();

		$classes[] = 'wrapper-site';

		$classes = apply_filters( 'layer_site_wrapper_class', $classes, $class );

		return $classes;
	}
} // layers_get_site_wrapper_class

/**
 * Display the classes for the wrapper element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */

if( !function_exists( 'layer_site_wrapper_class' ) ) {
	function layer_site_wrapper_class( $class = '' ) {
		// Separates classes with a single space, collates classes for body element
		echo 'class="' , join( ' ', layers_get_site_wrapper_class( $class ) ) , '"';
	}
} // layer_site_wrapper_class

/**
 * Retrieve the classes for the wrapper content element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
if( !function_exists( 'layers_get_wrapper_content_class' ) ) {
	function layers_get_wrapper_content_class( $class = '' ){

		$classes = array();

		$classes[] = 'wrapper-content';

		$classes = apply_filters( 'layers_wrapper_content_class', $classes, $class );

		return $classes;
	}
}

/**
 * Display the classes for the wrapper content element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */

if( !function_exists( 'layers_wrapper_content_class' ) ) {
	function layers_wrapper_content_class( $class = '' ) {
		// Separates classes with a single space, collates classes for body element
		echo 'class="' , join( ' ', layers_get_wrapper_content_class( $class ) ) , '"';
	}
}

/**
 * Retrieve the classes for the center column on archive and single pages
 *
 * @param string $postid Post ID to check the page template on
 * @return array Array of classes.
 */
if( !function_exists( 'layers_get_center_column_class' ) ) {
	function layers_get_center_column_class( $class = '' ){

		$classes = array();

		// This div will always have the .column class
		$classes[] = 'column';

		$left_sidebar_active = layers_can_show_sidebar( 'left-sidebar' );
		$right_sidebar_active = layers_can_show_sidebar( 'right-sidebar' );

		// Set classes according to the sidebars
		if( $left_sidebar_active && $right_sidebar_active ){
			$classes[] = 'span-6';
		} else if( $left_sidebar_active ){
			$classes[] = 'span-8';
		} else if( $right_sidebar_active ){
			$classes[] = 'span-8';
		} else {
			$classes[] = 'span-12';
		}

		// If there is a left sidebar and no right sidebar, add the no-gutter class
		if( $left_sidebar_active && !$right_sidebar_active ){
			$classes[] = 'no-gutter';
		}

		// Default to Header Left if there are no matches above
		if( empty( $classes ) ) {
			$classes[] = 'span-8';
		}

		// Apply any classes passed as parameter
		if( '' != $class ) $classes[] = $class;

		$classes = array_map( 'esc_attr', $classes );

		$classes = apply_filters( 'layers_center_column_class', $classes, $class );

		return array_unique( $classes );

	}
} // layers_get_center_column_class

/**
 * Display the classes for the header element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */

if( !function_exists( 'layers_center_column_class' ) ) {
	function layers_center_column_class( $class = '' ) {
		// Separates classes with a single space, collates classes for body element
		echo 'class="' , join( ' ', layers_get_center_column_class( $class ) ) , '"';
	}
} // layers_center_column_class

/**
 * Display the classes for the wrapper content element.
 *
 * @param   string   $key     Key to be used to populate the filter.
 * @param   string   $class   One or more classes to add to the class list.
 */
if( !function_exists( 'layers_wrapper_class' ) ) {
	function layers_wrapper_class( $key = '', $class = '' ) {

		echo 'class="' , join( ' ', layers_get_wrapper_class( $key, $class ) ) , '"';
	}
}

/**
 * Get the classes for the wrapper content element.
 *
 * @param   string   $key     Key to be used to populate the filter.
 * @param   string   $class   One or more classes to add to the class list.
 *
 * @return  string   html style list of classes
 */
if( !function_exists( 'layers_get_wrapper_class' ) ) {
	function layers_get_wrapper_class( $key = '', $class = '' ) {

		$classes = explode( ' ', $class ); // Convert string of classes to an array

		return apply_filters( 'layers_' . $key . '_class', $classes );
	}
}

/**
 * Retrieve theme modification value for the current theme.
 *
 * @param string $name Theme modification name.
 * @param string $allow_empty Whether the Theme modification should return empty, or the default, if no value is set.
 * @return string
 */
if( !function_exists( 'layers_get_theme_mod' ) ) {
	function layers_get_theme_mod( $name = '', $allow_empty = TRUE ) {

		global $layers_customizer_defaults;

		// Add the theme prefix to our layers option
		$name = LAYERS_THEME_SLUG . '-' . $name;

		// Set theme option default
		$default = ( isset( $layers_customizer_defaults[ $name ][ 'value' ] ) ? $layers_customizer_defaults[ $name ][ 'value' ] : FALSE );

		// Get theme option
		$theme_mod = get_theme_mod( $name, $default );

		// Template can choose whether to allow empty
		if ( '' == $theme_mod && FALSE == $allow_empty && FALSE != $default ) {
			$theme_mod = $default;
		}

		// Return theme option
		return $theme_mod;
	}
} // layers_get_header_class

/**
 * Check customizer and page template settings before allowing a sidebar to display
 *
 * @param   int     $sidebar                Sidebar slug to check
 */
if( !function_exists( 'layers_can_show_sidebar' ) ) {
	function layers_can_show_sidebar( $sidebar = 'left-sidebar' ){

		if ( is_page_template( 'template-blog.php' ) ) {

			// Check the arhive page option
		   $can_show_sidebar = layers_get_theme_mod( 'archive-' . $sidebar );

		} else if( is_page() ) {

			// Check the pages use page templates to decide which sidebars are allowed
			$can_show_sidebar =
				(
					is_page_template( 'template-' . $sidebar . '.php' ) ||
					is_page_template( 'template-both-sidebar.php' )
				);

		} elseif ( is_single() ) {

			// Check the single page option
		   $can_show_sidebar = layers_get_theme_mod( 'single-' . $sidebar );

		} else {

			// Check the arhive page option
		   $can_show_sidebar = layers_get_theme_mod( 'archive-' . $sidebar );

		}

		return $classes = apply_filters( 'layers_can_show_sidebar', $can_show_sidebar, $sidebar );
	}
}

/**
 * Check customizer and page template settings before displaying a sidebar
 *
 * @param   int     $sidebar                Sidebar slug to check
 * @param   string $container_class       Sidebar container class
 * @return  html    $sidebar                Sidebar template
 */
if( !function_exists( 'layers_maybe_get_sidebar' ) ) {
	function layers_maybe_get_sidebar( $sidebar = 'left', $container_class = 'column', $return = FALSE ) {

		global $post;

		$show_sidebar = layers_can_show_sidebar( $sidebar );

		if( TRUE == $show_sidebar ) { ?>
			<?php if( is_active_sidebar( LAYERS_THEME_SLUG . '-' . $sidebar ) ) { ?>
				<div class="<?php echo esc_attr( $container_class ); ?>">
			<?php } ?>
				<?php dynamic_sidebar( LAYERS_THEME_SLUG . '-' . $sidebar ); ?>
			<?php if( is_active_sidebar( LAYERS_THEME_SLUG . '-' . $sidebar ) ) { ?>
				</div>
			<?php } ?>
		<?php }
	}
} // layers_get_header_class

/**
 * Include additional scripts in the side footer
 *
 * @return  html    $additional_header_scripts Scripts to be included in the header
 */
if( !function_exists( 'layers_add_additional_header_scripts' ) ) {
	function layers_add_additional_header_scripts() {

		$add_additional_header_scripts = apply_filters( 'layers_header_scripts' , layers_get_theme_mod( 'header-custom-scripts' ) );

		if( '' != $add_additional_header_scripts ) {
			echo '<script>' , trim( htmlspecialchars_decode(  $add_additional_header_scripts ) ) , '</script>';
		}
	}
} // layers_add_additional_header_scripts
add_action ( 'wp_head', 'layers_add_additional_header_scripts' );

/**
 * Include additional scripts in the side footer
 *
 * @return  html    $additional_header_scripts Scripts to be included in the header
 */
if( !function_exists( 'layers_add_additional_footer_scripts' ) ) {
	function layers_add_additional_footer_scripts() {

		$additional_footer_scripts = apply_filters( 'layers_footer_scripts' , layers_get_theme_mod( 'footer-custom-scripts' ) );

		if( '' != $additional_footer_scripts ) {
			echo '<script>' , stripslashes( htmlspecialchars_decode( $additional_footer_scripts ) ) , '</script>';
		}
	}
} // layers_add_additional_header_scripts
add_action ( 'wp_footer', 'layers_add_additional_footer_scripts' );

/**
 * Include Google Analytics
 *
 * @return  html    $scripts Prints Google Analytics
 */
if( !function_exists( 'layers_add_google_analytics' ) ) {
	function layers_add_google_analytics() {
		global $wp_customize;
		
		// Bail if in customizer.
		if( isset( $wp_customize ) ) return;

		$analytics_id = layers_get_theme_mod( 'header-google-id' );
		
		if ( '' != $analytics_id ) { ?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '<?php echo $analytics_id; ?>', 'auto');
				ga('send', 'pageview');
			</script>
		<?php }
	}
} // layers_add_google_analytics
add_action ( 'wp_print_scripts', 'layers_add_google_analytics' );

/**
* Style Generator
*
* @param   string   $container_id   ID of the container if any
* @param   string   $type           Type of style to generate, background, color, text-shadow, border
* @param   array    $args			$args array
*/
if( !function_exists( 'layers_inline_styles' ) ) {
	function layers_inline_styles( $arg1 = NULL, $arg2 = NULL, $arg3 = NULL ){

		if ( 3 == func_num_args() ) {
			// layers_inline_styles( '#element', 'background', array( 'selectors' => '.element', 'background' => array( 'color' => '#FFF' ) ) );
			$container_id = $arg1; $type = $arg2; $args = $arg3;
		}
		elseif ( 2 == func_num_args() ) {
			// layers_inline_styles( '#element', array( 'selectors' => array( '.element' ), 'css' => array( 'color' => '#FFF' ) ) );
			$container_id = $arg1; $type = 'css'; $args = $arg2;
		}
		elseif ( 1 == func_num_args() ) {
			// layers_inline_styles( array( 'selectors' => array( '.element' ), 'css' => array( 'color' => '#FFF' ) ) );
			// layers_inline_styles( '.element { color: #FFF; }' );
			$container_id = NULL; $type = 'css'; $args = $arg1;
		}

		// Get the generated CSS
		global $layers_inline_css;

		$css = '';

		if( empty( $args ) || ( !is_array( $args ) && '' == $args ) ) return;

		switch ( $type ) {

			case 'background' :

				// Set the background array
				$bg_args = $args['background'];

				if( isset( $bg_args['color'] ) && '' != $bg_args['color'] ){
					$css .= 'background-color: ' . $bg_args['color'] . '; ';
				}

				if( isset( $bg_args['repeat'] ) && '' != $bg_args['repeat'] ){
					$css .= 'background-repeat: ' . $bg_args['repeat'] . ';';
				}

				if( isset( $bg_args['position'] ) && '' != $bg_args['position'] ){
					$css .= 'background-position: ' . $bg_args['position'] . ';';
				}

				if( isset( $bg_args['stretch'] ) && '' != $bg_args['stretch'] ){
					$css .= 'background-size: cover;';
				}

				if( isset( $bg_args['fixed'] ) && '' != $bg_args['fixed'] ){
					$css .= 'background-attachment: fixed;';
				}

				if( isset( $bg_args['image'] ) && '' != $bg_args['image'] ){
					$image = wp_get_attachment_image_src( $bg_args['image'] , 'full' );
					$css.= 'background-image: url(\'' . $image[0] .'\');';
				}
			break;

			case 'button' :

				// Set the background array
				$button_args = $args['button'];

				if( isset( $button_args['background-color'] ) && '' != $button_args['background-color'] ){
					$css .= 'background-color: ' . $button_args['background-color'] . '; ';
				}

				if( isset( $button_args['color'] ) && '' != $button_args['color'] ){
					$css .= 'color: ' . $button_args['color'] . '; ';
				}

			break;

			case 'margin' :
			case 'padding' :

				// Set the Margin or Padding array
				$trbl_args = $args[ $type ];

				if( isset( $trbl_args['top'] ) && '' != $trbl_args['top'] ){
					$css .= $type . '-top: ' . $trbl_args['top'] . '; ';
				}

				if( isset( $trbl_args['right'] ) && '' != $trbl_args['right'] ){
					$css .= $type . '-right: ' . $trbl_args['right'] . '; ';
				}

				if( isset( $trbl_args['bottom'] ) && '' != $trbl_args['bottom'] ){
					$css .= $type . '-bottom: ' . $trbl_args['bottom'] . '; ';
				}

				if( isset( $trbl_args['left'] ) && '' != $trbl_args['left'] ){
					$css .= $type . '-left: ' . $trbl_args['left'] . '; ';
				}

			break;

			case 'border' :

				// Set the background array
				$border_args = $args['border'];

				if( isset( $border_args['color'] ) && '' != $border_args['color'] ){
					$css .= 'border-color: ' . $border_args[ 'color' ] . ';';
				}

				if( isset( $border_args['width'] ) && '' != $border_args['width'] ){
					$css .= 'border-width: ' . $border_args[ 'width' ] . 'px;';
				}
			break;

			case 'color' :

				if( '' == $args[ 'color' ] ) return ;
				$css .= 'color: ' . $args[ 'color' ] . ';';

			break;

			case 'font-family' :

				if( '' == $args[ 'font-family' ] ) return ;
				$css .= 'font-family: ' . $args[ 'font-family' ] . ', "Helvetica Neue", Helvetica, sans-serif;';

			break;

			case 'text-shadow' :

				if( '' == $args[ 'text-shadow' ] ) return ;
				$css .= 'text-shadow: 0px 0px 10px rgba(' . implode( ', ' , layers_hex2rgb( $args[ 'text-shadow' ] ) ) . ', 0.75);';

			break;

			case 'css' :
			default :

				if ( is_array( $args ) ){

					if ( isset( $args['css'] ) ) {
						if ( is_array( $args['css'] ) ){
							foreach ( $args['css'] as $css_atribute => $css_value ) {
								// Skip this if a css value is not sent.
								if ( ! isset( $css_value ) || '' == $css_value || NULL == $css_value ) continue;
								$css .= "$css_atribute: $css_value;";
							}
						}
						else {
							$css .= $args['css'];
						}
					}
				}
				else if ( is_string( $args ) ){

					$css .= $args;
				}

			break;

		}

		$css = apply_filters( 'layers_inline_' . $type . '_css' , $css, $args);

		// Bail if no css is generated
		if ( '' == trim( $css ) ) return false;

		$inline_css = '';

		// If there is a container ID specified, append it to the beginning of the declaration
		if( NULL !== $container_id ) {
			$inline_css = ' ' . $container_id . ' ' . $inline_css;
		}

		if( isset( $args['selectors'] ) ) {
            if ( is_string( $args['selectors'] ) && '' != $args['selectors'] ) {
            	$inline_css .= $args['selectors'];
            } else if( is_array( $args['selectors'] ) && !empty( $args['selectors'] ) ){
            	$inline_css .= implode( ', ' . $inline_css . ' ',  $args['selectors'] );
            }
		}

		// Apply inline CSS
		if( '' == trim( $inline_css ) ) {
			$inline_css .= $css;
		} else {
			$inline_css .= '{ ' . $css . '} ';
		}

		// Format/Clean the CSS.
		$inline_css = str_replace( "\n", '', $inline_css );
		$inline_css = str_replace( "\r", '', $inline_css );
		$inline_css = str_replace( "\t", '', $inline_css );
		$inline_css = "\n" . $inline_css;

		// Add the new CSS to the existing CSS
		$layers_inline_css .= $inline_css;

		return $inline_css;
	}
} // layers_inline_styles

/**
* Style Generator Just for Buttons
*
* @param   string   $container_id   ID of the container if any
* @param   string   $type           Type of style to generate, background, color, text-shadow, border
* @param   array    $args
*/
if( !function_exists( 'layers_inline_button_styles' ) ) {
	function layers_inline_button_styles( $container_id = NULL, $type = 'background' , $args = array() ){

		// Auto text color based on background color
		if( isset( $args[ 'button' ][ 'background-color' ] ) && NULL !== layers_is_light_or_dark( $args[ 'button' ][ 'background-color' ] ) ){

			// temporarily darken the background color, so we only switch text color if very light
			$background_darker = layers_hex_darker( $args[ 'button' ][ 'background-color' ], 28 );

			if ( 'light' == layers_is_light_or_dark( $background_darker ) ) {
				$args['button']['color'] = 'rgba(0,0,0,.85)';
			}
			else if ( 'dark' == layers_is_light_or_dark( $background_darker ) ) {
				$args['button']['color'] = '#FFFFFF';
			}
		}

		// Add styling for the standard colors
		layers_inline_styles( $container_id, $type, $args );

		// Add styling for the hover colors
		if( isset( $args['selectors'] ) ) {

			if ( ! is_array( $args['selectors'] ) ) {
				// Make sure selectors is array if comma seperated string is passed
				$args['selectors'] = explode( ',', $args['selectors'] );
				$args['selectors'] = array_map( 'trim', $args['selectors'] );
			}

			$hover_args = $args;

			foreach( $args['selectors'] as $selector ){
				$new_selectors[] = $selector . ':hover';
			}
			$hover_args['selectors'] = $new_selectors;
		}

		// Generate a lighter text background color
		if( isset( $args[ 'button' ][ 'background-color' ] ) ){
			$hover_args[ 'button' ]['background-color'] = layers_hex_lighter( $args[ 'button' ][ 'background-color' ] );
		}

		// Apply hover colors
		if( isset( $hover_args ) ) layers_inline_styles( $container_id, $type, $hover_args );
	}
}

/**
 * Add Style Blocks inside the widget (to avoid FOUC).
 */

// Apply pre-generated styles
add_action( 'wp_head', 'layers_execute_inline_style_block' );

function layers_execute_inline_style_block( $filter_arg ) {
	global $layers_inline_css;

	if ( isset( $layers_inline_css ) && '' !==  $layers_inline_css ) {

		echo '<style type="text/css" id="layers-inline-styles-header">' . $layers_inline_css . '</style>';
		$layers_inline_css = '';
	}

	// If this is a filter, then return the main arg.
	return $filter_arg;
}

/**
* Apply Inline Styles
*/
if( !function_exists( 'layers_apply_inline_styles' ) ) {
	function layers_apply_inline_styles(){
		global $layers_inline_css;

		$layers_inline_css = apply_filters( 'layers_inline_css', $layers_inline_css );

		if( '' == $layers_inline_css || FALSE == $layers_inline_css ) return;

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-inline-styles',
			get_template_directory_uri() . '/assets/css/inline.css'
		);

		wp_add_inline_style(
			LAYERS_THEME_SLUG . '-inline-styles',
			$layers_inline_css
		);
	}
} // layers_apply_inline_styles
add_action( 'get_footer' , 'layers_apply_inline_styles', 100 );

/**
* Apply Custom CSS
*/
if( !function_exists( 'layers_apply_custom_styles' ) ) {
	function layers_apply_custom_styles(){

		if( '' == layers_get_theme_mod( 'custom-css' ) || FALSE == layers_get_theme_mod( 'custom-css' ) ) return;

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-custom-styles',
			get_template_directory_uri() . '/assets/css/custom.css'
		);
		wp_add_inline_style(
			LAYERS_THEME_SLUG . '-custom-styles',
			layers_get_theme_mod( 'custom-css' )
		);

	}
} // layers_apply_custom_styles
add_action( 'get_footer' , 'layers_apply_custom_styles', 100 );

/**
* Feature Image / Video Generator
*
* @param int $attachmentid ID for attachment
* @param int $size Media size to use
* @param int $video oEmbed code
*
* @return   string     $media_output Feature Image or Video
*/
if( !function_exists( 'layers_get_feature_media' ) ) {
	function layers_get_feature_media( $attachmentid = NULL, $size = 'medium' , $video = NULL, $postid = NULL ){

		// Return dimensions
		$image_dimensions = layers_get_image_sizes( $size );

		// Check for an image
		if( NULL != $attachmentid && '' != $attachmentid ){
			$use_image = wp_get_attachment_image( $attachmentid , $size);
		}

		// Check for a video
		if( NULL != $video && '' != $video ){
			$embed_code = '[embed width="'.$image_dimensions['width'].'" height="'.$image_dimensions['height'].'"]'.$video.'[/embed]';
			$wp_embed = new WP_Embed();
			$use_video = $wp_embed->run_shortcode( $embed_code );
		}

		// Set which element to return
		if( NULL != $postid &&
				(
					( is_single() && isset( $use_video ) ) ||
					( ( !is_single() && !is_page_template( 'template-blog.php' ) ) && isset( $use_video ) && !isset( $use_image) )
				)
		) {
			$media = $use_video;
		} else if( NULL == $postid && isset( $use_video ) ) {
			$media = $use_video;
		} else if( isset( $use_image ) ) {
			$media = $use_image;
		} else {
			return NULL;
		}

		$media_output = do_action( 'layers_before_feature_media' ) . $media . do_action( 'layers_after_feature_media' );

		return $media_output;
	}
}
/**
 * Get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found.
 */
function layers_get_youtube_id($url) {
	$pattern =
		'%^# Match any youtube URL
		(?:https?://)?  # Optional scheme. Either http or https
		(?:www\.)?      # Optional www subdomain
		(?:             # Group host alternatives
			youtu\.be/    # Either youtu.be,
			| youtube\.com  # or youtube.com
		(?:           # Group path alternatives
		/embed/     # Either /embed/
		| /v/         # or /v/
		| /watch\?v=  # or /watch\?v=
		)             # End path alternatives.
		)               # End host alternatives.
		([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
		$%x';
	$result = preg_match($pattern, $url, $matches);

	if (false !== $result) {
		return $matches[1];
	}
	return false;
}

/**
 * Get Vimeo video ID from URL
 *
 * @param string $url
 * @return string Vimeo video id or FALSE if none found.
 */
function layers_get_vimeo_id($url) {
	$pattern = '/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/';

	$result = preg_match($pattern, $url, $matches);

	if (false !== $result && isset( $matches[3] ) ) {
		return $matches[3];
	}
	return false;
}

/**
* Get Available Image Sizes for specific Image Type
*
* @param    string     $size 	Image size slug
*
* @return   array     $sizes 	Array of image dimensions
*/
if( !function_exists( 'layers_get_image_sizes' ) ) {
	function layers_get_image_sizes( $size = 'medium' ) {

		global $_wp_additional_image_sizes;

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {

            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

                    $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                    $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                    $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                    $sizes[ $_size ] = array(
                            'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                            'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                            'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                    );
            }
        }

        // Get only 1 size if found
        if ( $size ) {

            if( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
            } else {
				return $sizes[ 'large' ];
            }

        }

        return $sizes;
	}
} // if layers_get_image_sizes

/**
 * Translates an image ratio input into a nice clean image ratio we can use
 *
 * @param string $value Value of the input
 * @return string Image size
 *
 */
if( !function_exists( 'layers_translate_image_ratios' ) ) {
	function layers_translate_image_ratios( $value = '' ) {

		if( 'image-round' == $value ){
			$image_ratio = 'square';
		} else if( 'image-no-crop' == $value ) {
			$image_ratio = '';
		} else {
			$image_ratio = str_replace( 'image-' , '', $value );
		}

		return 'layers-' . $image_ratio;
	}
} // layers_get_header_class

/**
 * Standard menu fallback
 */

if ( ! function_exists( 'layers_menu_fallback' ) ) {
	function layers_menu_fallback() {
		echo '<ul id="nav" class="clearfix">';
			wp_list_pages('title_li=&');
		echo '</ul>';
	}
} // layers_light_or_dark

/**
 * Standard menu fallback
 */

if ( ! function_exists( 'layers_show_html5_video' ) ) {
	function layers_show_html5_video( $src = NULL , $width = 490 ) {
		if( NULL == $src ) return; ?>
		<video width="<?php echo $width;?>" height="auto" controls>
			<source src="<?php echo $src; ?>?v=<?php echo LAYERS_VERSION; ?>" type="video/<?php echo substr( $src, -3, 3); ?>">
			<?php _e( 'Your browser does not support the video tag.' , 'layerswp' ); ?>
		</video>
<?php }
} // layers_show_html5_video

/**
 * Return a list of stock standard WP post types
 */

if ( ! function_exists( 'layers_get_standard_wp_post_types' ) ) {
	function layers_get_standard_wp_post_types(){
		return array( 'post', 'page', 'attachment', 'revision', 'nav_menu_item' );
	}
} // layers_get_standard_wp_post_types

/**
 * Return a list of stock standard WP taxonomies
 */

if ( ! function_exists( 'layers_get_standard_wp_taxonomies' ) ) {
	function layers_get_standard_wp_taxonomies(){
		return array( 'category', 'nav_menu', 'category', 'link_category', 'post_format' );
	}
} // layers_get_standard_wp_taxonomies

if ( ! function_exists( 'layers_allow_json_uploads' ) ) {
	function layers_allow_json_uploads( $mime_types ){
		//Creating a new array will reset the allowed filetypes
		$mime_types[ 'json|JSON' ] = 'application/json';

		return $mime_types;
	}
} // layers_allow_json_uploads

// Add allowance for JSON to be added via the media uploader
add_filter( 'upload_mimes', 'layers_allow_json_uploads' );

/**
 * Get Content & Get Excerpt helpers
 *
 * Helper is like WordPress the_content but considers RTE before returning content.
 */

if ( ! function_exists( 'layers_get_content' ) ) {
	function layers_get_content( $content = '' ) {

		// Remove 'wpautop' so RTE can be output cleanly. This assumes every content is an RTE (Rich Text Editor)
		remove_filter( 'the_content', 'wpautop' );
		$content = apply_filters( 'the_content', $content );
		add_filter( 'the_content', 'wpautop' );
		return $content;
	}
}
if ( ! function_exists( 'layers_get_excerpt' ) ) {
	function layers_get_excerpt( $content = '' ) {

		remove_filter( 'the_excerpt', 'wpautop' );
		$content = apply_filters( 'the_excerpt', $content );
		add_filter( 'the_excerpt', 'wpautop' );
		return $content;
	}
}

if ( ! function_exists( 'layers_the_content' ) ) {
	function layers_the_content( $content = '' ) {
		echo layers_get_content( $content );
	}
}
if ( ! function_exists( 'layers_the_excerpt' ) ) {
	function layers_the_excerpt( $content = '' ) {
		echo layers_get_excerpt( $content );
	}
}

/**
* Read More Buttons
*/
if( !function_exists( 'layers_read_more_action' ) ) {
	function layers_read_more_action() {
		?>
		<a href="<?php the_permalink(); ?>" class="button"><?php echo apply_filters( 'layers_read_more_text', __( 'Read More' , 'layerswp' ) ); ?></a>
		<?php
	}
}
add_action( 'layers_list_read_more', 'layers_read_more_action' );

/**
* List Excerpt
*/
if( !function_exists( 'layers_excerpt_action' ) ) {
	function layers_excerpt_action() {
		// Return if there's nothing to show
		if( '' == get_the_excerpt() ) return;
		?>
		<div class="copy">
			<?php
				/**
				* Display the Excerpt
				*/
				the_excerpt();
			?>
		</div>
		<?php
	}
}
add_action( 'layers_list_post_content', 'layers_excerpt_action' );
