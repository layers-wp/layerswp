<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Customize_Seperator_Control' ) ) {

	class Layers_Customize_Seperator_Control extends WP_Customize_Control {

		public $type = 'layers-seperator';
		
		public $label = '';
		
		public $subtitle = '';

		public $description = '';
		
		public $linked = '';

		public function render_content() {
			
			// Relational: Convert the linked array to 'data-' attributes that the js expects.
			if ( isset( $this->linked ) && is_array( $this->linked ) && isset( $this->linked['show-if-selector'] ) && isset( $this->linked['show-if-value'] ) ) {
				$linked = 'data-show-if-selector="' . esc_attr( $this->linked['show-if-selector'] ) . '" data-show-if-value="' . esc_attr( $this->linked['show-if-value'] ) . '" ';
			}
			else{
				$linked = '';
			}
			?>
			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>" <?php echo $linked; ?> >
				<hr />
			</div>
		<?php }
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )