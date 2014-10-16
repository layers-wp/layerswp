<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Hatch Radio Checkbox
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Customize_Select_Image_Control' ) ) {

	class Hatch_Customize_Select_Image_Control extends WP_Customize_Control {

		public $type = 'select-image';

		public $description = '';

		public $subtitle = '';

		public function render_content() {

			echo '<!--' . print_r( $this->choices , true ) . '-->';

			if ( empty( $this->choices ) ) {
				return;
			}

			$name = '_customize-radio-' . $this->id; ?>

			<span class="customize-control-title">

				<?php echo esc_html( $this->label ); ?>

			</span>

			<div id="input_<?php echo $this->id; ?>">

				<?php if ( '' != $this->subtitle ) : ?>
					<div class="hatch-form-row"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>
				<?php foreach ( $this->choices as $value => $label ) : ?>
						<label href="" class="hatch-icon-wrapper hatch-select-images <?php if( $value == $this->value() ) echo 'hatch-active'; ?>" for="<?php echo $this->id . '-' . $value; ?>">
							<img src="<?php echo esc_html( $label ); ?>">
						</label>
						<input type="radio"  class="hatch-hide" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . '-' . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
				<?php endforeach; ?>
			</div>

		<?php }
	}
} // !class_exists( 'Hatch_Customize_Radio_Control' )