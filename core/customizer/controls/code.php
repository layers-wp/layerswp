<?php  /**
 * Code
 *
 * This file is used to register and display the custom Layers Code
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Code_Control' ) ) {

	class Layers_Customize_Code_Control extends Layers_Customize_Control {

		public $type = 'layers-code';

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >

				<?php $this->render_history_actions(); ?>

				<?php if ( '' != $this->heading_divider ) { ?>
					<?php $this->render_heading_divider( $this->heading_divider ); ?>
				<?php } ?>

				<?php if ( '' != $this->label ) { ?>
					<span class="customize-control-title"><?php echo $this->label; ?></span>
				<?php } ?>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo $this->description; ?>
					</div>
				<?php endif; ?>
				
				<?php if ( '' != $this->subtitle ) : ?>
					<label class="layers-form-row"><?php echo $this->subtitle; ?></label>
				<?php endif; ?>

				<div class="layers-form-item layers-code-wrapper">
					<?php echo $form_elements->input(
						array(
							'type' => 'textarea',
							'label' => $this->label,
							'name' => '',
							'id' => $this->id,
							'data' => $this->get_customize_data(),
                            'placeholder' => $this->placeholder,
						)
					); ?>
				</div>

			</div>
			<?php
		}
	}
}