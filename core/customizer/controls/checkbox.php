<?php  /**
 * Checkbox
 *
 * This file is used to register and display the custom Layers Checkbox
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Customize_Checkbox_Control' ) ) {

	class Layers_Customize_Checkbox_Control extends WP_Customize_Control {

		public $type = 'layers-checkbox';

		public $description = '';

		public $subtitle = '';

		public function render_content() {
			
			if ( empty( $this->choices ) ) {
				return;
			}

			$form_elements = new Layers_Form_Elements();

			$link = explode( '="', $this->get_link() );
			$link_attr = ltrim( $link[0], 'data-' );
			$link_val = rtrim( $link[1], '"' );

			$values = false; ?>
			
			<div id="input_<?php echo $this->id; ?>" class="layers-control-item">

				<div class="layers-form-item">
					<div class="layers-checkbox-wrapper layers-form-item">
						<?php echo $form_elements->input(
							array(
								'type' => 'checkbox',
								'label' => $this->label,
								'name' => '' ,
								'id' => $this->id,
								'value' => ( isset( $values['background']['stretch'] ) ) ? $values['background']['stretch'] : $this->value(),
								'data' => array(
									$link_attr => $link_val
								),
							)
						); ?>
					</div>
				</div>
			
			</div>
			<?php
		}
	}
} // !class_exists( 'Layers_Customize_Checkbox_Control' )