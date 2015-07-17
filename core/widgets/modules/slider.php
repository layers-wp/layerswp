<?php  /**
 * Sliders Widget
 *
 * This file is used to register and display the Layers - Slider widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Slider_Widget' ) ) {
	class Layers_Slider_Widget extends Layers_Widget {

		/**
		*  Widget construction
		*/
	 	function Layers_Slider_Widget(){

			/**
			* Widget variables
			*
			* @param  	string    		$$this->widget_id    	Widget title
			* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	string    		$post_type    		(optional) Post type for use in widget options
			* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
			* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
			*/
			$this->widget_title = __( 'Slider' , 'layerswp' );
			$this->widget_id = 'slide';
			$this->post_type = '';
			$this->taxonomy = '';
			$this->checkboxes = array(
					'show_slider_arrows',
					'show_slider_dots',
					'autoplay_slides'
				);

	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => __( 'This widget is used to display your ', 'layerswp' ) . $this->widget_id . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			parent::__construct( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title, $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'slide_height' => '550',
				'slide_ids' => rand( 1 , 1000 ),
				'show_slider_arrows' => 'on',
				'show_slider_dots' => 'on',
				'animation_type' => 'slide'

			);

			$this->slide_defaults = array (
				'title' => __( 'Slider Title', 'layerswp' ),
				'excerpt' => __( 'Short Excerpt', 'layerswp' ),
				'link' => NULL,
				'link_text' => __( 'See More', 'layerswp' ),
				'design' => array(
					'imagealign' => 'image-top',
					'imageratios' => NULL,
					'background' => array(
						'color' => '#444',
						'position' => 'center',
						'repeat' => 'no-repeat',
						'size' => 'cover'
					),
					'fonts' => array(
						'align' => 'text-center',
						'size' => 'large',
						'shadow' => ''
					)
				)
			);

			// Setup the defaults for each slide
			$this->defaults[ 'slides' ][ $this->defaults[ 'slide_ids' ] ] = $this->slide_defaults;

		}

		/**
		* Enqueue Scripts
		*/
		function enqueue_scripts(){

			// Slider JS enqueue
			wp_enqueue_script(
				LAYERS_THEME_SLUG . '-slider-js' ,
				get_template_directory_uri() . '/core/widgets/js/swiper.js',
				array( 'jquery' ),
				LAYERS_VERSION
			); // Slider

			// Slider CSS enqueue
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-slider',
				get_template_directory_uri() . '/core/widgets/css/swiper.css',
				array(),
				LAYERS_VERSION
			); // Slider
		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
	 		global $wp_customize;
			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			// Enqueue Scipts when needed
			$this->enqueue_scripts();

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget );

			// Apply slider arrow color
			if( $this->check_and_return( $widget, 'slider_arrow_color' ) ) layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.arrows a' ), 'color' => $this->check_and_return( $widget, 'slider_arrow_color' ) ) );
			if( $this->check_and_return( $widget, 'slider_arrow_color' ) ) layers_inline_styles( '#' . $widget_id, 'border', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'border' => array( 'color' => $this->check_and_return( $widget, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $widget, 'slider_arrow_color' ) ) layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'background' => array( 'color' => $this->check_and_return( $widget, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $widget, 'slider_arrow_color' ) ) layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( 'span.swiper-pagination-switch.swiper-active-switch' ), 'background' => array( 'color' => 'transparent !important' ) ) );


			// Get slider height css
			$slider_height_css = '';
			if( 'layout-full-screen' != $this->check_and_return( $widget , 'design', 'layout' ) && FALSE == $this->check_and_return( $widget , 'autoheight_slides' ) && $this->check_and_return( $widget , 'slide_height' ) ) {
				$slider_height_css = 'height: ' . $widget['slide_height'] . 'px; ';
			}

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget row slide swiper-container';
			$widget_container_class[] = $this->get_widget_layout_class( $widget );
			$widget_container_class[] = $this->check_and_return( $widget , 'design', 'advanced', 'customclass' );
			$widget_container_class[] = $this->get_widget_spacing_class( $widget );
			if( isset( $widget['design']['layout'] ) && '' != $widget['design']['layout'] ) {
				// Slider layout eg 'slider-layout-full-screen'
				$widget_container_class[] = 'slider-' . $widget['design']['layout'];
			}
			if( ! isset( $widget['design']['layout'] ) || ( isset( $widget['design']['layout'] ) && 'layout-full-screen' != $widget['design']['layout'] ) ) {
				// If slider is not full screen
				$widget_container_class[] = 'not-full-screen';
			}
			if( 1 == count( $widget[ 'slides' ] ) ) {
				// If only one slide
				$widget_container_class[] = 'single-slide';
			}
			$widget_container_class = implode( ' ', apply_filters( 'layers_slider_widget_container_class' , $widget_container_class ) ); ?>

			<section class="<?php echo $widget_container_class; ?>" id="<?php echo $widget_id; ?>" style="<?php echo esc_attr( $slider_height_css ); ?>" >
				<?php if( !empty( $widget[ 'slides' ] ) ) { ?>
					<?php if( 1 < count( $widget[ 'slides' ] ) && isset( $widget['show_slider_arrows'] ) ) { ?>
						 <div class="arrows">
							<a href="" class="l-left-arrow animate"></a>
							<a href="" class="l-right-arrow animate"></a>
						</div>
					<?php } ?>
					<div class="<?php echo $this->get_field_id( 'pages' ); ?> pages animate">
						<?php for( $i = 0; $i < count( $widget[ 'slides' ] ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>
			 		<div class="swiper-wrapper">
						<?php foreach ( wp_parse_id_list( $widget[ 'slide_ids' ] ) as $slide_key ) {

							// Make sure we've got a column going on here
							if( !isset( $widget[ 'slides' ][ $slide_key ] ) ) continue;

							// Setup the relevant slide
							$slide = $widget[ 'slides' ][ $slide_key ];

							// Set the background styling
							if( !empty( $slide['design'][ 'background' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'background', array( 'background' => $slide['design'][ 'background' ] ) );
							if( !empty( $slide['design']['fonts'][ 'color' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'color', array( 'selectors' => array( 'h3.heading', 'h3.heading a', 'div.excerpt' ) , 'color' => $slide['design']['fonts'][ 'color' ] ) );
							if( !empty( $slide['design']['fonts'][ 'shadow' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'text-shadow', array( 'selectors' => array( 'h3.heading', 'h3.heading a',  'div.excerpt' )  , 'text-shadow' => $slide['design']['fonts'][ 'shadow' ] ) );


							// Set Featured Media
							$featureimage = $this->check_and_return( $slide , 'design' , 'featuredimage' );
							$featurevideo = $this->check_and_return( $slide , 'design' , 'featuredvideo' );

							// Set Image Sizes
							if( isset( $slide['design'][ 'imageratios' ] ) ){

									// Translate Image Ratio into something usable
									$image_ratio = layers_translate_image_ratios( $slide['design'][ 'imageratios' ] );
									$use_image_ratio = $image_ratio . '-medium';

							} else {
								$use_image_ratio = 'large';
							}

 							/**
							* Set Individual Slide CSS
							*/
							$slide_class = array();
							$slide_class[] = 'swiper-slide';
							if( $this->check_and_return( $slide, 'design', 'background' , 'color' ) ) {
								if( 'dark' == layers_is_light_or_dark( $this->check_and_return( $slide, 'design', 'background' , 'color' ) ) ) {
									$slide_class[] = 'invert';
								}
							} else {
								$slide_class[] = 'invert';
							}
							if( false != $this->check_and_return( $slide , 'image' ) || 'image-left' == $slide['design'][ 'imagealign' ] || 'image-top' == $slide['design'][ 'imagealign' ] ) {
								$slide_class[] = 'has-image';
							}
							if( isset( $slide['design'][ 'imagealign' ] ) && '' != $slide['design'][ 'imagealign' ] ) {
								$slide_class[] = $slide['design'][ 'imagealign' ];
							}
							if( isset( $slide['design']['fonts'][ 'align' ] ) && '' != $slide['design']['fonts'][ 'align' ] ) {
								$slide_class[] = $slide['design']['fonts'][ 'align' ];
							}
							$slide_class = implode( ' ', $slide_class );

							// Set link entire slide or not
							$slide_wrapper_tag = 'div';
							$slide_wrapper_href = '';
							if( $this->check_and_return( $slide, 'link' ) && ! $this->check_and_return( $slide , 'link_text' ) ) {
								$slide_wrapper_tag = 'a';
								$slide_wrapper_href = 'href="' . esc_url( $slide['link'] ) . '"';
							} ?>
							<<?php echo $slide_wrapper_tag; ?> <?php echo $slide_wrapper_href; ?> class="<?php echo $slide_class; ?>" id="<?php echo $widget_id; ?>-<?php echo $slide_key; ?>" style="float: left; <?php echo $slider_height_css; ?>">
								<?php /**
								* Set Overlay CSS Classes
								*/
								$overlay_class = array();
								$overlay_class[] = 'overlay';
								if( isset( $slide['design'][ 'background' ][ 'darken' ] ) ) {
									$overlay_class[] = 'darken';
								}
								if( '' != $this->check_and_return( $slide, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $slide, 'design' , 'background', 'color' ) ) {
									$overlay_class[] = 'content';
								}
								$overlay_classes = implode( ' ', $overlay_class ); ?>

								<div class="<?php echo $overlay_classes; ?>" >
									<div class="container clearfix">
										<?php if( '' != $slide['title'] || '' != $slide['excerpt'] || '' != $slide['link'] ) { ?>
											<div class="copy-container">
												<div class="section-title <?php echo ( isset( $slide['design']['fonts'][ 'size' ] ) ? $slide['design']['fonts'][ 'size' ] : '' ); ?>">
													<?php if( $this->check_and_return( $slide , 'title' ) ) { ?>
														<h3 class="heading"><?php echo $slide['title']; ?></h3>
													<?php } ?>
													<?php if( $this->check_and_return( $slide , 'excerpt' ) ) { ?>
														<div class="excerpt"><?php layers_the_content( $slide['excerpt'] ); ?></div>
													<?php } ?>
													<?php if( 'div' == $slide_wrapper_tag && $this->check_and_return( $slide, 'link' ) && $this->check_and_return( $slide , 'link_text' ) ) { ?>
														<a href="<?php echo $slide['link']; ?>" class="button btn-<?php echo $this->check_and_return( $slide , 'design' , 'fonts' , 'size' ); ?>"><?php echo $slide['link_text']; ?></a>
													<?php } ?>
												</div>
											</div>
										<?php } // if title || excerpt ?>
										<?php if( $featureimage || $featurevideo ) { ?>
											<div class="image-container <?php echo ( 'image-round' ==  $this->check_and_return( $slide, 'design',  'imageratios' ) ? 'image-rounded' : '' ); ?>">
												<?php echo layers_get_feature_media(
													$featureimage ,
													$use_image_ratio ,
													$featurevideo
												); ?>
											</div>
										<?php } // if $slide image  ?>
									</div> <!-- .container -->
								</div> <!-- .overlay -->
							</<?php echo $slide_wrapper_tag; ?>>
						<?php } // foreach slides ?>
			 		</div>
				<?php } // if !empty( $widget->slides ) ?>
		 	</section>
						<?php if( 1 < count( $widget[ 'slides' ] ) ) { ?>
	 		<?php $swiper_js_obj = str_replace( '-' , '_' , $this->get_field_id( 'slider' ) ); ?>
		 	<script>
				jQuery(function($){

					var <?php echo $swiper_js_obj; ?> = $('#<?php echo $widget_id; ?>').swiper({
						//Your options here:
						mode:'horizontal',
						<?php if( '' == $slider_height_css ) { ?>
							calculateHeight: true,
						<?php } ?>
						<?php if( isset( $widget['show_slider_dots'] ) && ( !empty( $widget[ 'slides' ] ) && 1 < count( $widget[ 'slides' ] ) ) ) { ?>
							pagination: '.<?php echo $this->get_field_id( 'pages' ); ?>',
						<?php } ?>
						paginationClickable: true,
						watchActiveIndex: true
						<?php if( 1 < count( $widget[ 'slides' ] ) ) { ?>
							,loop: true
						<?php } ?>
						<?php if( isset( $widget['autoplay_slides'] ) && isset( $widget['slide_time'] ) && is_numeric( $widget['slide_time'] ) ) {?>
							, autoplay: <?php echo ($widget['slide_time']*1000); ?>
						<?php }?>
						<?php if( isset( $wp_customize ) && $this->check_and_return( $widget, 'focus_slide' ) ) { ?>
							,initialSlide: <?php echo $this->check_and_return( $widget, 'focus_slide' ); ?>
						<?php } ?>
					});

					<?php if( 1 < count( $widget[ 'slides' ] ) ) { ?>
						// Allow keyboard control
						<?php echo $swiper_js_obj; ?>.enableKeyboardControl();
					<?php } // if > 1 slide ?>

					$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
						e.preventDefault();

						// "Hi Mom"
						$that = $(this);

						if( $that.hasClass( 'swiper-pagination-switch' ) ){ // Anchors
							<?php echo $swiper_js_obj; ?>.swipeTo( $that.index() );
						} else if( $that.hasClass( 'l-left-arrow' ) ){ // Previous
							<?php echo $swiper_js_obj; ?>.swipePrev();
						} else if( $that.hasClass( 'l-right-arrow' ) ){ // Next
							<?php echo $swiper_js_obj; ?>.swipeNext();
						}

						return false;
					});

					<?php echo $swiper_js_obj; ?>.init();

				})
		 	</script>
		 	<?php } // if > 1 slide ?>
		<?php }

		/**
		*  Widget update
		*/

	 	function update($new_instance, $old_instance) {

	 		if ( isset( $this->checkboxes ) ) {
				foreach( $this->checkboxes as $cb ) {
					if( isset( $old_instance[ $cb ] ) ) {
						$old_instance[ $cb ] = strip_tags( $new_instance[ $cb ] );
					}
				} // foreach checkboxes
			} // if checkboxes

			// Don't break the slider when
			if ( !isset( $new_instance['slides'] ) ) {
				$new_instance['slides'] = array();
			}

			return $new_instance;
		}

		/**
		*  Widget form
		*
		* We use regular HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*
		*/
		function form( $instance ){

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			$design_bar_components = apply_filters( 'layers_' . $this->widget_id . '_widget_design_bar_components' , array(
					'custom',
					'advanced'
				) );

			$design_bar_custom_components = apply_filters( 'layers_' . $this->widget_id . '_widget_design_bar_custom_components' , array(
					'layout' => array(
						'icon-css' => 'icon-layout-fullwidth',
						'label' => __( 'Layout', 'layerswp' ),
						'wrapper-class' => 'layers-pop-menu-wrapper layers-small',
						'elements' => array(
							'layout' => array(
								'type' => 'select-icons',
								'label' => __( '' , 'layerswp' ),
								'name' => $this->get_field_name( 'design' ) . '[layout]' ,
								'id' => $this->get_field_id( 'design-layout' ) ,
								'value' => ( isset( $widget['design']['layout'] ) ) ? $widget['design']['layout'] : NULL,
								'options' => array(
									'layout-boxed' => __( 'Boxed' , 'layerswp' ),
									'layout-fullwidth' => __( 'Full Width' , 'layerswp' ),
									'layout-full-screen' => __( 'Full Screen' , 'layerswp' )
								)
							)
						)
					),
					'display' => array(
						'icon-css' => 'icon-slider',
						'label' => __( 'Slider', 'layerswp' ),
						'elements' => array(
								'show_slider_arrows' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_slider_arrows' ) ,
									'id' => $this->get_field_id( 'show_slider_arrows' ) ,
									'value' => ( isset(  $widget['show_slider_arrows'] ) ) ?  $widget['show_slider_arrows'] : NULL,
									'label' => __( 'Show Slider Arrows' , 'layerswp' )
								),
								'show_slider_dots' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_slider_dots' ) ,
									'id' => $this->get_field_id( 'show_slider_dots' ) ,
									'value' => ( isset(  $widget['show_slider_dots'] ) ) ?  $widget['show_slider_dots'] : NULL,
									'label' => __( 'Show Slider Dots' , 'layerswp' )
								),
								'slider_arrow_color' => array(
									'type' => 'color',
									'name' => $this->get_field_name( 'slider_arrow_color' ) ,
									'id' => $this->get_field_id( 'slider_arrow_color' ) ,
									'value' => ( isset( $widget['slider_arrow_color'] ) ) ? $widget['slider_arrow_color'] : NULL,
									'label' => __( 'Slider Controls Color' , 'layers-woocommerce' )
								),
								'autoplay_slides' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'autoplay_slides' ) ,
									'id' => $this->get_field_id( 'autoplay_slides' ) ,
									'value' => ( isset( $widget['autoplay_slides'] ) ) ? $widget['autoplay_slides'] : NULL,
									'label' => __( 'Autoplay Slides' , 'layerswp' )
								),
								'slide_time' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'slide_time' ) ,
									'id' => $this->get_field_id( 'slide_time' ) ,
									'min' => 1,
									'max' => 10,
									'placeholder' => __( 'Time in seconds, eg. 2' , 'layerswp' ),
									'value' => ( isset( $widget['slide_time'] ) ) ? $widget['slide_time'] : NULL,
									'label' => __( 'Slide Interval' , 'layerswp' ),
									'data' => array( 'show-if-selector' => '#' . $this->get_field_id( 'autoplay_slides' ), 'show-if-value' => 'true' )
								),
								'autoheight_slides' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'autoheight_slides' ) ,
									'id' => $this->get_field_id( 'autoheight_slides' ) ,
									'value' => ( isset( $widget['autoheight_slides'] ) ) ? $widget['autoheight_slides'] : NULL,
									'label' => __( 'Auto Height Slides' , 'layerswp' ),
								),
								'slide_height' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'slide_height' ) ,
									'id' => $this->get_field_id( 'slide_height' ) ,
									'value' => ( isset( $widget['slide_height'] ) ) ? $widget['slide_height'] : NULL,
									'label' => __( 'Slider Height' , 'layerswp' ),
									'data' => array( 'show-if-selector' => '#' . $this->get_field_id( 'autoheight_slides' ), 'show-if-value' => 'false' ),
								)
							)
					)
				) );

			$this->design_bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$widget, // Widget Values
				$design_bar_components, // Standard Components
				$design_bar_custom_components // Add-on Components
			); ?>
			<div class="layers-container-large" id="layers-slide-widget-<?php echo esc_attr( $this->number ); ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Sliders',
					'icon_class' =>'slider'
				) ); ?>

				<section class="layers-accordion-section layers-content">
						<?php echo $this->form_elements()->input(
							array(
								'type' => 'hidden',
								'name' => $this->get_field_name( 'slide_ids' ) ,
								'id' => 'slide_ids_input_' . $this->number,
								'value' => ( isset( $widget['slide_ids'] ) ) ? $widget['slide_ids'] : NULL
							)
						);

						echo $this->form_elements()->input(
							array(
								'type' => 'hidden',
								'name' => $this->get_field_name( 'focus_slide' ) ,
								'id' => $this->get_field_name( 'focus_slide' ) ,
								'value' => ( isset( $widget['focus_slide'] ) ) ? $widget['focus_slide'] : NULL,
								'data' => array(
									'focus-slide' => 'true'
								)
							)
						);

						// If we have some slides, let's break out their IDs into an array
						if( isset( $widget['slide_ids'] ) && '' != $widget['slide_ids'] ) $slides = wp_parse_id_list( $widget['slide_ids'] ); ?>

						<ul id="slide_list_<?php echo esc_attr( $this->number ); ?>" class="layers-accordions layers-accordions-sortable layers-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo esc_attr( $this->number ); ?>">
							<?php if( isset( $slides ) && is_array( $widget['slides'] ) ) { ?>
								<?php foreach( $slides as $slide ) {
									$this->slide_item( array(
												'id_base' => $this->id_base ,
												'number' => $this->number
											) ,
											$slide ,
											( isset( $widget[ 'slides' ][ $slide ] ) ) ? $widget[ 'slides' ][ $slide ] : NULL );
								} ?>
							<?php } ?>
						</ul>
						<button class="layers-button btn-full layers-add-widget-slide add-new-widget" data-number="<?php echo esc_attr( $this->number ); ?>"><?php _e( 'Add New Slide' , 'layerswp' ) ; ?></button>
				</section>

			</div>

		<?php } // Form

		function slide_item( $widget_details = array() , $slide_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs

			// $instance Defaults
			$instance_defaults = $this->slide_defaults;

			// Clear the defaults if they're not needed
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$slide = wp_parse_args( $instance, $instance_defaults );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $slide_guid ) ) $slide_guid = rand( 1 , 1000 );

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->slide_item_count ) ) {
				$this->slide_item_count = 0;
			} else {
				$this->slide_item_count++;
			}?>

				<li class="layers-accordion-item <?php echo $this->slide_item_count; ?>" data-guid="<?php echo $slide_guid; ?>">
					<a class="layers-accordion-title">
						<span>
							<?php _e( 'Slide' , 'layerswp' ); ?>
							<span class="layers-detail">
								<?php echo ( isset( $slide['title'] ) ? ': ' . substr( stripslashes( strip_tags( $slide['title'] ) ), 0 , 50 ) : NULL ); ?>
								<?php echo ( isset( $slide['title'] ) && strlen( $slide['title'] ) > 50 ? '...' : NULL ); ?>
							</span>
						</span>
					</a>
					<section class="layers-accordion-section layers-content">
						<?php $this->design_bar(
							'top', // CSS Class Name
							array(
								'name' => $this->get_custom_field_name( $widget_details, 'slides',  $slide_guid, 'design' ),
								'id' => $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'design' ),
								'number' => $widget_details->number,
								'show_trash' => true
							), // Widget Object
							$slide, // Widget Values
							array(
								'background',
								'featuredimage',
								'imagealign',
								'fonts',
							) // Standard Components
						); ?>

						<div class="layers-row">
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'title' ); ?>"><?php _e( 'Title' , 'layerswp' ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'slides',  $slide_guid, 'title' ),
										'id' => $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'title' ),
										'placeholder' => __( 'Enter a Title' , 'layerswp' ),
										'placeholder' => __( 'Enter title here' , 'layerswp' ),
										'value' => ( isset( $slide['title'] ) ) ? $slide['title'] : NULL ,
										'class' => 'layers-text'
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'excerpt' ); ?>"><?php _e( 'Excerpt' , 'layerswp' ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'rte',
										'name' => $this->get_custom_field_name( $widget_details, 'slides',  $slide_guid, 'excerpt' ),
										'id' => $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'excerpt' ),
										'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
										'value' => ( isset( $slide['excerpt'] ) ) ? $slide['excerpt'] : NULL ,
										'disallow_buttons' => array( 'insertOrderedList','insertUnorderedList' ),
										'class' => 'layers-textarea',
										'rows' => 6
									)
								); ?>
							</p>
							<div class="layers-row">
								<p class="layers-form-item layers-column layers-span-6">
									<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Button Link' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_custom_field_name( $widget_details, 'slides',  $slide_guid, 'link' ),
											'id' => $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'link' ),
											'placeholder' => __( 'http://' , 'layerswp' ),
											'value' => ( isset( $slide['link'] ) ) ? $slide['link'] : NULL ,
										)
									); ?>
								</p>
								<p class="layers-form-item layers-column layers-span-6">
									<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Button Text' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_custom_field_name( $widget_details, 'slides',  $slide_guid, 'link_text' ),
											'id' => $this->get_custom_field_id( $widget_details, 'slides',  $slide_guid, 'link_text' ),
											'placeholder' => __( 'e.g. "Read More"' , 'layerswp' ),
											'value' => ( isset( $slide['link_text'] ) ) ? $slide['link_text'] : NULL ,
										)
									); ?>
								</p>
							</div>
						</div>
					</section>
				</li>
		<?php }

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Slider_Widget");
}