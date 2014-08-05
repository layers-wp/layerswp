<?php  /**
 * Number Control
 *
 * This file is used to register and display the custom Hatch Multi Checkbox
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Customize_Number_Control' ) ) {

	class Hatch_Customize_Number_Control extends WP_Customize_Control {

		public $type = 'number';

		public $description = '';

		public $subtitle = '';

		public $separator = false;

		public function render_content() { ?>

			<label class="customizer-text">
				<span class="customize-control-title">

					<?php echo esc_html( $this->label ); ?>

					<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
						<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
					<?php } ?>

				</span>

				<?php if ( '' != $this->subtitle ) : ?>
					<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>

				<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</label>
			<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<?php	}
	}
} // !class_exists( 'Hatch_Customize_Number_Control' )