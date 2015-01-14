<?php  /**
 * Select Image
 *
 * This file is used to register and display the custom Layers Select Image
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Customize_Select_Control' ) ) {

	class Layers_Customize_Select_Control extends WP_Customize_Control {

		public $type = 'layers-select';

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
								'label' => __( 'Repeat' , LAYERS_THEME_SLUG ),
								'name' => '' ,
								'id' =>  $this->id,
								'value' => ( isset( $values['background']['repeat'] ) ) ? $values['background']['repeat'] : $this->value(),
								'options' => $this->choices,
								'data' => array(
									$link_attr => $link_val
								)
							)
						); ?>
					</div>
				</div>
			
			</div>
			<?php
		}
	}
} // !class_exists( 'Layers_Customize_Select_Control' )