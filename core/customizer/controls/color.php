<?php  /**
 * Color Control
 *
 * This file is used to register and display the custom Hatch Color Control
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Banner_Widget' ) ) {

	class Hatch_Customize_Color_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'color';

		/**
		 * @access public
		 * @var array
		 */
		public $statuses;

		public $description = '';

		public $subtitle = '';

		public $separator = false;

		public $required;

		/**
		 * Constructor.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __('Default') );
			parent::__construct( $manager, $id, $args );
		}

		/**
		 * Enqueue scripts/styles for the color picker.
		 *
		 * @since 3.4.0
		 */
		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}

		/**
		 * Render the control's content.
		 *
		 * @since 3.4.0
		 */
		public function render_content() {
			$this_default = $this->setting->default;
			$default_attr = '';
			if ( $this_default ) {
				if ( false === strpos( $this_default, '#' ) )
					$this_default = '#' . $this_default;
				$default_attr = ' data-default-color="' . esc_attr( $this_default ) . '"';
			}
			// The input's value gets set by JS. Don't fill it.
			?>
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

				<div class="customize-control-content">
					<input class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value' ); ?>"<?php echo $default_attr; ?> />
				</div>
			</label>
			<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
			<?php foreach ( $this->required as $id => $value ) :

				if ( isset($id) && isset($value) && get_theme_mod($id,0)==$value ) { ?>
					<script>
					jQuery(document).ready(function($) {
						$( "#customize-control-<?php echo $this->id; ?>" ).show();
						$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
							$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
						});
						$( "#<?php echo $id . $value; ?>" ).click(function(){
							$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
						});
					});
					</script>
				<?php }

				if ( isset($id) && isset($value) && get_theme_mod($id,0)!=$value ) { ?>
					<script>
					jQuery(document).ready(function($) {
						$( "#customize-control-<?php echo $this->id; ?>" ).hide();
						$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
							$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
						});
						$( "#<?php echo $id . $value; ?>" ).click(function(){
							$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
						});
					});
					</script>
				<?php }

			endforeach;
		}
	}
} // !class_exists( 'Hatch_Banner_Widget' )