<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Customize_Select_Icon_Control' ) ) {

	class Layers_Customize_Select_Icon_Control extends WP_Customize_Control {

		public $type = 'layers-select-icons';

		public $description = '';

		public $subtitle = '';

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}

			$name = '_customize-radio-' . $this->id; ?>
			
			<div id="input_<?php echo $this->id; ?>" class="layers-control-item">
				
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="layers-form-item">
					<?php if ( '' != $this->subtitle ) : ?>
						<div class="layers-form-row"><?php echo $this->subtitle; ?></div>
					<?php endif; ?>
					<ul class="layers-visuals-wrapper layers-visuals-inline layers-clearfix">
						<?php foreach ( $this->choices as $value => $label ) : ?>
								<li class="layers-visuals-item <?php if( $value == $this->value() ) echo 'layers-active'; ?>">
									<label class="layers-icon-wrapper layers-select-images">
										<span class="icon-<?php echo $value; ?>"></span>
										<span class="layers-icon-description">
											<?php echo $label; ?>
										</span>
										<input class="layers-hide" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
									</label>
								</li>
						<?php endforeach; ?>
					</ul>
				</div>
			
			</div>
			<?php
		}
	}
} // !class_exists( 'Layers_Customize_Radio_Control' )