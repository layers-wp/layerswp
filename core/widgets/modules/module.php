<?php  /**
 * Modules Widget
 *
 * This file is used to register and display the Hatch - Module widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Module_Widget' ) ) {
	class Hatch_Module_Widget extends Hatch_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Module';
		private $widget_id = 'module';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array();

		/**
		*  Widget construction
		*/
		function Hatch_Module_Widget(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => 'Our Services',
				'excerpt' => 'Our services run deep and are backed by over ten years of experience.',
				'design' => array(
					'layout' => 'layout-boxed',
					'columns' => '3',
					'columflush' => false,
					'background' => array(
						'position' => 'center',
						'repeat' => 'no-repeat'
					),
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL
					)
				),
				'module_ids' => rand( 1 , 1000 ).','.rand( 1 , 1000 ).','.rand( 1 , 1000 )
			);

			$this->module_defaults = array (
				'title' => 'Your service title',
				'excerpt' => 'Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.',
				'design' => array(
					'imagealign' => 'image-left',
					'imageratios' => NULL,
					'background' => NULL,
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL
					)
				)
			);

			// Setup the defaults for each module object
			foreach( explode( ',', $this->defaults[ 'module_ids' ] ) as $module_id ) {
					$this->defaults[ 'modules' ][ $module_id ] = $this->module_defaults;
			}
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
			$instance = wp_parse_args( $instance, $instance_defaults );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance;// Set the span class for each column

			if( !isset( $widget->design[ 'columns' ] ) ) {
				$col_count = 3;
			} else {
				$col_count = $widget->design[ 'columns' ];
			}
			$span_class = 'span-' . ( 12 / $col_count );

			// Set the background styling
			if( !empty( $widget->design[ 'background' ] ) ) $this->widget_styles( $widget_id , 'background', $widget->design[ 'background' ] );
			if( !empty( $widget->design['fonts'][ 'color' ] ) ) $this->widget_styles( $widget_id , 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget->design['fonts'][ 'color' ] ) ); ?>

			<section class="widget row content-vertical-massive" id="<?php echo $widget_id; ?>">
				<?php if( $this->check_and_return( $widget , 'title' ) || $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container">
						<div class="section-title <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'size' ); ?> <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'align' ); ?> clearfix">
							<?php if( '' != $widget->title ) { ?>
								<h3 class="heading"><?php echo $widget->title; ?></h3>
							<?php } ?>
							<?php if( '' != $widget->excerpt ) { ?>
								<p class="excerpt"><?php echo $widget->excerpt; ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if( !empty( $widget->modules ) ) { ?>
					<div class="row <?php if('layout-boxed' == $this->check_and_return( $widget , 'design' , 'layout' ) ) echo 'container'; ?>">
						<?php $col = 1; ?>
						<?php foreach ( $widget->modules as $key => $module) {

							$module = (object) $module;
							// Set the background styling
							if( !empty( $module->design[ 'background' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'background', $module->design[ 'background' ] );
							if( !empty( $module->design['fonts'][ 'color' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'color', array( 'selectors' => array( 'h5.heading a' , 'div.excerpt' , 'div.excerpt p' ) , 'color' => $module->design['fonts'][ 'color' ] ) );
							if( !empty( $module->design['fonts'][ 'shadow' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'text-shadow', array( 'selectors' => array( 'h5.heading a' , 'div.excerpt' , 'div.excerpt p' )  , 'text-shadow' => $module->design['fonts'][ 'shadow' ] ) );

							// Set Image Sizes
							if( isset( $module->design[ 'imageratios' ] ) ){

								// Translate Image Ratio
								$image_ratio = hatch_translate_image_ratios( $module->design[ 'imageratios' ] );

								if( $col_count > 1 ){
									$imageratios = $image_ratio . '-medium';
								} else {
									$imageratios = $image_ratio . '-large';
								}

							} else {
								$imageratios = 'medium';
							} ?>

							<div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="column<?php if( isset( $widget->design[ 'columnflush' ] ) ) echo '-flush'; ?> <?php echo $span_class; ?> <?php if( '' != $this->check_and_return( $module, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $module, 'design' , 'background', 'color' ) ) echo 'content'; ?>">
								<div class="marketing <?php echo ( isset( $module->design[ 'imagealign' ] ) ? $module->design[ 'imagealign' ] : '' ); ?>  <?php echo ( isset( $module->design['fonts'][ 'size' ] ) ? $module->design['fonts'][ 'size' ] : '' ); ?>">
									<?php if( isset( $module->image ) && '' != $module->image ) { ?>
										<div class="marketing-icon"><a href="<?php echo esc_url( $module->link ); ?>"><?php echo wp_get_attachment_image( $module->image , $imageratios ); ?></a></div>
									<?php } ?>
									<div class="marketing-body <?php echo ( isset( $module->design['fonts'][ 'align' ] ) ) ? $module->design['fonts'][ 'align' ] : ''; ?>">
										<?php if( isset( $module->title ) && '' != $module->title ) { ?>
											<h5 class="heading"><a href="<?php echo esc_url( $module->link ); ?>"><?php echo $module->title; ?></a></h5>
										<?php } ?>
										<?php if( isset( $module->excerpt ) && '' != $module->excerpt ) { ?>
											<div class="excerpt"><?php echo apply_filters( 'the_content', $module->excerpt ); ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php $col++; ?>
						<?php } ?>
					</div>
				<?php } ?>

			</section>
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
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP ); ?>

			<!-- Form HTML Here -->
			<?php $design_controller = new Hatch_Design_Controller();
			$design_controller->bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$instance, // Widget Values
				array(
					'layout',
					'fonts',
					'columns',
					'background'
				) // Standard Components
			); ?>
			<div class="hatch-container-large" id="hatch-banner-widget-<?php echo $this->number; ?>">

				<?php $widget_elements->header( array(
					'title' =>'Columns',
					'icon_class' =>'text'
				) ); ?>

				<section class="hatch-accordion-section hatch-content">
					<p class="hatch-form-item">
						<?php echo $widget_elements->input(
							array(
								'type' => 'text',
								'name' => $this->get_field_name( 'title' ) ,
								'id' => $this->get_field_id( 'title' ) ,
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
								'name' => $this->get_field_name( 'excerpt' ) ,
								'id' => $this->get_field_id( 'excerpt' ) ,
								'placeholder' =>  __( 'Short Excerpt', HATCH_THEME_SLUG ),
								'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
								'class' => 'hatch-textarea hatch-large'
							)
						); ?>
					</p>

					<?php echo $widget_elements->input(
						array(
							'type' => 'hidden',
							'name' => $this->get_field_name( 'module_ids' ) ,
							'id' => 'module_ids_input_' . $this->number,
							'value' => ( isset( $module_ids ) ) ? $module_ids : NULL
						)
					); ?>

					<?php // If we have some modules, let's break out their IDs into an array
					if( isset( $module_ids ) && '' != $module_ids ) $modules = explode( ',' , $module_ids ); ?>

					<ul id="module_list_<?php echo $this->number; ?>" class="hatch-accordions hatch-accordions-sortable hatch-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
						<?php if( isset( $modules ) && is_array( $modules ) ) { ?>
							<?php foreach( $modules as $module ) {
								$this->module_item( array(
											'id_base' => $this->id_base ,
											'number' => $this->number
										) ,
										$module ,
										( isset( $instance[ 'modules' ][ $module ] ) ) ? $instance[ 'modules' ][ $module ] : NULL );
							} ?>
						<?php } else { ?>
							<?php $this->module_item( array( 'id_base' => $this->id_base , 'number' => $this->number ) ); ?>
						<?php }?>
						<li class="hatch-button btn-primary hatch-add-widget-module" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Column' , HATCH_THEME_SLUG ) ; ?></li>
					</ul>
				</section>
			</div>

		<?php } // Form

		function module_item( $widget_details = array() , $column_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs

			// $instance Defaults
			$instance_defaults = $this->module_defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $column_guid ) ) $column_guid = rand( 1 , 1000 );

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Form_Elements();

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->module_item_count ) ) {
				$this->module_item_count = 0;
			} else {
				$this->module_item_count++;
			} ?>

				<li class="hatch-accordion-item" data-guid="<?php echo $column_guid; ?>">
					<a class="hatch-accordion-title">
						<span>
							<?php _e( 'Column' , HATCH_THEME_SLUG ); ?><span class="hatch-detail"><?php echo ( isset( $title ) ? ': ' . $title : NULL ); ?></span>
						</span>
					</a>
					<section class="hatch-accordion-section hatch-content">
						<?php $design_controller = new Hatch_Design_Controller();
						$design_controller->bar(
							'top', // CSS Class Name
							array(
								'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][design]',
								'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-design',
								'number' => $widget_details->number,
								'show_trash' => true
							), // Widget Object
							$instance, // Widget Values
							array(
								'background',
								'fonts',
								'imagealign',
								'imageratios',
							) // Standard Components
						); ?>

						<div class="hatch-row">
							<div class="hatch-column hatch-span-4">
								<?php echo $widget_elements->input(
									array(
										'type' => 'image',
										'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][image]' ,
										'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-image' ,
										'value' => ( isset( $image ) ) ? $image : NULL
									)
								); ?>
							</div>
							<div class="hatch-column hatch-span-8">
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'text',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][title]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-title' ,
											'placeholder' => __( 'Enter title here', HATCH_THEME_SLUG ),
											'value' => ( isset( $title ) ) ? $title : NULL ,
											'class' => 'hatch-text'
										)
									); ?>
								</p>
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'text',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][link]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-link' ,
											'placeholder' => __( 'Link', HATCH_THEME_SLUG ),
											'value' => ( isset( $link ) ) ? $link : NULL ,
											'class' => 'hatch-text',
										)
									); ?>
								</p>
								<?php echo $widget_elements->input(
									array(
										'type' => 'textarea',
										'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][excerpt]' ,
										'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-excerpt' ,
										'placeholder' => __( 'Short Excerpt', HATCH_THEME_SLUG ),
										'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
										'class' => 'hatch-form-item hatch-textarea',
										'rows' => 6
									)
								); ?>
							</div>
						</div>
					</section>
				</li>
		<?php }

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Module_Widget");
}