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

		public static function get_instance(){
			if ( ! isset( self::$instance ) ) {
				self::$instance = new Layers_Custom_Meta();
			}
			return self::$instance;
		}

		/**
		*  Constructor
		*/

		public function __construct() {
		}

		public function init() {
			add_action( 'wp_ajax_layers_slider_widget_actions', array( $this, 'slider_widget_actions' ) );
			add_action( 'wp_ajax_layers_content_widget_actions', array( $this, 'content_widget_actions' ) );
			add_action( 'wp_ajax_layers_widget_new_repeater_item', array( $this, 'widget_new_repeater_item' ) );
		}
		function slider_widget_actions(){

			if( !check_ajax_referer( 'layers-widget-actions', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Slider_Widget();
			if( 'add-slide' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( stripslashes( $_POST[ 'instance' ] ) ),
					$data
				);

				// Get the previous element's column data
				if( isset( $data[ 'widget-' . $_POST[ 'id_base' ] ] ) && isset( $_POST[ 'last_guid' ] ) && is_numeric( $_POST[ 'last_guid' ] ) ) {
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

			if( !check_ajax_referer( 'layers-widget-actions', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Layers_Content_Widget();
			if( 'add-column' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data
				parse_str(
					urldecode( stripslashes( $_POST[ 'instance' ] ) ),
					$data
				);

				// Get the previous element's column data
				if( isset( $data[ 'widget-' . $_POST[ 'id_base' ] ] ) && isset( $_POST[ 'last_guid' ] ) && is_numeric( $_POST[ 'last_guid' ] ) ) {
					$instance = $data[ 'widget-' . $_POST[ 'id_base' ] ][ $_POST[ 'number' ] ][ 'columns' ][ $_POST[ 'last_guid' ] ];
				} else {
					$instance = NULL;
				}

				$widget->column_item( array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ), NULL, $instance );
			}
			die();
		}
		
		function widget_new_repeater_item(){
			
			if( !check_ajax_referer( 'layers-widget-actions', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// We defintiely need these to be able to repeat.
			if ( !isset( $_POST[ 'number'] ) || !isset( $_POST[ 'item_type'] ) || !isset( $_POST[ 'item_class'] ) ) die();
			
			$item_number   = $_POST[ 'number']; // e.g. 286
			$item_type     = $_POST[ 'item_type']; // e.g. columns
			$item_class    = $_POST[ 'item_class' ]; // e.g. Layers_Call_To_Action_Widget
			$item_function = "{$item_type}_item";
			
			$widget = new $item_class();
			
			if( 'add-item' == $_POST[ 'widget_action'] ) {

				// Get the previous element's column data.
				parse_str(
					urldecode( stripslashes( $_POST[ 'instance' ] ) ),
					$data
				);

				// Get the previous element's column data.
				if( isset( $data[ 'widget-'.$_POST['id_base'] ] ) && isset( $_POST['last_guid'] ) && is_numeric( $_POST['last_guid'] ) ) {
					
					$instance = $data[ 'widget-'.$_POST['id_base'] ][ $item_number ][ $item_type.'s' ][ $_POST['last_guid'] ];
				} else {
					
					$instance = NULL;
				}
				
				$widget->$item_function( NULL, $instance );
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