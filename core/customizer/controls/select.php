<?php  /**
 * Select
 *
 * This file is used to register and display the custom Layers Select Box
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Select_Control' ) ) {

	class Layers_Customize_Select_Control extends Layers_Customize_Control {

		public $type = 'layers-select';

		public function render_content() {

			// Exit if there are no choices
			if ( empty( $this->choices ) ) return;

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

				<div class="layers-form-item layers-select-wrapper <?php echo ( $this->colspan ) ? esc_attr( "layers-column-flush layers-span-{$this->colspan}" ) : '' ?>">
					<?php echo $form_elements->input(
						array(
							'type' => 'select',
							'label' => ( isset( $this->label ) ? $this->label : '' ),
							'name' => '' ,
							'id' =>  $this->id,
							'options' => $this->choices,
							'data' => $this->get_customize_data(),
						)
					); ?>
				</div>

			</div>
			<?php
		}
	}
}