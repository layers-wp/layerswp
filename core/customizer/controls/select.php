<?php  /**
 * Select Control
 *
 * This file is used to register and display the custom Hatch Select Checkbox
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Select_Control' ) ) {

	class Hatch_Select_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'select';

		public $description = '';

		public $subtitle = '';

		public $separator = false;

		public $required;

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			} ?>

			<label>
				<span class="customize-control-title">

					<?php echo esc_html( $this->label ); ?>

					<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
						<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<?php } ?>

				</span>
				<?php if ( '' != $this->subtitle ) : ?>
					<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>

				<select <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $value => $label ) {
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
					} ?>
				</select>
			</label>
			<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<?php }
	}
} // !class_exists( 'Hatch_Select_Control' )