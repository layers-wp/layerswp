<?php  /**
 * Post helper funtions
 *
 * This file is used to display post elements, from meta to media, to galleries, to in-post pagination, all post-related functions sit in this file.
 *
 * @package Layers
 * @since Layers 1.0.0
 */


/**
* Print post meta HTML
*
* @param    string         $post_id        ID of the post to use
* @param    array           $display        Configuration arguments. (date, author, categories, tags)
* @param    string         $wrapper        Type of html wrapper
* @param    string         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/

if( !function_exists( 'layers_post_meta' ) ) {
	function layers_post_meta( $post_id = NULL , $display = NULL, $wrapper = 'footer', $wrapper_class = 'meta-info' ) {

		// If there is no post ID specified, use the current post, does not affect post author, yet.
		if( NULL == $post_id ) {
			global $post;
			$post_id = $post->ID;
		}

		// If there are no items to display, return nothing
		if ( NULL === $display ) {
			$display = array( 'date', 'author', 'categories', 'tags' );
		}

		// Allow for filtering of the display elements.
		$display = apply_filters( 'layers_post_meta_display', $display );

		foreach ( $display as $meta ) {
			switch ( $meta ) {
				case 'date' :
					$meta_to_display[] = '<span class="meta-item meta-date"><i class="l-clock-o"></i> ' . get_the_time(  get_option( 'date_format' ) , $post_id ) . '</span>';
					break;
				case 'author' :
					$meta_to_display[] = '<span class="meta-item meta-author"><i class="l-user"></i> ' . layers_get_the_author( $post_id ) . '</span>';
					break;
				case 'categories' :
					$categories = '';

					// Use different terms for different post types
					if( 'post' == get_post_type( $post_id ) ){
						$the_categories = get_the_category( $post_id );
					} elseif( 'portfolio' == get_post_type( $post_id ) ) {
						$the_categories = get_the_terms( $post_id , 'portfolio-category' );
					} else {
						$the_categories = FALSE;
					}

					// If there are no categories, skip to the next case
					if( !$the_categories ) continue;

					foreach ( $the_categories as $category ){
						$categories[] = ' <a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", LAYERS_THEME_SLUG ), $category->name ) ) . '">'.$category->name.'</a>';
					}
					$meta_to_display[] = '<span class="meta-item meta-category"><i class="l-folder-open-o"></i> ' . implode( __( ', ' , 'layerswp' ), $categories ) . '</span>';
					break;
				case 'tags' :
					$tags = '';

					if( 'post' == get_post_type( $post_id ) ){
						$the_tags = get_the_tags( $post_id );
					} elseif( 'portfolio' == get_post_type( $post_id ) ) {
						$the_tags = get_the_terms( $post_id , 'portfolio-tag' );
					} else {
						$the_tags = FALSE;
					}

					// If there are no tags, skip to the next case
					if( !$the_tags ) continue;

					foreach ( $the_tags as $tag ){
						$tags[] = ' <a href="'.get_term_link( $tag ).'" title="' . esc_attr( sprintf( __( "View all posts tagged %s", LAYERS_THEME_SLUG ), $tag->name ) ) . '">'.$tag->name.'</a>';
					}
					$meta_to_display[] = '<span class="meta-item meta-tags"><i class="l-tags"></i> ' . implode( __( ', ' , 'layerswp' ), $tags ) . '</span>';
					break;
				break;
			} // switch meta
		} // foreach $display

		if( !empty( $meta_to_display ) ) {
			echo '<' , $wrapper , ( ( '' != $wrapper_class ) ? ' class="' . $wrapper_class . '"' : NULL ) , '>';
				echo '<p>';
					echo implode( ' ' , $meta_to_display );
				echo '</p>';
			echo '</' , $wrapper , '>';
		}
	}
} // layers_post_meta

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'layers_get_the_author' ) ) {
	function layers_get_the_author() {
		return sprintf( __( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>' , 'layerswp' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'layerswp' ), get_the_author() ) ),
			esc_attr( get_the_author() )
		);
	}
} // layers_get_the_author


/**
 * Prints Comment HTML
 *
 * @param    object          $comment        Comment objext
 * @param    array           $args           Configuration arguments.
 * @param    int             $depth          Current depth of comment, for example 2 for a reply
 * @echo     string                          Comment HTML
 */
if( !function_exists( 'layers_comment' ) ) {
	function layers_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;?>
		<?php if( 2  < $depth && isset( $GLOBALS['lastdepth'] ) && $depth != $GLOBALS['lastdepth'] ) { ?>
			<div class="row comments-nested push-top">
		<?php } ?>
		<div <?php comment_class( 'content well' ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="avatar push-bottom clearfix">
				<?php edit_comment_link(__('(Edit)' , 'layerswp' ),'<small class="pull-right">','</small>') ?>
				<a class="avatar-image" href="">
					<?php echo get_avatar($comment, $size = '70'); ?>
				</a>
				<div class="avatar-body">
					<h5 class="avatar-name"><?php echo get_comment_author_link(); ?></h5>
					<small><?php printf(__('%1$s at %2$s' , 'layerswp' ), get_comment_date(),  get_comment_time()) ?></small>
				</div>
			</div>

			<div class="copy small">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.' , 'layerswp' ) ?></em>
					<br />
				<?php endif; ?>
				<?php comment_text() ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		<?php if( 2 < $depth && isset( $GLOBALS['lastdepth'] ) && $depth == $GLOBALS['lastdepth'] ) { ?>
			</div>
		<?php } ?>

		<?php $GLOBALS['lastdepth'] = $depth; ?>
	<?php }
} // layers_comment

/**
 * Backs up builder pages as HTML
 */
if( !function_exists( 'layers_backup_builder_pages' ) ) {
	function layers_backup_builder_pages(){

		if( !check_ajax_referer( 'layers-backup-pages', 'layers_backup_pages_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

		if( !isset( $_POST[ 'pageid' ] ) ) wp_die( __( 'You shall not pass' , 'layerswp' ) );

		// Get the post data
		$page_id = $_POST[ 'pageid' ];
		$page = get_post( $page_id );

		// Start the output buffer
		ob_start();
		dynamic_sidebar( 'obox-layers-builder-' . $page->ID );

		$page_content = trim( ob_get_clean() );
		$page_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $page_content);
		$page_content = strip_tags( $page_content , '<p><b><i><strong><em><quote><a><h1><h2><h3><h4><h5><img><script>' );
		$page_content = $page_content;

		$page_meta_key = 'layers_page_content_' . date( 'YmdHi' );

		update_post_meta( $page_id , $page_meta_key, $page_content );

		// Flush the output buffer
		ob_flush();
	}
} // layers_builder_page_backup
add_action( 'wp_ajax_layers_backup_builder_pages', 'layers_backup_builder_pages' );

/**
*  Adjust the site title for static front pages
*/
if( !function_exists( 'layers_post_class' ) ) {
	function layers_post_class( $classes ) {

		global $woocommerce;

		if( is_single() )
			$classes[] = 'container';

		if( ( isset( $woocommerce ) && is_cart() && 'product' == get_post_type() ) || is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {

			$classes[] = 'column';
			// Honor WC loop columns filter
			$wc_span = 12 / apply_filters( 'loop_shop_columns', 4 );
			$spans = array(12, 6, 3, 2, 1);
			$span  = in_array($wc_span, $spans) ? $wc_span : 4;
			$classes[] = 'span-'.$span;
		}

		return $classes;
	}
}
add_filter( 'post_class' , 'layers_post_class' );
add_filter( 'product_cat_class' , 'layers_post_class' );

/**
 *  The following function creates a builder page
 *
 * @param string Page Title (optional)
 * @return array Page ID
 */
if( !function_exists( 'layers_create_builder_page' ) ) {
	function layers_create_builder_page( $page_title = 'Builder Page', $page_id = NULL ) {

		$page['post_type'] = 'page';
		$page['post_status'] = 'publish';
		$page['post_title'] = $page_title;

		if( NULL != $page_id ) {
			$page['ID'] = $page_id;
			$pageid = wp_update_post ($page);
		} else {
			$pageid = wp_insert_post ($page);
		}
		if ( 0 != $pageid ) {
			update_post_meta( $pageid , '_wp_page_template', LAYERS_BUILDER_TEMPLATE );
		}

		return $pageid;
	}
}

/**
 * Get all builder pages and store in global variable
 *
 * @return  object    $layers_builder_pages wp_query list of builder pages.
*/

if( ! function_exists( 'layers_get_builder_pages' ) ) {
	function layers_get_builder_pages ( $limit = -1 ) {
		global $layers_builder_pages;

		// Fetch Builder Pages
		return get_posts( array(
			'post_status' => get_post_stati(),
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => LAYERS_BUILDER_TEMPLATE,
			'posts_per_page' => $limit
		) );
	}
}


/**
 * Get builder page content as HTML
 *
 * @param   int   $post_id ID of post to check.
 *
 * @return  string    $page_content is plain HTML version of the page content
*/
if( ! function_exists( 'layers_get_builder_page_content' ) ) {
	function layers_get_builder_page_content( $page_id = NULL ){

		if( NULL == $page_id ) return '';

		global $layers_widgets;

		ob_start();
		dynamic_sidebar( 'obox-layers-builder-' . $page_id );
		$page_content = "";
		$page_content = trim( ob_get_clean() );
		$page_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $page_content);
		$page_content = wp_kses( $page_content, array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
			'img' => array(
				'src' => array(),
				'width' => array(),
				'height' => array(),
			),
			'p',
			'b',
			'i',
			'strong',
			'em',
			'quote',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
		) );
		$page_content = preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", $page_content);
		$page_content = preg_replace("/(<a[^href]*href=[\"']{2}[^>]*>)([^<>]*|.*)(<\\/a>)/m", "$2", $page_content);
		$page_content = str_replace( '  ', '', $page_content );

		return $page_content;
	}
}
/**
 * Conditional check if is Layers page
 *
 * @param   int   $post_id   (Optional) ID of post to check. Uses global $post ID if none provided.
 */

if( ! function_exists( 'layers_is_builder_page' ) ) {
	function layers_is_builder_page( $post_id = false ){
		global $post;

		// Be sure to set a post id for use
		if ( !$post_id && isset( $post ) && isset( $post->ID ) ) {
			$post_id = $post->ID;
		}

		// If there is a post_id, check for the builder page
		if ( isset( $post_id ) ) {
			if( LAYERS_BUILDER_TEMPLATE == get_post_meta( $post_id, '_wp_page_template', true ) ) {
				return true;
			}
		}

		// Fallback
		return false;
	}
}

/**
 * Filter Layers Pages in wp-admin Pages
 *
 * @TODO: think about moving this function to it own helpers/admin.php,
 * especially if more work is to be done on admin list.
 */

if ( ! function_exists( 'layers_filter_admin_pages' ) ) {
	function layers_filter_admin_pages() {
		global $typenow;

		if ( 'page' == $typenow && isset( $_GET['filter'] ) && 'layers' == $_GET['filter'] ) {
			set_query_var(
				'meta_query',
				array(
					'relation' => 'AND',
					array(
						'key' => '_wp_page_template',
						'value' => LAYERS_BUILDER_TEMPLATE,
					)
				)
			);
		}
	}
}
add_filter( 'pre_get_posts', 'layers_filter_admin_pages' );

/**
 * Change views links on wp-list-table - all, published, draft, etc - to maintain layers page filtering
 * TODO: some kind of feeback so user knows he is in the Layers filter - maybe h2 to "Layers Pages"
 */

if ( ! function_exists( 'layers_filter_admin_pages_views' ) ) {
	function layers_filter_admin_pages_views( $views ) {
		global $typenow;

		if ( 'page' == $typenow && isset( $_GET['filter'] ) && 'layers' == $_GET['filter'] ) {
			foreach ($views as $view_key => $view_value ) {
				$query_arg = '&filter=layers';
				$view_value = preg_replace('/href=\'(http:\/\/[^\/"]+\/?)?([^"]*)\'/', "href='\\2$query_arg'", $view_value);
				$views[$view_key] = $view_value;
			}
		}
		return $views;
	}
}
//add_filter( "views_edit-page", 'layers_filter_admin_pages_views' );

/**
 * Add builder edit button to the admin bar
 *
 * @return null Nothing is returned, the Edit button is added the admin toolbar
*/

if( ! function_exists( 'layers_edit_layout_admin_menu' ) ) {
	function layers_edit_layout_admin_menu(){
		global $wp_admin_bar, $post, $wp_version;

		if( !is_admin() && version_compare( $wp_version, '4.2', '<=' ) ){
			$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$args = array(
				'id'    => 'layers-edit-layout',
				'title' => '<span class="ab-icon"></span><span class="ab-label">' . __( 'Edit Layout' , 'layerswp' ) . '</span>',
				'href'  => esc_url( add_query_arg( 'url', urlencode( $current_url ), wp_customize_url() ) ),
				'meta'  => array( 'class' => 'my-toolbar-page' )
			);
			$wp_admin_bar->add_node( $args );
		}
	}
}
add_action( 'admin_bar_menu', 'layers_edit_layout_admin_menu', 90 );

/**
 * Add "Add New Layers Page" to the admin bar
 *
 * @return null Nothing is returned, the new button is added the admin toolbar
*/

if( ! function_exists( 'layers_add_new_page_admin_menu' ) ) {
	function layers_add_new_page_admin_menu(){
		global $wp_admin_bar, $post;

		$args = array(
			'parent' => 'new-content',
			'id'    => 'layers-add-page',
			'title' =>__( 'Layers Page' , 'layerswp' ),
			'href' => admin_url( 'admin.php?page=layers-add-new-page' )
		);
		$wp_admin_bar->add_node( $args );
	}
}
add_action( 'admin_bar_menu', 'layers_add_new_page_admin_menu', 90 );

// Output custom css to add Icon to admin bar edit button.
if( ! function_exists( 'layers_add_builder_edit_button_css' ) ) {
	function layers_add_builder_edit_button_css() {
		global $pagenow;
		if ( 'post.php' === $pagenow || ! is_admin() ) : ?>
			<style>
			#wp-admin-bar-layers-edit-layout .ab-icon:before{
				font-family: "layers-interface" !important;
				content: "\e62f" !important;
				font-size: 16px !important;
			}
			</style>
		<?php endif;
	}
}
add_action('wp_print_styles', 'layers_add_builder_edit_button_css');
add_action('admin_print_styles-post.php', 'layers_add_builder_edit_button_css');

/**
* Post Featured Media
*
* @param int $attachmentid ID for attachment
* @param int $size Media size to use
* @param int $video oEmbed code
*
* @return   string     $media_output Feature Image or Video
*/

if( !function_exists( 'layers_post_featured_media' ) ) {
	function layers_post_featured_media( $args = array() ){
		global $post;
		$defaults = array (
			'postid' => $post->ID,
			'wrap' => 'div',
			'wrap_class' => 'thumbnail',
			'size' => 'medium',
			'hide_href' => false
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );

		$post_meta = get_post_meta( $postid, 'layers', true );

		$featured_media = layers_get_feature_media( get_post_thumbnail_id( $postid ), $size, ( isset( $post_meta[ 'video-url' ] ) ? $post_meta[ 'video-url' ] : NULL ), $postid );

		if( NULL == $featured_media ) return;

		$output = '';

		if( NULL != $featured_media ){
			$output .= $featured_media;
		}

		if( TRUE != $hide_href ){
			if( has_post_thumbnail() ) {
				if( !is_single() ){
					$output = '<a href="' .get_permalink( $postid ) . '">' . $output . '</a>';
				}
			}
		}

		if( '' != $wrap ) {
			$output = '<'.$wrap. ( '' != $wrap_class ? ' class="' . $wrap_class . '"' : '' ) . '>' . $output . '</' . $wrap . '>';
		}

		return apply_filters('layers_post_featured_media', $output);
	}
} // layers_post_featured_media