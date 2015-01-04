<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Customize_Heading_Control' ) ) {

	class Layers_Customize_Heading_Control extends WP_Customize_Control {

		public $type = 'heading';

		public $label = '';

		public $description = '';


		public function render_content() {

			if( '' != $this->label ) { ?>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>
			<?php } ?>

			<?php if ( '' != $this->description ) : ?>
				<div class="description customize-control-description"><?php echo $this->description; ?></div>
			<?php endif; ?>

		<?php }
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )