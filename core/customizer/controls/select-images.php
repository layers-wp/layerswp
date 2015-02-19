<?php  /**
 * Select Image
 *
 * This file is used to register and display the custom Layers Select Image
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Select_Image_Control' ) ) {

	class Layers_Customize_Select_Image_Control extends Layers_Customize_Control {

		public $type = 'layers-select-images';

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>" <?php echo $this->get_linked_data(); ?> >

				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="layers-form-item">
					<?php if ( '' != $this->subtitle ) : ?>
						<label class="layers-form-row"><?php echo $this->subtitle; ?></label>
					<?php endif; ?>

					<?php echo $form_elements->input(
						array(
							'type' => 'image',
							'label' => __( 'Choose Background' , 'layerswp' ),
							'name' => '',
							'id' =>  $this->id,
							'value' => ( isset( $values['background']['image'] ) ) ? $values['background']['image'] : $this->value(),
							'data' => $this->get_customize_data(),
						)
					); ?>
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
} // !class_exists( 'Layers_Customize_Select_Image_Control' )