<?php  /**
 * Text Widget
 *
 * This file is used to register and display the Layers - Text widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Text_Widget' ) ) {
	class Layers_Text_Widget extends Layers_Widget {

		/**
		*  Widget construction
		*/
		function Layers_Text_Widget(){

			/**
			* Widget variables
			*
			* @param  	string    		$widget_title    	Widget title
			* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	string    		$post_type    		(optional) Post type for use in widget options
			* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
			* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
			*/
			$this->widget_title = __( 'Plain Text' , 'layerswp' );
			$this->widget_id = 'text';
			$this->post_type = 'post';

			/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => __( 'This widget is used to display your ', 'layerswp' ) . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_SMALL, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title, $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => __( 'Title', 'layerswp' ),
				'excerpt' => __( 'Excerpt', 'layerswp' ),
				'text_style' => 'regular',
				'design' => array(
					'layout' => 'layout-boxed',
					'imageratios' => 'image-square',
					'textalign' => 'text-left',
					'liststyle' => 'list-grid',
					'columns' => '3',
					'gutter' => 'on',
					'background' => array(
						'position' => 'center',
						'repeat' => 'no-repeat'
					),
					'fonts' => array(
						'align' => 'text-center',
						'size' => 'large',
						'color' => NULL,
						'shadow' => NULL
					)
				)
			);
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

			// Apply Styling
			layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );
			layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( '.thumbnail:not(.with-overlay) .thumbnail-body' ) , 'background' => array( 'color' => $this->check_and_return( $widget, 'design', 'column-background-color' ) ) ) );

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget );


			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget row content-vertical-massive';
			$widget_container_class[] = $this->check_and_return( $widget , 'design', 'advanced', 'customclass' );
			$widget_container_class[] = $this->get_widget_spacing_class( $widget );
			$widget_container_class = implode( ' ', apply_filters( 'layers_post_widget_container_class' , $widget_container_class ) ); ?>

			<section class=" <?php echo $widget_container_class; ?>" id="<?php echo $widget_id; ?>">
				<?php if( '' != $this->check_and_return( $widget , 'title' ) ||'' != $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container clearfix">
						<?php /**
						* Generate the Section Title Classes
						*/
						$section_title_class = array();
						$section_title_class[] = 'section-title clearfix';
						$section_title_class[] = $this->check_and_return( $widget , 'design', 'fonts', 'size' );
						$section_title_class[] = $this->check_and_return( $widget , 'design', 'fonts', 'align' );
						$section_title_class[] = ( $this->check_and_return( $widget, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
						$section_title_class = implode( ' ', $section_title_class ); ?>
						<div class="<?php echo $section_title_class; ?>">
							<?php if( '' != $widget['title'] ) { ?>
								<h3 class="heading"><?php echo esc_html( $widget['title'] ); ?></h3>
							<?php } ?>
							<?php if( '' != $widget['excerpt'] ) { ?>
								<div class="excerpt"><?php echo $widget['excerpt']; ?></div>
							<?php } ?>
						</div>
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
		* We use regulage HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*
		*/
		function form( $instance ){

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );

			extract( $instance, EXTR_SKIP );

			$design_bar_components = apply_filters( 'layers_' . $this->widget_id . '_widget_design_bar_components' , array(
					'layout',
					'fonts',
					'background',
					'advanced'
				) );

			$this->design_bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$instance, // Widget Values
				$design_bar_components // Standard Components
			); ?>
			<div class="layers-container-large">

				<?php $this->form_elements()->header( array(
					'title' =>  __( 'Text' , 'layerswp' ),
					'icon_class' =>'text'
				) ); ?>

				<section class="layers-accordion-section layers-content">

					<div class="layers-row layers-push-bottom">
						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_field_name( 'title' ) ,
									'id' => $this->get_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $title ) ) ? $title : NULL ,
									'class' => 'layers-text layers-large',
								)
							); ?>
						</p>

						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_field_name( 'excerpt' ) ,
									'id' => $this->get_field_id( 'excerpt' ) ,
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
									'class' => 'layers-textarea layers-large',
									'supports' => array(
										'sep',
										'bold',
										'italic',
										'underline',
										'strikeThrough',
										'createLink',
										'formatBlock',
										'removeFormat',
										'html'
									),
									'allow_tags' => array(
										'h1',
										'h2',
										'h3',
										'h4',
										'h5',
										'h6',
										'a',
										'br',
										'b',
										'strong',
										'i',
										'em',
										'blockquote'
									)
								)
							); ?>
						</p>
					</div>
				</section>

			</div>
		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Text_Widget");
}