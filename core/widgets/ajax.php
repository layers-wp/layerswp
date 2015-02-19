<?php  /**
 * Widget Ajax
 *
 * This file is used to fetch, using Ajax, and display different parts of the layers widgets
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Widget_Ajax' ) ) {

	class Layers_Widget_Ajax {

		private static $instance;

		/**
		*  Initiator
		*/

		public static function init(){
			return self::$instance;
		}

		/**
		*  Constructor
		*/

		public function __construct() {
			add_action( 'wp_ajax_layers_slider_widget_actions', array( $this, 'slider_widget_actions' ) );

			add_action( 'wp_ajax_layers_content_widget_actions', array( $this, 'content_widget_actions' ) );
		}

		function slider_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'layers-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Slider_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( stripslashes( $_POST[ 'instance' ] ) ),
					$data
				);

				// Get the previous element's column data
				if( isset( $_POST[ 'last_guid' ] ) ) {
					$instance = $data[ 'widget-' . $_POST[ 'id_base' ] ][ $_POST[ 'number' ] ][ 'slides' ][ $_POST[ 'last_guid' ] ];
				} else {
					$instance = NULL;
				}


				// Get the previous element's column data
				$widget->slide_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ), NULL, $instance );
			}
			die();
		}

		function content_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'layers-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Content_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( stripslashes( $_POST[ 'instance' ] ) ),
					$data
				);

				// Get the previous element's column data
				if( isset( $_POST[ 'last_guid' ] ) && is_numeric( $_POST[ 'last_guid' ] ) ) {
					$instance = $data[ 'widget-' . $_POST[ 'id_base' ] ][ $_POST[ 'number' ] ][ 'columns' ][ $_POST[ 'last_guid' ] ];
				} else {
					$instance = NULL;
				}

				$widget->column_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ), NULL, $instance );
			}
			die();
		}

	}

	function layers_register_widget_ajax(){
		$widget_ajax = new Layers_Widget_Ajax();
		$widget_ajax->init();
	}
	add_action( 'init' , 'layers_register_widget_ajax' );
} // if class_exists