<?php
/**
 * Border Style Fields (Width, Style, Radius)
 *
 * This file is used to register and display the custom Layers TRBL field
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Border_Style_Control' ) ) {

	class Layers_Customize_Border_Style_Control extends Layers_Customize_Control {

		public $type = 'layers-border-style-fields';

		public $fields = array();

		public function render_content() {

			$form_elements = new Layers_Form_Elements();

			$values = false; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
			
				<?php $this->render_history_actions(); ?>

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

				<div class="layers-form-item <?php echo ( $this->colspan ) ? esc_attr( "layers-column-flush layers-span-{$this->colspan}" ) : '' ?>">
					<?php echo $form_elements->input(
						array(
							'type' => 'border-style-fields',
							'name' => '',
							'id' => $this->id,
							'value' => array(
								'width' => get_option( "{$this->id}-width" ),
								'style' => get_option( "{$this->id}-style" ),
								'radius' => get_option( "{$this->id}-radius" ),
							),
							'class' => $this->input_class,
						)
					); ?>
				</div>

			</div>
			<?php
		}
	}
}