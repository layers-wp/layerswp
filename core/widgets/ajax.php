<?php  /**
 * Widget Ajax
 *
 * This file is used to fetch, using Ajax, and display different parts of the layers widgets
 *
 * @package Layers
 * @since Layers 1.0
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

			add_action( 'wp_ajax_layers_banner_widget_actions', array( $this, 'banner_widget_actions' ) );

			add_action( 'wp_ajax_layers_module_widget_actions', array( $this, 'module_widget_actions' ) );

			add_action( 'wp_ajax_layers_sidebar_widget_actions', array( $this, 'sidebar_widget_actions' ) );
		}

		function banner_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'layers-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Slider_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( $_POST[ 'instance' ] ),
					$data
				);

				// Get the previous element's column data
				$instance = $data[ 'widget-' . $_POST[ 'id_base' ] ][ $_POST[ 'number' ] ][ 'banners' ][ $_POST[ 'last_guid' ] ];


				// Get the previous element's column data
				$widget->banner_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ), NULL, $instance );
			}
			die();
		}

		function module_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'layers-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Module_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( $_POST[ 'instance' ] ),
					$data
				);

				// Get the previous element's column data
				$instance = $data[ 'widget-' . $_POST[ 'id_base' ] ][ $_POST[ 'number' ] ][ 'modules' ][ $_POST[ 'last_guid' ] ];

				$widget->module_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ), NULL, $instance );
			}
			die();
		}

		function sidebar_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'layers-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Sidebar_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {
				$widget->sidebar_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ) );
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