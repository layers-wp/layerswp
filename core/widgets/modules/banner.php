<?php  /**
 * Banners Widget
 *
 * This file is used to register and display the Hatch - Banner widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Banner_Widget' ) ) {
	class Hatch_Banner_Widget extends WP_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Sliders';
		private $widget_id = 'banner';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array(
				'hide_slider_arrows',
				'autoplay_banners'
			);

		/**
		*  Widget construction
		*/
	 	function Hatch_Banner_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );
	 	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance; ?>

			<section class="widget row banner swiper-container" id="<?php echo $widget_id; ?>" <?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'style="height: ' . $widget->banner_height . 'px;"' ?>>
				<?php if( !empty( $widget->banners ) ) { ?>
					<?php if( 1 < count( $widget->banners ) ) { ?>
						 <div class="arrows">
							<a href="" class="arrow-left animate"></a>
							<a href="" class="arrow-right animate"></a>
						</div>
					<?php } ?>
					<div class="pages animate">
						<?php for( $i = 0; $i < count( $widget->banners ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>
			 		<div class="swiper-wrapper">
						<?php $col = 1; ?>
						<?php foreach ( $widget->banners as $key => $banner) {
							$banner = (object) $banner;?>
							<div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="invert swiper-slide <?php if( '' != $banner->image_layout ) echo $banner->image_layout; ?> <?php if( !empty( $banner->background ) ) echo 'with-background'; ?>"
								style="float: left;
								<?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'height: ' . $widget->banner_height . 'px;' ?>
								<?php if( !empty( $banner->background ) && 'image' == $banner->background['type'] ) { ?>
									<?php // Fetch bg image
									$image = wp_get_attachment_image_src( $banner->background['image'] , 'full' );?>
									background-image: url('<?php echo esc_html( $image[0] ); ?>');
									background-size: cover;
								<?php } ?>
								<?php if( isset( $banner->background['image_color'] ) && '' != $banner->background['image_color'] ) { ?>
									background-color: <?php echo $banner->background['image_color']; ?>;
								<?php } ?>">
								<div class="container" <?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'style="height: ' . $widget->banner_height . 'px;"' ?>><!-- height important for vertical positioning. Must match container height -->
									<?php if( '' != $banner->title || '' != $banner->excerpt ) { ?>
									<div class="copy-container">
										<!-- your dynamic output goes here -->
										<div class="section-title large">
											<?php if( isset( $banner->title ) && '' != $banner->title ) { ?>
												<h3 class="heading"><?php echo $banner->title; ?></h3>
											<?php } ?>

											<?php if( isset( $banner->excerpt ) && '' != $banner->excerpt ) { ?>
												<div class="excerpt"><?php echo $banner->excerpt; ?></div>
											<?php } ?>
										</div>
										<div class="copy"></div>
									</div>
									<?php } // if title || excerpt ?>
									<?php if( isset( $banner->image ) && '' != $banner->image ) { ?>
										<div class="image-container">
											<?php echo wp_get_attachment_image( $banner->image , 'medium' ); ?>
										</div>
									<?php } // if $banner image ?>
								</div>
							</div>
						<?php } // foreach slides ?>
			 		</div>
				<?php } // if !empty( $widget->slides ) ?>
		 	</section>
		 	<?php if( !empty( $widget->banners ) ) { ?>
			 	<script>
					jQuery(function($){

						var swiper = $('#<?php echo $widget_id; ?>').swiper({
							//Your options here:
							mode:'horizontal',
							pagination: '.pages',
							// slidesPerView: 4,
							paginationClickable: true,
							watchActiveIndex: true,
							loop: true
							<?php if( isset( $widget->autoplay_banners ) && isset( $widget->slide_time ) && is_numeric( $widget->slide_time ) ) {?>, autoplay: <?php echo $widget->slide_time; ?><?php }?>
						});
						$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
							e.preventDefault();
							// "Hi Mom"
							$that = $(this);

							if( $that.hasClass( 'swiper-pagination-switch' ) ){ // Anchors
								swiper.swipeTo( $that.index() );
							} else if( $that.hasClass( 'arrow-left' ) ){ // Previous
								swiper.swipePrev();
							} else if( $that.hasClass( 'arrow-right' ) ){ // Next
								swiper.swipeNext();
							}
						});

					})
			 	</script>
			<?php } // if !empty( $widget->slides ) ?>

	 		<!-- Front-end HTML Here
	 		<?php print_r( $instance ); ?>-->
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

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Form_Elements();

			// $instance Defaults
			$instance_defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'banner_height' => '550',
				'banner_ids' => rand( 1 , 1000 )
			);

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP ); ?>

			<div class="hatch-container-large" id="hatch-banner-widget-<?php echo $this->number; ?>">

				<?php $widget_elements->header( array(
					'title' =>'Banners',
					'icon_class' =>'banner'
				) ); ?>


				<ul class="hatch-accordions">
					<li class="hatch-accordion-item open">
						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Banner Content' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>
						<section class="hatch-accordion-section hatch-content">


								<a id="add_banner_<?php echo $this->number; ?>" class="hatch-button btn-large hatch-push-bottom hatch-add-widget-banner" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Banner' , HATCH_THEME_SLUG ) ; ?></a>

								<?php echo $widget_elements->input(
									array(
										'type' => 'hidden',
										'name' => $this->get_field_name( 'banner_ids' ) ,
										'id' => 'banner_ids_input_' . $this->number,
										'value' => ( isset( $banner_ids ) ) ? $banner_ids : NULL
									)
								); ?>

								<?php // If we have some banners, let's break out their IDs into an array
								if( isset( $banner_ids ) && '' != $banner_ids ) $banners = explode( ',' , $banner_ids ); ?>

								<ul id="banner_list_<?php echo $this->number; ?>" class="hatch-accordions-sortable hatch-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
									<?php if( isset( $banners ) && is_array( $banners ) ) { ?>
										<?php foreach( $banners as $banner ) {
											$this->banner_item( array(
													'id_base' => $this->id_base ,
													'number' => $this->number ) ,
													$banner ,
													( isset( $instance[ 'banners' ][ $banner ] ) ) ? $instance[ 'banners' ][ $banner ] : NULL );
										} ?>
									<?php } else { ?>
										<?php $this->banner_item( array( 'id_base' => $this->id_base , 'number' => $this->number ) ); ?>
									<?php }?>
								</ul>

						</section>
					</li>
					<li class="hatch-accordion-item">
						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Banner Settings' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>
						<section class="hatch-accordion-section hatch-content">
							<div class="hatch-row">
								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Slideshow Display' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<ul class="hatch-checkbox-list">
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_slider_arrows' ) ,
															'id' => $this->get_field_id( 'hide_slider_arrows' ) ,
															'value' => ( isset( $hide_slider_arrows ) ) ? $hide_slider_arrows : NULL,
															'label' => __( 'Hide Slider Arrows', HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'autoplay_banners' ) ,
															'id' => $this->get_field_id( 'autoplay_banners' ) ,
															'value' => ( isset( $autoplay_banners ) ) ? $autoplay_banners : NULL,
															'label' => __( 'Autoplay Slides', HATCH_THEME_SLUG )
														)
													); ?>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Slideshow Effects' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'slide_time' ); ?>"><?php _e( 'Slide Time' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'text',
														'name' => $this->get_field_name( 'slide_time' ) ,
														'id' => $this->get_field_id( 'slide_time' ) ,
														'placeholder' => __( 'Leave blank for no slide', HATCH_THEME_SLUG ),
														'value' => ( isset( $slide_time ) ) ? $slide_time : NULL
													)
												); ?>
											</p>
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'slide_effect' ); ?>"><?php _e( 'Slide Effect' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'select',
														'name' => $this->get_field_name( 'slide_effect' ) ,
														'id' => $this->get_field_id( 'slide_effect' ) ,
														'value' => ( isset( $slide_effect ) ) ? $slide_effect : NULL ,
														'options' => array(
																'slide' => __( 'Slide', HATCH_THEME_SLUG ),
																'fade' => __( 'Fade', HATCH_THEME_SLUG ),
																'none' => __( 'None', HATCH_THEME_SLUG ),

															)
													)
												); ?>
											</p>
										</div>
									</div>
								</div>
								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Slideshow Dimensions' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'banner_height' ); ?>"><?php _e( 'Banner Height' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'text',
														'name' => $this->get_field_name( 'banner_height' ) ,
														'id' => $this->get_field_id( 'banner_height' ) ,
														'value' => ( isset( $banner_height ) ) ? $banner_height : NULL
													)
												); ?>
											</p>
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'banner_width' ); ?>"><?php _e( 'Banner Width' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'select',
														'name' => $this->get_field_name( 'banner_width' ) ,
														'id' => $this->get_field_id( 'banner_width' ) ,
														'value' => ( isset( $banner_height ) ) ? $banner_height : NULL ,
														'options' => array(
																'full-width' => __( 'Full Width', HATCH_THEME_SLUG ),
																'boxed' => __( 'Boxed', HATCH_THEME_SLUG )

															)
													)
												); ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</section>
					</li>
				</ul>

			</div>

		<?php } // Form

		function banner_item( $widget_details = array() , $slide_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs
			if( NULL !== $instance ) {

				// $instance Defaults
				$instance_defaults = array (
					'image_layout' => 'image-left',
					'excerpt' => NULL
				);

				// Parse $instance
				$instance_args = wp_parse_args( $instance, $instance_defaults );
				extract( $instance_args, EXTR_SKIP );
			}

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $slide_guid ) ) $slide_guid = rand( 1 , 1000 );

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Form_Elements();

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details; ?>

				<li class="hatch-accordion-item  <?php if( !isset( $_REQUEST['action'] ) ) echo 'open'; ?>" data-guid="<?php echo $slide_guid; ?>">
					<a class="hatch-accordion-title">
						<span><?php _e( 'Banner' , HATCH_THEME_SLUG ); // @TODO: Add Banner 1/Banner 2/Banner 3/Banner 4 numbering ?></span>
					</a>
					<section class="hatch-accordion-section hatch-content">

						<div class="hatch-row">
							<div class="hatch-panel">
								<?php $widget_elements->section_panel_title(
									array(
										'type' => 'panel',
										'title' => __( 'Background' , HATCH_THEME_SLUG ),
										'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
									)
								); ?>
								<div class="hatch-content">
									<?php echo $widget_elements->input(
										array(
											'type' => 'background',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][background]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-background' ,
											'value' => ( isset( $background ) ) ? $background : NULL
										)
									); ?>
								</div>
							</div>
						</div>
						<div class="hatch-row">
							<div class="hatch-column hatch-span-4">
								<?php $widget_elements->section_panel_title(
									array(
										'type' => 'panel',
										'title' => __( 'Feature Image' , HATCH_THEME_SLUG ),
										'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
									)
								); ?>
								<div class="hatch-content">
									<?php echo $widget_elements->input(
										array(
											'type' => 'image',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][image]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-image' ,
											'value' => ( isset( $image ) ) ? $image : NULL
										)
									); ?>
									<?php echo $widget_elements->input(
										array(
											'type' => 'select-icons',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][image_layout]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-image_layout' ,
											'value' => ( isset( $image_layout ) ) ? $image_layout : NULL,
											'options' => array(
												'image-left' => __( 'Image Left' , HATCH_THEME_SLUG ),
												'image-center' => __( 'Image Center' , HATCH_THEME_SLUG ),
												'image-right' => __( 'Image Right' , HATCH_THEME_SLUG ),
											)
										)
									); ?>
								</div>
							</div>
							<div class="hatch-column hatch-span-8">
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'text',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][title]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-title' ,
											'placeholder' => __( 'Enter title here', HATCH_THEME_SLUG ),
											'value' => ( isset( $title ) ) ? $title : NULL ,
											'class' => 'hatch-text hatch-large'
										)
									); ?>
								</p>
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'textarea',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][excerpt]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-excerpt' ,
											'placeholder' => __( 'Short Excerpt', HATCH_THEME_SLUG ),
											'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
											'class' => 'hatch-textarea hatch-large'
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
	 register_widget("Hatch_Banner_Widget");
}