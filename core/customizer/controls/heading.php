<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Heading_Control' ) ) {

	class Layers_Customize_Heading_Control extends Layers_Customize_Control {

		public $type = 'layers-heading';

		public function render_content() {
			?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>" <?php echo $this->get_linked_data(); ?> >

				<?php
				if( '' != $this->label ) { ?>
					<span class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</span>
				<?php } ?>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</div>
				<?php endif; ?>

			</div>
		<?php }
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )