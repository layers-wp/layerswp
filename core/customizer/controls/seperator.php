<?php
/**
 * Seperator Control
 *
 * This file is used to register and display the custom Layers Seperator Control.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Seperator_Control' ) ) {

	class Layers_Customize_Seperator_Control extends Layers_Customize_Control {

		public $type = 'layers-seperator';

		public function render_content() {
			
			$form_elements = new Layers_Form_Elements();
			
			?>
			
			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
				
				<?php do_action( 'layers-control-inside', $this ); ?>
				
				<hr />
				
				<?php echo $form_elements->input(
					array(
						'type' => 'hidden',
						'label' => ( isset( $this->label ) ? $this->label : '' ),
						'name' => '',
						'id' =>  $this->id,
						'value' => stripslashes( $this->value() ),
						'data' => $this->get_customize_data(),
						'placeholder' => $this->placeholder,
					)
				); ?>
				
			</div>
		<?php }
	}
}