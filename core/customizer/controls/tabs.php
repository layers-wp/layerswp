<?php
/**
 * Tabs
 *
 * This file is used to register and display the custom Layers Tabs.
 *
 * @package Layers
 * @since Layers 1.6.5
 */

if( !class_exists( 'Layers_Customize_Tabs_Control' ) ) {

	class Layers_Customize_Tabs_Control extends Layers_Customize_Control {

		public $type = 'layers-tabs';

		public function render_content() {

			// Exit if there are no choises
			if ( empty( $this->tabs ) ) return;
			
			$form_elements = new Layers_Form_Elements();
			
			$name = '_customize-radio-' . $this->id; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
				
				<?php do_action( 'layers-control-inside', $this ); ?>
				
				<?php echo $form_elements->input(
					array(
						'type' => 'tabs',
						'label' => ( isset( $this->label ) ? $this->label : '' ),
						'name' => '',
						'id' =>  $this->id,
						'value' => stripslashes( $this->value() ),
						'data' => $this->get_customize_data(),
						'placeholder' => $this->placeholder,
						'tabs' => $this->tabs,
					)
				); ?>
				
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
			<?php
		}
	}
}