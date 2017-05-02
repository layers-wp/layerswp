<?php
/**
 * Color Control
 *
 * This file is used to register and display the custom Layers Color Control.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Color_Control' ) ) {

	class Layers_Customize_Color_Control extends Layers_Customize_Control {

		public $type = 'layers-color';

		public function render_content() {

			$form_elements = new Layers_Form_Elements(); ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
				
				<?php do_action( 'layers-control-inside', $this ); ?>

				<?php if ( '' != $this->heading_divider ) { ?>
					<?php $this->render_heading_divider( $this->heading_divider ); ?>
				<?php } ?>

				<?php if ( '' != $this->subtitle ) : ?>
					<label class="layers-form-row"><?php echo $this->subtitle; ?></label>
				<?php endif; ?>

				<div class="layers-form-item layers-color-wrapper">
					
					<?php if ( '' != $this->label ) { ?>
						<label><?php echo $this->label; ?></label>
					<?php } ?>
						
					<?php echo $form_elements->input(
						array(
							'type' => 'color',
							'name' => '',
							'id' =>  $this->id,
							'value' => $this->value(),
							'data' => $this->get_customize_data(),
						)
					); ?>
					
				</div>
				
				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo $this->description; ?>
					</div>
				<?php endif; ?>

			</div>
			<?php
		}

	}
}