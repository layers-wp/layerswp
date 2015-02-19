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

		public $text = ''; // Used for form elements that have label and text, like Buttons.

		public $href = ''; // Buttons href.

		public $subtitle = '';

		public $description = '';

		public $linked = '';

		public $class = '';

		public $placeholder = '';

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

			if ( isset( $this->linked ) && is_array( $this->linked ) && isset( $this->linked['show-if-selector'] ) && isset( $this->linked['show-if-value'] ) ) {
				return 'data-show-if-selector="' . esc_attr( $this->linked['show-if-selector'] ) . '" data-show-if-value="' . esc_attr( $this->linked['show-if-value'] ) . '" ';
			}

			/*
			Example linked array
			Used when registering a control in config
			'linked'    => array(
					'show-if-selector' => "#layers-header-layout-fixed",
					'show-if-value' => "true",
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

	}
}