<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Seperator_Control' ) ) {

	class Layers_Customize_Seperator_Control extends Layers_Customize_Control {

		public $type = 'layers-seperator';

		public function render_content() {
			?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>" <?php echo $this->get_linked_data(); ?> >
				<hr />
			</div>
		<?php }
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )