<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Hatch Radio Checkbox
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Customize_Seperator_Control' ) ) {

	class Hatch_Customize_Seperator_Control extends WP_Customize_Control {

		public $type = 'seperator';

		public function render_content() { ?>
			<hr />
		<?php }
	}
} // !class_exists( 'Hatch_Customize_Radio_Control' )