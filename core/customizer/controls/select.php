<?php  /**
 * Select Image
 *
 * This file is used to register and display the custom Layers Select Image
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Select_Control' ) ) {

	class Layers_Customize_Select_Control extends Layers_Customize_Control {

		public $type = 'layers-select';

		public function render_content() {

			// Exit if there are no choises
			if ( empty( $this->choices ) ) return;

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div data-test id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>" <?php echo $this->get_linked_data(); ?> >

				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="layers-form-item">
					<?php if ( '' != $this->subtitle ) : ?>
						<label class="layers-form-row"><?php echo $this->subtitle; ?></label>
					<?php endif; ?>

					<div class="layers-select-wrapper layers-form-item">
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

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</div>
				<?php endif; ?>

			</div>
			<?php
		}
	}
} // !class_exists( 'Layers_Customize_Select_Control' )