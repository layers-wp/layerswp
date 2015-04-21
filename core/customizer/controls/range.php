<?php  /**
 * range
 *
 * This file is used to register and display the custom Layers range
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Range_Control' ) ) {

	class Layers_Customize_Range_Control extends Layers_Customize_Control {

		public $type = 'layers-range';

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div data-test id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >

				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="layers-form-item">

					<?php if ( '' != $this->subtitle ) : ?>
						<label class="layers-form-row"><?php echo $this->subtitle; ?></label>
					<?php endif; ?>

					<div class="layers-form-item">
						<?php echo $form_elements->input(
							array(
								'type' => 'range',
								'label' => ( isset( $this->label ) ? $this->label : '' ),
								'name' => '',
								'id' => $this->id,
   								'value' => stripslashes( $this->value() ),
								'data' => $this->get_customize_data(),
								'min' => ( isset( $this->min ) ? $this->min : 0 ) ,
								'max' => ( isset( $this->max ) ? $this->max : 100 ) ,
								'step' => ( isset( $this->step ) ? $this->step : 1 ) ,
							)
						); ?>
					</div>
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
} // !class_exists( 'Layers_Customize_Range_Control' )