<?php
/**
 * Color Control
 *
 * This file is used to register and display the custom Layers Color Control
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Group_Start_Control' ) ) {

	class Layers_Customize_Group_Start_Control extends Layers_Customize_Control {

		public $type = 'layers-group-start';

		public function render_content() {
			?>
			<div
				id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>"
				class="l_option-group-start-wrapper l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>"
				<?php echo $this->get_linked_data(); ?>
				>

				<?php if ( '' != $this->label ) { ?>
					<span class="customize-control-title"><?php echo $this->label; ?></span>
				<?php } ?>

			</div>
			<?php
		}

	}
}