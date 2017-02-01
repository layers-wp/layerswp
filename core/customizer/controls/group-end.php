<?php
/**
 * Color Control
 *
 * This file is used to register and display the custom Layers Color Control
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Group_End_Control' ) ) {

	class Layers_Customize_Group_End_Control extends Layers_Customize_Control {

		public $type = 'layers-group-end';

		public function render_content() {
			?>
			<div
				id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>"
				class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>"
				<?php echo $this->get_linked_data(); ?>
				>
				
			</div>
			<?php
		}

	}
}