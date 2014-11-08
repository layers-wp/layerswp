<?php /**
 * Widget Exporter
 *
 * This file contains the widget Export/Import functionality in Hatch
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Widget_Migrator {

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
    }
    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];

            }

        }

        return $available_widgets;
    }

    /**
    *  Export
    */

    public function export() {
    }

    /**
    *  Import
    */

    public function import() {
    }

    /**
    *  Validate Input (Look for images)
    */

    public function validate_input() {
    }
}