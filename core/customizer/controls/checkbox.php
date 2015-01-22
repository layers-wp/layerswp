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

		public $label = '';
		
		public $subtitle = '';

		public $description = '';
		
		public $linked = '';

		public $class = '';

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$link = explode( '="', $this->get_link() );
			$link_attr = ltrim( $link[0], 'data-' );
			$link_val = rtrim( $link[1], '"' );

			$values = false;
			
			// Relational: Convert the linked array to 'data-' attributes that the js expects.
			if ( isset( $this->linked ) && is_array( $this->linked ) && isset( $this->linked['show-if-selector'] ) && isset( $this->linked['show-if-value'] ) ) {
				$linked = 'data-show-if-selector="' . esc_attr( $this->linked['show-if-selector'] ) . '" data-show-if-value="' . esc_attr( $this->linked['show-if-value'] ) . '" ';
			}
			else{
				$linked = '';
			} ?>
			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="layers-customize-control layers-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $linked; ?> >

				<div class="layers-form-item">
					<div class="layers-checkbox-wrapper layers-form-item">
						<?php echo $form_elements->input(
							array(
								'type' => 'checkbox',
								'label' => $this->label,
								'name' => '',
								'id' => $this->id,
								'data' => array(
									$link_attr => $link_val
								),
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
} // !class_exists( 'Layers_Customize_Checkbox_Control' )