<?php
/**
 * Tab End Control
 *
 * This file is used to register and display the custom Layers Tab End.
 *
 * @package Layers
 * @since Layers 1.6.5
 */

if( !class_exists( 'Layers_Customize_Tab_End_Control' ) ) {

	class Layers_Customize_Tab_End_Control extends Layers_Customize_Control {

		public $type = 'layers-tab-end';

		public function render_content() {
			
			$form_elements = new Layers_Form_Elements();
			
			?>
			<div
				id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>"
				class="
					l_option-customize-control
					l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>
					<?php if ( FALSE === strpos( $this->class, 'group' ) ) { ?>
						l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) . '-standard' ); // l_option-customize-control-tab-start-standard ?>
					<?php } else { ?>
						l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) . '-group' ); // l_option-customize-control-tab-start-group ?>
					<?php } ?>
					<?php echo esc_attr( $this->class ); ?>
				"
				<?php echo $this->get_linked_data(); ?>
				>
				
				<?php do_action( 'layers-control-inside', $this ); ?>
				
				<?php if ( '' != $this->label ) { ?>
					<span class="customize-control-title"><?php echo $this->label; ?></span>
				<?php } ?>
				
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