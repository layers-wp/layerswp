<?php  /**
 * Widget Ajax
 *
 * This file is used to fetch, using Ajax, and display different parts of the hatch widgets
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Widget_Ajax' ) ) {

	class Hatch_Widget_Ajax {

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

			add_action( 'wp_ajax_hatch_banner_widget_actions', array( $this, 'banner_widget_actions' ) );
		}

		function banner_widget_actions(){
			if( !wp_verify_nonce( $_REQUEST['nonce'], 'hatch-widget-actions' ) ) die( 'You threw a Nonce exception' ); // Nonce

			$widget = new Hatch_Banner_Widget();
			if( 'add' == $_POST[ 'widget_action'] ) {
				$widget->banner_item(
					array( 'id_base' => $_POST[ 'id_base' ] , 'number' => $_POST[ 'number' ] ),
					$_POST[ 'guid' ]
				);
			}
			die();
		}
	}

	function hatch_register_widget_ajax(){
		$widget_ajax = new Hatch_Widget_Ajax();
		$widget_ajax->init();
	}
	add_action( 'init' , 'hatch_register_widget_ajax' );
} // if class_exists