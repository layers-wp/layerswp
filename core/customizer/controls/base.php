<?php
/**
 * Layers Customize Control Class
 *
 * This file is used to register the base layers control Class
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Control' ) ) {
	class Layers_Customize_Control extends WP_Customize_Control {

		public $type = '';

		public $label = '';
		
		public $heading_divider = '';

		public $text = ''; // Used for form elements that have label and text, like Buttons.

		public $href = ''; // Buttons href.

		public $subtitle = '';

		public $description = '';

		public $linked = '';

		public $class = '';

		public $placeholder = '';
		
		public $default = NULL;
		
		public $colspan;
		
		public $min;
		
		public $max;
		
		public $step;

		/**
		* Render content must be overwrittedn by etending class as this renders the control.
		*/
		public function render_content() {}

		/**
		* Get linked data attribute
		*
		* Convert linked array to 'data-' attributes that the js expects.
		*
		* @return	string	'data-' attributes.
		*/
		public function get_linked_data() {

			if (
					isset( $this->linked ) &&
					is_array( $this->linked ) &&
					isset( $this->linked['show-if-selector'] ) &&
					isset( $this->linked['show-if-value'] )
				) {
				
				$return = '';
				$return .= 'data-show-if-selector="' . esc_attr( $this->linked['show-if-selector'] ) . '" ';
				$return .= 'data-show-if-value="' . esc_attr( $this->linked['show-if-value'] ) . '" ';
				
				if ( isset( $this->linked['show-if-operator'] ) )
					$return .= 'data-show-if-operator="' . esc_attr( $this->linked['show-if-operator'] ) . '" ';
				
				return $return;
			}

			/*
			Example linked array
			Used when registering a control in config
			'linked'    => array(
					'show-if-selector' => "#layers-header-layout-fixed",
					'show-if-value'    => "true",
					'show-if-operator' => "!=",
			)
			*/
		}

		/**
		* Get customize data attribute
		*
		* @return  array 	fomratted as the form input needs them;
		*/
		public function get_customize_data() {

			$link = explode( '="', $this->get_link() );
			$link_attr = ltrim( $link[0], 'data-' );
			$link_val = rtrim( $link[1], '"' );
			$link_array = array( $link_attr => $link_val );

			return $link_array;
		}
		
		/**
		* Render the Reset-to-Default and possible other history buttons.
		*/
		public function render_history_actions() {
			return false;
			?>
			<div class="customize-control-history">
				<!-- <a href="#" class="customize-control-undo fa fa-undo"></a> -->
				<!-- <a href="#" class="customize-control-redo fa fa-repeat"></a> -->
				<a href="#" class="customize-control-default fa fa-refresh" title="<?php _e( 'Reset (cleans the field returning it to original default state)', 'layerswp' ) ?>" data-default="<?php echo esc_attr( $this->default ); ?>"></a>
			</div>
			<?php
		}
		
		/**
		* Render the Reset-to-Default and possible other history buttons.
		*/
		public function render_heading_divider( $text ) {
			?>
			<span class="customize-control-title layers-heading-divider">
				<?php echo $text; ?>
			</span>
			<?php
			/*
			?>
			<table class="layers-heading-divider">
				<tr>
					<td>
						<span class="customize-control-title">
							<?php echo $text; ?>
						</span>
					</td>
					<td>
						<div><!----></div>
					</td>
				</tr>
			</table>
			<?php
			*/
		}

	}
}