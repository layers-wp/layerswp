<?php  /**
 * Plain HTML Widget
 *
 * This file is used to register and display the Hatch - Portfolios widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_HTML_Widget' ) ) {
	class Hatch_HTML_Widget extends WP_Widget {

		/**
		* Widget variables
		*
	 	* @param  	varchar    		$widget_title    	Widget title
	 	* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
	 	* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
	 	* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
	 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
	 	*/
		private $widget_title = 'Plain HTML';
		private $widget_id = 'html';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array();

		/**
		*  Widget construction
		*/
	 	function Hatch_HTML_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 1000, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title . ' Widget', $widget_ops, $control_ops );
	 	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) { ?>
	 		<!-- Front-end HTML Here -->
	 		<pre><?php if( isset( $instance ) ) print_r( $instance ); ?></pre>
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

			// Make the HTML stick
			if ( current_user_can('unfiltered_html') )
				$instance['html'] =  $new_instance['html'];
			else
				$instance['html'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['html']) ) ); // wp_filter_post_kses() expects slashed

				return $new_instance;
			}

		/**
		*  Widget form
		*
		* We use regulage HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*
		*/
		function form( $instance ){

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Form_Elements();

			// $instance Defaults
			$instance_defaults = array (
				'html' => NULL,
			);

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP );
		?>

			<div class="hatch-container-large">

				<?php $widget_elements->header( array(
					'title' => __( 'Plain HTML', HATCH_THEME_SLUG ),
					'icon_class' =>'location'
				) ); ?>
				<ul class="hatch-accordions">
					<li class="hatch-accordion-item">

						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Content' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">
							<div class="hatch-row hatch-push-bottom clearfix">
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'textarea',
											'name' => $this->get_field_name( 'html' ) ,
											'id' => $this->get_field_id( 'html' ) ,
											'placeholder' => __( 'Enter your HTML code here, remember to keep it neat!', HATCH_THEME_SLUG ),
											'value' => ( isset( $html ) ) ? $html : NULL ,
											'class' => 'hatch-textarea',
											'rows' => 10
										)
									); ?>
								</p>
							</div>
						</section>
					</li>
				</ul>
			</div>

		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_HTML_Widget");
}