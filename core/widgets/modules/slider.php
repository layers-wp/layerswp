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
			* @param  	string    		$this->widget_id    	Widget title
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
					'autoplay_slides',
					'autoheight_slides',
				);

	 		/* Widget settings. */
			$widget_ops = array(

				'classname'   => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display slides and can be used to display a page-banner.', 'layerswp' ) ,
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'   => LAYERS_WIDGET_WIDTH_LARGE,
				'height'  => NULL,
				'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id,
			);

			/* Create the widget. */
			parent::__construct(
				LAYERS_THEME_SLUG . '-widget-' . $this->widget_id ,
				$this->widget_title,
				$widget_ops,
				$control_ops
			);

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'slide_height' => '550',
				'show_slider_arrows' => 'on',
				'show_slider_dots' => 'on',
				'animation_type' => 'slide',
			);

			/* Setup Widget Repeater Defaults */
			$this->register_repeater_defaults( 'slide', 2, array(
				'title' => __( 'Slider Title', 'layerswp' ),
				'excerpt' => __( 'Short Excerpt', 'layerswp' ),
				'design' => array(
					'imagealign' => 'image-top',
					'imageratios' => NULL,
					'background' => array(
						'color' => '#f8f8f8',
						'position' => 'center',
						'repeat' => 'no-repeat',
						'size' => 'cover'
					),
					'fonts' => array(
						'color' => NULL,
						'align' => 'text-center',
						'size' => 'large',
						'shadow' => '',
						'heading-type' => 'h3',
					)
				),
				'button' => array(
					'link_type' => 'custom',
					'link_type_custom' => '#more',
					'link_text' => __( 'See More', 'layerswp' ),
				),
			) );

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

			$this->backup_inline_css();

			// Turn $args array into variables.
			extract( $args );

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}
			
			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );

			// Enqueue Scipts when needed
			$this->enqueue_scripts();

			// Apply slider arrow color
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.arrows a' ), 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'border', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'border' => array( 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'background' => array( 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( 'span.swiper-pagination-switch.swiper-active-switch' ), 'background' => array( 'color' => 'transparent !important' ) ) );


			// Get slider height css
			$slider_height_css = '';
			if( 'layout-full-screen' != $this->check_and_return( $instance , 'design', 'layout' ) && FALSE == $this->check_and_return( $instance , 'autoheight_slides' ) && $this->check_and_return( $instance , 'slide_height' ) ) {
				$slider_height_css = 'height: ' . $instance['slide_height'] . 'px; ';
			}

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-slider-widget';
			$widget_container_class[] = 'row';
			$widget_container_class[] = 'slide';
			$widget_container_class[] = 'swiper-container';
			$widget_container_class[] = $this->check_and_return( $instance , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $instance );
			$widget_container_class[] = $this->get_widget_layout_class( $instance );

			if( $this->check_and_return( $instance , 'autoheight_slides' ) ) {
				if( FALSE !== ( $fullwidth = array_search( 'full-screen', $widget_container_class ) ) ){
					unset( $widget_container_class[ $fullwidth ] );
				}
				$widget_container_class[] = 'auto-height';
			}

			if( $this->check_and_return( $instance , 'design', 'layout') ) {
				// Slider layout eg 'slider-layout-full-screen'
				$widget_container_class[] = 'slider-' . $instance['design']['layout'];
			}
			if( ( ! isset( $instance['design']['layout'] ) || ( isset( $instance['design']['layout'] ) && 'layout-full-screen' != $instance['design']['layout'] ) ) ) {
				// If slider is not full screen
				$widget_container_class[] = 'not-full-screen';
			}
			if( 1 == count( $instance[ 'slides' ] ) ) {
				// If only one slide
				$widget_container_class[] = 'single-slide';
			}

			$widget_container_class = apply_filters( 'layers_slider_widget_container_class' , $widget_container_class, $this, $instance );
			$widget_container_class = implode( ' ', $widget_container_class );

			/**
			 * Slider HTML
			 */

			if( ! empty( $instance[ 'slides' ] ) ) { ?>
				<?php echo $this->custom_anchor( $instance ); ?>
				<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>" style="<?php echo esc_attr( $slider_height_css ); ?>">

					<?php do_action( 'layers_before_slider_widget_inner', $this, $instance ); ?>

					<?php if( 1 < count( $instance[ 'slides' ] ) && isset( $instance['show_slider_arrows'] ) ) { ?>
						 <div class="arrows">
							<a href="" class="l-left-arrow animate"></a>
							<a href="" class="l-right-arrow animate"></a>
						</div>
					<?php } ?>

					<div class="<?php echo $this->get_layers_field_id( 'pages' ); ?> pages animate">
						<?php for( $i = 0; $i < count( $instance[ 'slides' ] ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>

			 		<div class="swiper-wrapper">
						<?php foreach ( wp_parse_id_list( $instance[ 'slide_ids' ] ) as $slide_key ) {

							// Make sure we've got a column going on here
							if( !isset( $instance[ 'slides' ][ $slide_key ] ) ) continue;

							// Setup the relevant slide
							$item_instance = $instance[ 'slides' ][ $slide_key ];
							
							// Mix in new/unset defaults on every instance load (NEW)
							$item_instance = $this->apply_defaults( $item_instance, 'slide' );

							// Set the background styling
							if( !empty( $item_instance['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'background', array( 'background' => $item_instance['design'][ 'background' ] ) );
							if( !empty( $item_instance['design']['fonts'][ 'color' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'color', array( 'selectors' => array( '.heading', '.heading a', 'div.excerpt' ) , 'color' => $item_instance['design']['fonts'][ 'color' ] ) );
							if( !empty( $item_instance['design']['fonts'][ 'shadow' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $slide_key , 'text-shadow', array( 'selectors' => array( '.heading', '.heading a',  'div.excerpt' )  , 'text-shadow' => $item_instance['design']['fonts'][ 'shadow' ] ) );

							// Set the button styling
							$button_size = '';
							if ( function_exists( 'layers_pro_apply_widget_button_styling' ) ) {
								$button_size = $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) ? 'btn-' . $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) : '' ;
								$this->inline_css .= layers_pro_apply_widget_button_styling( $this, $item_instance, array( "#{$widget_id}-{$slide_key} .button" ) );
							}

							// Set Featured Media
							$featureimage = $this->check_and_return( $item_instance , 'design' , 'featuredimage' );
							$featurevideo = $this->check_and_return( $item_instance , 'design' , 'featuredvideo' );

							// Set Image Sizes
							if( isset( $item_instance['design'][ 'imageratios' ] ) ){

									// Translate Image Ratio into something usable
									$image_ratio = layers_translate_image_ratios( $item_instance['design'][ 'imageratios' ] );
									$use_image_ratio = $image_ratio . '-medium';

							} else {
								$use_image_ratio = 'large';
							}

							// Get the button array.
							$link_array       = $this->check_and_return_link( $item_instance, 'button' );
							$link_href_attr   = ( $link_array['link'] ) ? 'href="' . esc_url( $link_array['link'] ) . '"' : '';
							$link_target_attr = ( '_blank' == $link_array['target'] ) ? 'target="_blank"' : '';

 							/**
							* Set Individual Slide CSS
							*/
							$slide_class = array();
							$slide_class[] = 'swiper-slide';
							if( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) {
								if( 'dark' == layers_is_light_or_dark( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) ) {
									$slide_class[] = 'invert';
								}
							} else {
								$slide_class[] = 'invert';
							}
							if( false != $this->check_and_return( $item_instance , 'image' ) || 'image-left' == $item_instance['design'][ 'imagealign' ] || 'image-top' == $item_instance['design'][ 'imagealign' ] ) {
								$slide_class[] = 'has-image';
							}
							if( isset( $item_instance['design'][ 'imagealign' ] ) && '' != $item_instance['design'][ 'imagealign' ] ) {
								$slide_class[] = $item_instance['design'][ 'imagealign' ];
							}
							if( isset( $item_instance['design']['fonts'][ 'align' ] ) && '' != $item_instance['design']['fonts'][ 'align' ] ) {
								$slide_class[] = $item_instance['design']['fonts'][ 'align' ];
							}
							$slide_class[] = $this->check_and_return( $item_instance, 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.

							$slide_class = apply_filters( 'layers_slider_widget_item_class', $slide_class, $this, $item_instance, $instance );
							$slide_class = implode( ' ', $slide_class );

							// Set link entire slide or not
							$slide_wrapper_tag = 'div';
							$slide_wrapper_href = '';

							if( $link_array['link'] && ! $link_array['text'] ) {
								$slide_wrapper_tag = 'a';
								$slide_wrapper_href = $link_href_attr;
							} ?>
							<<?php echo $slide_wrapper_tag; ?> <?php echo $slide_wrapper_href; ?> class="<?php echo $slide_class; ?>" id="<?php echo $widget_id; ?>-<?php echo $slide_key; ?>" style="float: left; <?php echo $slider_height_css; ?>" <?php echo $link_target_attr; ?>>

								<?php do_action( 'layers_before_slider_widget_item_inner', $this, $item_instance, $instance ); ?>

								<?php
								/**
								* Set Overlay CSS Classes
								*/
								$overlay_class = array();
								$overlay_class[] = 'overlay';
								if( isset( $item_instance['design'][ 'background' ][ 'darken' ] ) ) {
									$overlay_class[] = 'darken';
								}
								if( '' != $this->check_and_return( $item_instance, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $item_instance, 'design' , 'background', 'color' ) ) {
									$overlay_class[] = 'content';
								}
								$overlay_classes = implode( ' ', $overlay_class ); ?>
								
								<div class="<?php echo $overlay_classes; ?>" >
									<div class="container clearfix">
										<?php if( '' != $item_instance['title'] || '' != $item_instance['excerpt'] || '' != $link_array['link'] ) { ?>
											<div class="copy-container">
												<div class="section-title <?php echo ( isset( $item_instance['design']['fonts'][ 'size' ] ) ? $item_instance['design']['fonts'][ 'size' ] : '' ); ?>">
													<?php if( $this->check_and_return( $item_instance , 'title' ) ) { ?>
														<<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ); ?> data-swiper-parallax="-100" class="heading">
															<?php echo $item_instance['title']; ?>
														</<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ); ?>>
													<?php } ?>
													<?php if( $this->check_and_return( $item_instance , 'excerpt' ) ) { ?>
														<div data-swiper-parallax="-300" class="excerpt"><?php layers_the_content( $item_instance['excerpt'] ); ?></div>
													<?php } ?>
													<?php if( 'div' == $slide_wrapper_tag && $link_array['link'] && $link_array['text'] ) { ?>
														<a data-swiper-parallax="-200" <?php echo $link_href_attr; ?> <?php echo $link_target_attr; ?> class="button <?php echo $button_size; ?>">
															<?php echo $link_array['text']; ?>
														</a>
													<?php } ?>
												</div>
											</div>
										<?php } // if title || excerpt ?>
										<?php if( $featureimage || $featurevideo ) { ?>
											<div class="image-container <?php echo ( 'image-round' ==  $this->check_and_return( $item_instance, 'design',  'imageratios' ) ? 'image-rounded' : '' ); ?>">
												<?php echo layers_get_feature_media(
													$featureimage ,
													$use_image_ratio ,
													$featurevideo
												); ?>
											</div>
										<?php } // if $item image  ?>
									</div> <!-- .container -->
								</div> <!-- .overlay -->

								<?php do_action( 'layers_after_slider_widget_item_inner', $this, $item_instance, $instance ); ?>

							</<?php echo $slide_wrapper_tag; ?>>
						<?php } // foreach slides ?>
					</div>

					<?php do_action( 'layers_after_slider_widget_inner', $this, $instance );

					// Print the Inline Styles for this Widget
					$this->print_inline_css();

					/**
					 * Slider javascript initialize
					 */
					$swiper_js_obj = str_replace( '-' , '_' , $this->get_layers_field_id( 'slider' ) ); ?>
					<script type='text/javascript'>
						jQuery(function($){

							var <?php echo $swiper_js_obj; ?> = $('#<?php echo $widget_id; ?>').swiper({
							mode:'horizontal'
							,bulletClass: 'swiper-pagination-switch'
							,bulletActiveClass: 'swiper-active-switch swiper-visible-switch'
							,paginationClickable: true
							,watchActiveIndex: true
							<?php if( 'fade' ==  $this->check_and_return( $instance, 'animation_type' ) ) { ?>
								,effect: '<?php echo $instance['animation_type']; ?>'
							<?php } else if( 'parallax' ==  $this->check_and_return( $instance, 'animation_type' ) ) { ?>
								,speed: 700
								,parallax: true
								<?php } ?>
								<?php if( isset( $instance['show_slider_dots'] ) && ( !empty( $instance[ 'slides' ] ) && 1 < count( $instance[ 'slides' ] ) ) ) { ?>
								,pagination: '.<?php echo $this->get_layers_field_id( 'pages' ); ?>'
								<?php } ?>
								<?php if( 1 < count( $instance[ 'slides' ] ) ) { ?>
									,loop: true
							<?php } else { ?>
								,loop: false
								,noSwiping: true
								,allowSwipeToPrev: false
								,allowSwipeToNext: false
								<?php } ?>
								<?php if( isset( $instance['autoplay_slides'] ) && isset( $instance['slide_time'] ) && is_numeric( $instance['slide_time'] ) ) {?>
									, autoplay: <?php echo ($instance['slide_time']*1000); ?>
								<?php }?>
								<?php if( isset( $wp_customize ) && $this->check_and_return( $instance, 'focus_slide' ) ) { ?>
									,initialSlide: <?php echo $this->check_and_return( $instance, 'focus_slide' ); ?>
								<?php } ?>
							});

							<?php if( 1 < count( $instance[ 'slides' ] ) ) { ?>
								// Allow keyboard control
								<?php echo $swiper_js_obj; ?>.enableKeyboardControl();
							<?php } // if > 1 slide ?>

							<?php if( TRUE == $this->check_and_return( $instance , 'autoheight_slides' ) ) { ?>
								layers_swiper_resize( <?php echo $swiper_js_obj; ?> );
								$(window).resize(function(){
									layers_swiper_resize( <?php echo $swiper_js_obj; ?> );
								});
							<?php } ?>

							$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
								e.preventDefault();

								// "Hi Mom"
								$that = $(this);

								if( $that.hasClass( 'swiper-pagination-switch' ) ){
									// Anchors
									<?php echo $swiper_js_obj; ?>.slideTo( $that.index() );
								} else if( $that.hasClass( 'l-left-arrow' ) ){
									// Previous
									<?php echo $swiper_js_obj; ?>.slidePrev();
								} else if( $that.hasClass( 'l-right-arrow' ) ){
									// Next
									<?php echo $swiper_js_obj; ?>.slideNext();
								}

								return false;
							});

							<?php echo $swiper_js_obj; ?>.init();
						});
					</script>

				</div>
			<?php }

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $instance );

		}

		/**
		*  Widget update
		*/
	 	function update( $new_instance, $old_instance ) {

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
		*/
		function form( $instance ){

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}
			
			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );
			
			$components = apply_filters( 'layers_slide_widget_design_bar_components', array(
				'layout' => array(
					'icon-css' => 'icon-layout-fullwidth',
					'label' => __( 'Layout', 'layerswp' ),
					'wrapper-class' => 'layers-pop-menu-wrapper layers-small',
					'elements' => array(
						'layout' => array(
							'type' => 'select-icons',
							'label' => __( '' , 'layerswp' ),
							'name' => $this->get_layers_field_name( 'design', 'layout' ) ,
							'id' => $this->get_layers_field_id( 'design', 'layout' ) ,
							'value' => ( isset( $instance['design']['layout'] ) ) ? $instance['design']['layout'] : NULL,
							'options' => array(
								'layout-boxed' => __( 'Boxed' , 'layerswp' ),
								'layout-fullwidth' => __( 'Full Width' , 'layerswp' ),
								'layout-full-screen' => __( 'Full Screen' , 'layerswp' )
							),
						),
					),
				),
				'display' => array(
					'icon-css' => 'icon-slider',
					'label' => __( 'Slider', 'layerswp' ),
					'elements' => array(
						'autoheight_slides' => array(
							'type' => 'checkbox',
							'name' => $this->get_layers_field_name( 'autoheight_slides' ) ,
							'id' => $this->get_layers_field_id( 'autoheight_slides' ) ,
							'value' => ( isset( $instance['autoheight_slides'] ) ) ? $instance['autoheight_slides'] : NULL,
							'label' => __( 'Auto Height Slides' , 'layerswp' ),
						),
						'slide_height' => array(
							'type' => 'number',
							'name' => $this->get_layers_field_name( 'slide_height' ) ,
							'id' => $this->get_layers_field_id( 'slide_height' ) ,
							'value' => ( isset( $instance['slide_height'] ) ) ? $instance['slide_height'] : NULL,
							'label' => __( 'Slider Height (px)' , 'layerswp' ),
							'data' => array(
								'show-if-selector' => '#' . $this->get_layers_field_id( 'autoheight_slides' ),
								'show-if-value' => 'false',
							),
						),
						'show_slider_arrows' => array(
							'type' => 'checkbox',
							'name' => $this->get_layers_field_name( 'show_slider_arrows' ) ,
							'id' => $this->get_layers_field_id( 'show_slider_arrows' ) ,
							'value' => ( isset(  $instance['show_slider_arrows'] ) ) ?  $instance['show_slider_arrows'] : NULL,
							'label' => __( 'Show Slider Arrows' , 'layerswp' ),
						),
						'slider_arrow_color' => array(
							'type' => 'color',
							'name' => $this->get_layers_field_name( 'slider_arrow_color' ) ,
							'id' => $this->get_layers_field_id( 'slider_arrow_color' ) ,
							'value' => ( isset( $instance['slider_arrow_color'] ) ) ? $instance['slider_arrow_color'] : NULL,
							'label' => __( 'Slider Controls Color' , 'layers-woocommerce' ),
							'data' => array(
								'show-if-selector' => '#' . $this->get_layers_field_id( 'show_slider_arrows' ),
								'show-if-value' => 'true',
							),
						),
						'show_slider_dots' => array(
							'type' => 'checkbox',
							'name' => $this->get_layers_field_name( 'show_slider_dots' ) ,
							'id' => $this->get_layers_field_id( 'show_slider_dots' ) ,
							'value' => ( isset(  $instance['show_slider_dots'] ) ) ?  $instance['show_slider_dots'] : NULL,
							'label' => __( 'Show Slider Dots' , 'layerswp' ),
						),
						'animation_type' => array(
							'type' => 'select',
							'name' => $this->get_layers_field_name( 'animation_type' ) ,
							'id' => $this->get_layers_field_id( 'animation_type' ) ,
							'value' => ( isset(  $instance['animation_type'] ) ) ?  $instance['animation_type'] : 'slide',
							'label' => __( 'Animation Type' , 'layerswp' ),
							'options' => array(
								'slide' => __( 'Slide', 'layers_wp' ),
								'fade' => __( 'Fade', 'layers_wp' ),
								'parallax' => __( 'Parallax', 'layers_wp' ),
							),
						),
						'autoplay_slides' => array(
							'type' => 'checkbox',
							'name' => $this->get_layers_field_name( 'autoplay_slides' ) ,
							'id' => $this->get_layers_field_id( 'autoplay_slides' ) ,
							'value' => ( isset( $instance['autoplay_slides'] ) ) ? $instance['autoplay_slides'] : NULL,
							'label' => __( 'Autoplay Slides' , 'layerswp' ),
						),
						'slide_time' => array(
							'type' => 'number',
							'name' => $this->get_layers_field_name( 'slide_time' ) ,
							'id' => $this->get_layers_field_id( 'slide_time' ) ,
							'min' => 1,
							'max' => 10,
							'placeholder' => __( 'Time in seconds, eg. 2' , 'layerswp' ),
							'value' => ( isset( $instance['slide_time'] ) ) ? $instance['slide_time'] : NULL,
							'label' => __( 'Slide Interval (seconds)' , 'layerswp' ),
							'data' => array(
								'show-if-selector' => '#' . $this->get_layers_field_id( 'autoplay_slides' ),
								'show-if-value' => 'true',
							),
						),
					),
				),
				'advanced',
			), $this, $instance );
	
			// Legacy application of this filter - Do Not Use! (will be removed soon)
			$components = apply_filters( 'layers_slide_widget_design_bar_custom_components', $components );

			$this->design_bar(
				'side', // CSS Class Name
				array( // Widget Object
					'name' => $this->get_layers_field_name( 'design' ),
					'id' => $this->get_layers_field_id( 'design' ),
					'widget_id' => $this->widget_id,
				),
				$instance, // Widget Values
				$components // Components
			); ?>
			<div class="layers-container-large" id="layers-slide-widget-<?php echo esc_attr( $this->number ); ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Sliders',
					'icon_class' =>'slider'
				) ); ?>

				<?php echo $this->form_elements()->input(
					array(
						'type' => 'hidden',
						'name' => $this->get_layers_field_name( 'focus_slide' ) ,
						'id' => $this->get_layers_field_id( 'focus_slide' ) ,
						'value' => ( isset( $instance['focus_slide'] ) ) ? $instance['focus_slide'] : NULL,
						'data' => array(
							'focus-slide' => 'true'
						)
					)
				); ?>

				<section class="layers-accordion-section layers-content">
					<div class="layers-form-item">
						<?php $this->repeater( 'slide', $instance ); ?>
					</div>
				</section>

			</div>

		<?php }

		function slide_item( $item_guid, $item_instance ) {
			
			// Mix in new/unset defaults on every instance load (NEW)
			$item_instance = $this->apply_defaults( $item_instance, 'slide' );
			?>
			<li class="layers-accordion-item <?php echo $this->item_count; ?>" data-guid="<?php echo $item_guid; ?>">
				<a class="layers-accordion-title">
					<span>
						<?php _e( 'Slide' , 'layerswp' ); ?><span class="layers-detail"><?php echo ( isset( $item_instance['title'] ) ? ': ' . substr( stripslashes( strip_tags( $item_instance['title'] ) ), 0 , 50 ) : NULL ); ?><?php echo ( isset( $item_instance['title'] ) && strlen( $item_instance['title'] ) > 50 ? '...' : NULL ); ?></span>
					</span>
				</a>
				<section class="layers-accordion-section layers-content">
					<?php $this->design_bar(
						'top', // CSS Class Name
						array(
							'name' => $this->get_layers_field_name( 'design' ),
							'id' => $this->get_layers_field_id( 'design' ),
							'widget_id' => $this->widget_id . '_item',
							'number' => $this->number,
							'show_trash' => TRUE
						), // Widget Object
						$item_instance, // Widget Values
						apply_filters( 'layers_slide_widget_slide_design_bar_components', array( // Components
							'background',
							'featuredimage',
							'imagealign' => array(
								'elements' => array(
									'imagealign' => array(
										'options' => array(
											'image-left' => __( 'Left', 'layerswp' ),
											'image-right' => __( 'Right', 'layerswp' ),
											'image-top' => __( 'Top', 'layerswp' ),
											'image-bottom' => __( 'Bottom', 'layerswp' ),
										),
									),
								),
							),
							'fonts',
							'advanced' => array(
								'elements' => array(
									'customclass'
								),
								'elements_combine' => 'replace',
							),
						), $this, $item_instance )
					); ?>
					<div class="layers-row">
						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'title' ); ?>"><?php _e( 'Title' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'title' ),
									'id' => $this->get_layers_field_id( 'title' ),
									'placeholder' => __( 'Enter a Title' , 'layerswp' ),
									'value' => ( isset( $item_instance['title'] ) ) ? $item_instance['title'] : NULL ,
									'class' => 'layers-text'
								)
							); ?>
						</p>
						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'excerpt' ); ?>"><?php _e( 'Excerpt' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_layers_field_name( 'excerpt' ),
									'id' => $this->get_layers_field_id( 'excerpt' ),
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $item_instance['excerpt'] ) ) ? $item_instance['excerpt'] : NULL ,
									'disallow_buttons' => array( 'insertOrderedList','insertUnorderedList' ),
									'class' => 'layers-textarea',
									'rows' => 6
								)
							); ?>
						</p>

						<?php
						// Fix widget's that were created before dynamic linking structure.
						$item_instance = $this->convert_legacy_widget_links( $item_instance, 'button' );
						?>

						<div class="layers-form-item">
							<label>
								<?php _e( 'Insert Link' , 'layerswp' ); ?>
							</label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'link-group',
									'name' => $this->get_layers_field_name( 'button' ),
									'id' => $this->get_layers_field_id( 'button' ),
									'value' => ( isset( $item_instance['button'] ) ) ? $item_instance['button'] : NULL,
								)
							); ?>
						</div>

					</div>
				</section>
			</li>
			<?php
		}

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Slider_Widget");
}