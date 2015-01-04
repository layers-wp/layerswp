<?php  /**
 * Sliders Widget
 *
 * This file is used to register and display the Layers - Slider widget.
 *
 * @package Layers
 * @since Layers 1.0
 */
if( !class_exists( 'Layers_Slider_Widget' ) ) {
	class Layers_Slider_Widget extends Layers_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Sliders';
		private $widget_id = 'banner';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array(
				'show_slider_arrows',
				'show_slider_dots',
				'autoplay_banners'
			);

		/**
		*  Widget construction
		*/
	 	function Layers_Slider_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , '(' . LAYERS_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'banner_height' => '550',
				'banner_ids' => rand( 1 , 1000 ),
				'show_slider_arrows' => true,
				'show_slider_dots' => true,

			);

			$this->banner_defaults = array (
				'title' => 'Slider Title',
				'excerpt' => 'Short Excerpt',
				'link' => NULL,
				'link_text' => 'See More',
				'design' => array(
					'imagealign' => 'image-top',
					'imageratios' => NULL,
					'background' => array(
						'position' => 'center',
						'repeat' => 'no-repeat',
						'color' => '#000',
						'size' => 'cover'
					),
					'fonts' => array(
						'align' => 'text-center',
						'size' => 'large',
						'color' => '#fff',
						'shadow' => ''
					)
				)
			);

			// Setup the defaults for each banner
			$this->defaults[ 'banners' ][ $this->defaults[ 'banner_ids' ] ] = $this->banner_defaults;

		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			// Setup the layout class for boxed/full width/full screen
			if( 'layout-boxed' == $this->check_and_return( $widget , 'design' , 'layout' ) ) {
				$layout_class = 'container';
			} elseif('layout-full-screen' == $this->check_and_return( $widget , 'design' , 'layout' ) ) {
				$layout_class = 'full-screen';
			}

			// Output custom css if there is any
			if( !empty( $widget['design']['advanced'][ 'customcss' ] ) ){
				wp_add_inline_style( LAYERS_THEME_SLUG . '-custom-widget-styles', $widget['design']['advanced'][ 'customcss' ] );
			} ?>

			<section class="widget row banner swiper-container <?php if( isset( $layout_class ) ) echo $layout_class; ?> <?php echo $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ) ?>" id="<?php echo $widget_id; ?>" <?php if( $this->check_and_return( $widget , 'banner_height' ) ) echo 'style="height: ' . $widget['banner_height'] . 'px;"' ?>>
				<?php if( !empty( $widget[ 'banners' ] ) ) { ?>
					<?php if( 1 < count( $widget[ 'banners' ] ) && isset( $widget['show_slider_arrows'] ) ) { ?>
						 <div class="arrows">
							<a href="" class="h-left-arrow animate"></a>
							<a href="" class="h-right-arrow animate"></a>
						</div>
					<?php } ?>
					<div class="pages animate">
						<?php for( $i = 0; $i < count( $widget[ 'banners' ] ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>
			 		<div class="swiper-wrapper">
						<?php $col = 1; ?>
						<?php foreach ( $widget[ 'banners' ] as $key => $banner) {

							// Set the background styling
							if( !empty( $banner['design'][ 'background' ] ) ) layers_inline_styles( $widget_id . '-' . $key , 'background', array( 'background' => $banner['design'][ 'background' ] ) );
							if( !empty( $banner['design']['fonts'][ 'color' ] ) ) layers_inline_styles( $widget_id . '-' . $key , 'color', array( 'selectors' => array( 'h3.heading', 'h3.heading a', 'div.excerpt' ) , 'color' => $banner['design']['fonts'][ 'color' ] ) );
							if( !empty( $banner['design']['fonts'][ 'shadow' ] ) ) layers_inline_styles( $widget_id . '-' . $key , 'text-shadow', array( 'selectors' => array( 'h3.heading', 'h3.heading a',  'div.excerpt' )  , 'text-shadow' => $banner['design']['fonts'][ 'shadow' ] ) );

							// Set Image Sizes
							if( isset( $banner['design'][ 'imageratios' ] ) ){
									// Translate Image Ratio
									$image_ratio = layers_translate_image_ratios( $banner['design'][ 'imageratios' ] );

									// If round then set image to square, and set border radius css further down.
									if( 'round' == $image_ratio ){
										$image_ratio = 'square';
									}

									$imageratios = $image_ratio . '-medium';
							} else {
								$imageratios = 'large';
							} ?>

							<div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="invert swiper-slide
								<?php if( false != $this->check_and_return( $banner , 'image' ) || 'image-left' == $banner['design'][ 'imagealign' ] || 'image-right' == $banner['design'][ 'imagealign' ] ) echo 'has-image'; ?>
								<?php if( isset( $banner['design'][ 'imagealign' ] ) && '' != $banner['design'][ 'imagealign' ] ) echo $banner['design'][ 'imagealign' ]; ?>
								<?php if( isset( $banner['design']['fonts'][ 'align' ] ) && '' != $banner['design']['fonts'][ 'align' ] ) echo $banner['design']['fonts'][ 'align' ]; ?>
								"
								style="float: left;">
								<div class="overlay <?php if( isset( $banner['design'][ 'background' ][ 'darken' ] ) ) echo 'darken'; ?>"  <?php if( $this->check_and_return( $widget , 'banner_height' ) ) echo 'style="height: ' . $widget['banner_height'] . 'px;"' ?>>
									<div class="container clearfix">
										<?php if( '' != $banner['title'] || '' != $banner['excerpt'] || '' != $banner['link'] ) { ?>
											<div class="copy-container">
												<div class="section-title <?php echo ( isset( $banner['design']['fonts'][ 'size' ] ) ? $banner['design']['fonts'][ 'size' ] : '' ); ?>">
													<?php if( $this->check_and_return( $banner , 'title' ) ) { ?>
														<?php if( $this->check_and_return( $banner , 'link' ) ) { ?>
															<h3 class="heading"><a href="<?php echo $banner['link']; ?>"><?php echo $banner['title']; ?></a></h3>
														<?php } else { ?>
															<h3 class="heading"><?php echo $banner['title']; ?></h3>
														<?php } ?>
													<?php } ?>
													<?php if( $this->check_and_return( $banner , 'excerpt' ) ) { ?>
														<div class="excerpt"><?php echo $banner['excerpt']; ?></div>
													<?php } ?>
													<?php if( isset( $banner['link'] ) && $this->check_and_return( $banner , 'link_text' ) ) { ?>
														<a href="<?php echo $banner['link']; ?>" class="button btn-<?php echo $this->check_and_return( $banner , 'design' , 'fonts' , 'size' ); ?>"><?php echo $banner['link_text']; ?></a>
													<?php } ?>
												</div>
											</div>
										<?php } // if title || excerpt ?>
										<?php if( $this->check_and_return( $banner , 'design' , 'featuredimage' ) ) { ?>
											<div class="image-container <?php if ( 'round' == layers_translate_image_ratios( $module['design'][ 'imageratios' ] ) ) { ?>image-rounded<?php } ?>">
												<?php echo wp_get_attachment_image( $banner['design'][ 'featuredimage' ] , $imageratios ); ?>
											</div>
										<?php } // if $banner image ?>
									</div> <!-- .container -->
								</div> <!-- .overlay -->
							</div>
						<?php } // foreach slides ?>
			 		</div>
				<?php } // if !empty( $widget->slides ) ?>
		 	</section>
		 	<?php if( !empty( $widget[ 'banners' ] ) ) { ?>
			 	<script>
					jQuery(function($){

						var swiper = $('#<?php echo $widget_id; ?>').swiper({
							//Your options here:
							mode:'horizontal',
							<?php if( isset( $widget['show_slider_dots'] ) ) { ?>pagination: '.pages',<?php } ?>
							// slidesPerView: 4,
							paginationClickable: true,
							watchActiveIndex: true,
							loop: true
							<?php if( isset( $widget['autoplay_banners'] ) && isset( $widget['slide_time'] ) && is_numeric( $widget['slide_time'] ) ) {?>, autoplay: <?php echo ($widget['slide_time']*1000); ?><?php }?>
						});

						<?php if( 1 < count( $widget[ 'banners' ] ) ) { ?>
							// Allow keyboard control
							swiper.enableKeyboardControl();
						<?php } // if > 1 slide ?>
						$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
							e.preventDefault();

							// "Hi Mom"
							$that = $(this);

							if( $that.hasClass( 'swiper-pagination-switch' ) ){ // Anchors
								swiper.swipeTo( $that.index() );
							} else if( $that.hasClass( 'h-left-arrow' ) ){ // Previous
								swiper.swipePrev();
							} else if( $that.hasClass( 'h-right-arrow' ) ){ // Next
								swiper.swipeNext();
							}

							return false;
						});

					})
			 	</script>
			<?php } // if !empty( $widget->slides ) ?>
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
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP ); ?>
			<!-- Form HTML Here -->
			<?php $this->design_bar()->bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$instance, // Widget Values
				array(
					'custom',
					'advanced'
				), // Standard Components
				array(
					'layout' => array(
						'icon-css' => 'icon-layout-fullwidth',
						'label' => 'Layout',
						'wrapper-css' => 'layers-pop-menu-wrapper layers-small',
						'elements' => array(
							'layout' => array(
								'type' => 'select-icons',
								'label' => __( '', LAYERS_THEME_SLUG ),
								'name' => $this->get_field_name( 'design' ) . '[layout]' ,
								'id' => $this->get_field_id( 'design-layout' ) ,
								'value' => ( isset( $design['layout'] ) ) ? $design['layout'] : NULL,
								'options' => array(
									'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
									'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG ),
									'layout-full-screen' => __( 'Full Screen' , LAYERS_THEME_SLUG )
								)
							)
						)
					),
					'display' => array(
						'icon-css' => 'icon-slider',
						'label' => 'Slider',
						'elements' => array(
								'show_slider_arrows' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_slider_arrows' ) ,
									'id' => $this->get_field_id( 'show_slider_arrows' ) ,
									'value' => ( isset( $show_slider_arrows ) ) ? $show_slider_arrows : NULL,
									'label' => __( 'Show Slider Arrows', LAYERS_THEME_SLUG )
								),
								'show_slider_dots' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_slider_dots' ) ,
									'id' => $this->get_field_id( 'show_slider_dots' ) ,
									'value' => ( isset( $show_slider_dots ) ) ? $show_slider_dots : NULL,
									'label' => __( 'Show Slider Dots', LAYERS_THEME_SLUG )
								),
								'autoplay_banners' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'autoplay_banners' ) ,
									'id' => $this->get_field_id( 'autoplay_banners' ) ,
									'value' => ( isset( $autoplay_banners ) ) ? $autoplay_banners : NULL,
									'label' => __( 'Autoplay Slides', LAYERS_THEME_SLUG )
								),
								'slide_time' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'slide_time' ) ,
									'id' => $this->get_field_id( 'slide_time' ) ,
									'min' => 1,
									'max' => 10,
									'placeholder' => __( 'Leave blank for no slide', LAYERS_THEME_SLUG ),
									'value' => ( isset( $slide_time ) ) ? $slide_time : NULL,
									'label' => __( 'Slide Interval', LAYERS_THEME_SLUG )
								),
								'banner_height' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'banner_height' ) ,
									'id' => $this->get_field_id( 'banner_height' ) ,
									'value' => ( isset( $banner_height ) ) ? $banner_height : NULL,
									'label' => __( 'Slider Height', LAYERS_THEME_SLUG )
								)
							)
					)
				)
			); ?>
			<div class="layers-container-large" id="layers-banner-widget-<?php echo $this->number; ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Sliders',
					'icon_class' =>'slider'
				) ); ?>

				<section class="layers-accordion-section layers-content">
						<?php echo $this->form_elements()->input(
							array(
								'type' => 'hidden',
								'name' => $this->get_field_name( 'banner_ids' ) ,
								'id' => 'banner_ids_input_' . $this->number,
								'value' => ( isset( $banner_ids ) ) ? $banner_ids : NULL
							)
						); ?>

						<?php // If we have some banners, let's break out their IDs into an array
						if( isset( $banner_ids ) && '' != $banner_ids ) $banners = explode( ',' , $banner_ids ); ?>

						<ul id="banner_list_<?php echo $this->number; ?>" class="layers-accordions layers-accordions-sortable layers-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
							<?php if( isset( $banners ) && is_array( $banners ) ) { ?>
								<?php foreach( $banners as $banner ) {
									$this->banner_item( array(
												'id_base' => $this->id_base ,
												'number' => $this->number
											) ,
											$banner ,
											( isset( $instance[ 'banners' ][ $banner ] ) ) ? $instance[ 'banners' ][ $banner ] : NULL );
								} ?>
							<?php } else { ?>
								<?php $this->banner_item( array( 'id_base' => $this->id_base , 'number' => $this->number ) ); ?>
							<?php }?>
							<li class="layers-button btn-primary layers-add-widget-banner" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Slider' , LAYERS_THEME_SLUG ) ; ?></li>
						</ul>

				</section>

			</div>

		<?php } // Form

		function banner_item( $widget_details = array() , $slide_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs


			// $instance Defaults
			$instance_defaults = $this->banner_defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $slide_guid ) ) $slide_guid = rand( 1 , 1000 );



			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->banner_item_count ) ) {
				$this->banner_item_count = 0;
			} else {
				$this->banner_item_count++;
			}?>

				<li class="layers-accordion-item <?php echo $this->banner_item_count; ?>" data-guid="<?php echo $slide_guid; ?>">
					<a class="layers-accordion-title">
						<span>
							<?php _e( 'Slider' , LAYERS_THEME_SLUG ); ?><span class="layers-detail"><?php echo ( isset( $title ) ? ': ' . $title : NULL ); ?></span>
						</span>
					</a>
					<section class="layers-accordion-section layers-content">
						<?php $this->design_bar()->bar(
							'top', // CSS Class Name
							array(
								'name' => $this->get_custom_field_name( $widget_details, 'banners',  $slide_guid, 'design' ),
								'id' => $this->get_custom_field_id( $widget_details, 'banners',  $slide_guid, 'design' ),
								'number' => $widget_details->number,
								'show_trash' => true
							), // Widget Object
							$instance, // Widget Values
							array(
								'background',
								'featuredimage',
								'imagealign',
								'fonts',
							) // Standard Components
						); ?>

						<div class="layers-row">
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'banners',  $column_guid, 'title' ); ?>"><?php _e( 'Title' , LAYERS_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'banners',  $slide_guid, 'title' ),
										'id' => $this->get_custom_field_id( $widget_details, 'banners',  $slide_guid, 'title' ),
										'placeholder' => __( 'Enter a Title' , LAYERS_THEME_SLUG ),
										'placeholder' => __( 'Enter title here', LAYERS_THEME_SLUG ),
										'value' => ( isset( $title ) ) ? $title : NULL ,
										'class' => 'layers-text'
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'banners',  $column_guid, 'excerpt' ); ?>"><?php _e( 'Excerpt' , LAYERS_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'textarea',
										'name' => $this->get_custom_field_name( $widget_details, 'banners',  $slide_guid, 'excerpt' ),
										'id' => $this->get_custom_field_id( $widget_details, 'banners',  $slide_guid, 'excerpt' ),
										'placeholder' => __( 'Short Excerpt', LAYERS_THEME_SLUG ),
										'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
										'class' => 'layers-textarea',
										'rows' => 6
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link' , LAYERS_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'banners',  $slide_guid, 'link' ),
										'id' => $this->get_custom_field_id( $widget_details, 'banners',  $slide_guid, 'link' ),
										'placeholder' => __( 'http://', LAYERS_THEME_SLUG ),
										'value' => ( isset( $link ) ) ? $link : NULL ,
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Button Text' , LAYERS_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'banners',  $slide_guid, 'link_text' ),
										'id' => $this->get_custom_field_id( $widget_details, 'banners',  $slide_guid, 'link_text' ),
										'placeholder' => __( 'e.g. "Read More"' , LAYERS_THEME_SLUG ),
										'value' => ( isset( $link_text ) ) ? $link_text : NULL ,
									)
								); ?>
							</p>
						</div>
					</section>
				</li>
		<?php }

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Slider_Widget");
}