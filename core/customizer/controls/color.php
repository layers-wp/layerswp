<?php  /**
 * Color Control
 *
 * This file is used to register and display the custom Hatch Color Control
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Customize_Color_Control' ) ) {

	class Hatch_Customize_Color_Control extends WP_Customize_Control {

		public $type = 'color';

		public $description = '';

		public $subtitle = '';

		public function render_content() {
			
			$form_elements = new Hatch_Form_Elements();
			
			$link = explode( '="', $this->get_link() );
			$link_attr = ltrim( $link[0], 'data-' );
			$link_val = rtrim( $link[1], '"' ); ?>

			<span class="customize-control-title">

				<?php echo esc_html( $this->label ); ?>

			</span>

			<div id="input_<?php echo $this->id; ?>" class="hatch-form-item">

				<?php if ( '' != $this->subtitle ) : ?>
					<label class="hatch-form-row"><?php echo $this->subtitle; ?></label>
				<?php endif; ?>
				<div class="hatch-visuals-wrapper hatch-visuals-inline hatch-clearfix">
				
					<?php
					echo $form_elements->input(
						array(
							'type' => 'color',
							'name' => '',
							'id' =>  $this->id,
							'value' => $this->value(),
							'data' => array(
								$link_attr => $link_val
							)
						)
					);
					?>
				
				</div>
			
			</div>
			<?php
		}
	}
} // !class_exists( 'Hatch_Customize_Color_Control' )