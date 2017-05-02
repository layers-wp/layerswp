<?php
/**
 * Inline Numbers Fields
 *
 * This file is used to register and display the custom Layers Inline Numbers Fields (defaults to Top, Right, Bottm, Left).
 *
 * @package Layers
 * @since Layers 1.6.5
 */

if( !class_exists( 'Layers_Customize_Inline_Numbers_Fields_Control' ) ) {

	class Layers_Customize_Inline_Numbers_Fields_Control extends Layers_Customize_Control {

		public $type = 'layers-inline-numbers-fields';

		public $fields = array();

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
				
				<?php do_action( 'layers-control-inside', $this ); ?>
				
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
				
				<?php
				
				// Default to TRBL if no fields are set.
				if ( empty( $this->fields ) ) {
					
					$this->fields = array(
						'top' => 'Top',
						'right' => 'Right',
						'bottom' => 'Bottom',
						'left' => 'Left',
					);
				}
				
				// Get the values if any set.
				$values = array();
				foreach ( $this->fields as $field_key => $field_value ) {
					$values[$field_key] = get_theme_mod( "{$this->id}-{$field_key}" );
				}
				?>

				<div class="layers-form-item <?php echo ( $this->colspan ) ? esc_attr( "layers-column-flush layers-span-{$this->colspan}" ) : '' ?>">
					<?php echo $form_elements->input(
						array(
							'type' => 'inline-numbers-fields',
							'name' => '',
							'id' => $this->id,
							'value' => $values,
							'fields' => $this->fields,
							'class' => $this->input_class,
						)
					); ?>
				</div>
				
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