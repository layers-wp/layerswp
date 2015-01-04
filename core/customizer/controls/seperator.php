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

		public $type = 'seperator';

		public function render_content() { ?>
			<hr />
		<?php }
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )