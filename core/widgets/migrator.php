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

        // Add meta box, this sorta kicks off the export logic too
        if( function_exists( 'add_meta_box' ) ) {
            add_meta_box(
                        HATCH_THEME_SLUG . '-widget-export',
                        __( 'Builder Settings' , HATCH_THEME_SLUG ), // Title
                        array( $this , 'display_export_box' ) , // Interface
                        'page' , // Post Type
                        'normal', // Position
                        'low' // Priority
                    );
        }

    }

    /**
    *  Simple output of a JSON'd string of the widget data
    */
    function display_export_box( $post ){ ?>
        <textarea id="<?php echo HATCH_THEME_SLUG . '-import-wiget-data'; ?>" style="width: 100%;" rows="15"><?php echo esc_attr( json_encode( $this->export_data() ) ); ?></textarea>
        <p>
            <em><?php _e( 'Copy and paste widget data from another site or page into this box to import data.' , HATCH_THEME_SLUG ); ?></em>
        </p>
        <a href="#import" data-post-id="<?php echo $post->ID; ?>" id="<?php echo HATCH_THEME_SLUG . '-import-wiget-page'; ?>" class="hatch-button btn-primary"><?php _e( 'Import Data' , HATCH_THEME_SLUG ); ?></a>
    <?php }

    /**
    *  Hatch Preset Widget Page Layouts
    */
    function get_preset_layouts(){
        $hatch_preset_layouts = array();

        $hatch_preset_layouts = array(
            'portfolio' => array(
                    'title' => '',
                    'screenshot' => get_template_directory_uri() . '/core/assets/presets/portfolio.png',
                    'json' => ''
                ),
        );

        return apply_filter( 'hatch_preset_layouts' , $hatch_preset_layouts );
    }


    /**
    *  Get all available widgets
    */

    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        // Kick off a blank readable array
        $available_widgets = array();

        // Loop through widget controls and add the wiget ID and Name
        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];

            }

        }

        return $available_widgets;
    }

    /**
    *  Widget Instances and their data
    */

    function get_widget_instances(){

        // Get all available widgets site supports
        $available_widgets = $this->available_widgets();
        foreach ( $available_widgets as $widget_data ) {

            // Get all instances for this ID base
            $instances = get_option( 'widget_' . $widget_data['id_base'] );

            // Have instances
            if ( ! empty( $instances ) ) {

                // Loop instances
                foreach ( $instances as $instance_id => $instance_data ) {

                    // Key is ID (not _multiwidget)
                    if ( is_numeric( $instance_id ) ) {
                        $unique_instance_id = $widget_data['id_base'] . '-' . $instance_id;
                        $widget_instances[$unique_instance_id] = $instance_data;
                    }

                }

            }
        }

        return $widget_instances;
    }

    /**
    *  Get valid sidebars for a specific page
    *
    * @return array An array of sidebar ids that are valid for this page
    */

    public function get_valid_sidebars() {
        global $post, $hatch_widgets;

        // Get all widget instances for each widget
        $widget_instances = $this->get_widget_instances();

        // Get page sidebar ID
        $page_sidebar_id = 'obox-hatch-builder-' . $post->ID;

        // Get sidebars and their unique widgets IDs
        $sidebars_widgets = get_option( 'sidebars_widgets' );

        // Setup valid_sidebars() array
        $valid_sidebars = array();

        // Setup valid sidebars
        $valid_sidebars[] = $page_sidebar_id;

        // Get all dynamic sidebars
        $dynamic_sidebars = $hatch_widgets->get_dynamic_sidebars();

        // Double check that the page we are looking for has a sidebar registered
        if( !isset( $sidebars_widgets[ $page_sidebar_id ] ) ) return;

        foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {

            // If this sidebar ID does not match the ID of the page, continue to the next sidebar
            if( $sidebar_id !=  $page_sidebar_id ) continue;

            // Skip inactive widgets
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Skip if no data or not an array (array_version)
            if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
                continue;
            }

            //TODO - Add sidebar mapper to map page ID to new page ID and dynamic sidebar keys to new sidebar keys

            // Loop widget IDs for this sidebar to find the Dynamic Sidebar Widget and its sidebar IDs
            foreach ( $widget_ids as $widget_id ) {
                if( FALSE !== strpos( $widget_id, 'hatch-widget-sidebar' ) ) {

                    if( !empty( $widget_instances[ $widget_id ][ 'sidebars' ] ) ) {
                        foreach( $widget_instances[ $widget_id ][ 'sidebars' ] as $key => $options ) {
                            $valid_sidebars[] = $widget_id . '-' . $key;
                        }
                    }
                }
            }
        }

        return $valid_sidebars;

    }

    /**
    *  Populate Sidebars/Widgets array
    *
    * @return array Array including page sidebar & widget settings
    */

    public function page_sidebars_widgets() {
        global $post;

        // Get all widget instances for each widget
        $widget_instances = $this->get_widget_instances();

        // Get valid sidebars to query
        $valid_sidebars = $this->get_valid_sidebars();

        // Gather sidebars with their widget instances
        $sidebars_widgets = get_option( 'sidebars_widgets' ); // get sidebars and their unique widgets IDs
        $sidebars_widget_instances = array();

        foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {

            // If this sidebar ID is not present in the valid sidebar array, continue
            if( !in_array( $sidebar_id , $valid_sidebars )  ) continue;

            // Skip inactive widgets
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Skip if no data or not an array (array_version)
            if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
                continue;
            }

            // Loop widget IDs for this sidebar
            foreach ( $widget_ids as $widget_id ) {

                // Is there an instance for this widget ID?
                if ( isset( $widget_instances[$widget_id] ) ) {

                    // Add to array
                    $sidebars_widget_instances[$sidebar_id][$widget_id] = $widget_instances[$widget_id];

                }

            }

        }

        return $sidebars_widget_instances;
    }

    /**
    *  Export sidebar data
    *
    * @return array Array of sidebar settings including image options translated via $this->validate_data()
    */

    function export_data(){

        // Get sidebar and widget data for this page
        $sidebars_widgets = $this->page_sidebars_widgets();

        if( empty( $sidebars_widgets ) ) return;

        // Loop through options and look for images @TODO: Add categories to this, could be useful, also add dynamic sidebar widgets
        foreach( $sidebars_widgets as $option => $data ){

            $sidebars_widgets[ $option ] = $this->validate_data( $data );
        }

        // Return modified sidebar widgets
        return $sidebars_widgets;
    }


    /**
    * Get image urls from their attachment ID
    */

    function get_image_url( $data ){

        $get_image = wp_get_attachment_image_src( $data, 'full' );
        if( $get_image ) {
            return $get_image[0];
        } else {
            return NULL;
        }
    }

    /**
    *  Validate Input (Look for images)
    */

    public function validate_data( $data ) {

        $validated_data = array();

        foreach( $data as $option => $option_data ){

            if( is_array( $option_data ) ) {

                $validated_data[ $option ] = $this->validate_data( $option_data );

            } elseif( 'image' == $option || 'featuredimage' == $option ) {
                $get_image_url = $this->get_image_url( $option_data );

                if( NULL != $get_image_url ) {
                    $validated_data[ $option ] = $get_image_url;
                } else {
                    $validated_data[ $option ] = $option_data;
                }

            } else {
                $validated_data[ $option ] = $option_data;
            }
        }

        return $validated_data;
    }

    /**
    *  Get attachment ID from URL, used when importing images
    */

    function get_attachment_id_from_url($img_tag) {
        global $wpdb;

        if( is_object( $img_tag ) ) return;

        preg_match("/src='([^']+)/i", $img_tag , $img_url_almost );

        if( empty( $img_url_almost ) ) return NULL;

        $url = str_ireplace( "src='", "",  $img_url_almost[0]);

        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$url'";

        return $wpdb->get_var($query);
    }

    /**
    *  Import Images
    */

    public function check_for_images( $data ) {

        $validated_data = array();

        if( !is_array( $data ) ) return $data;

        foreach( $data as $option => $option_data ){

            if( is_array( $option_data ) ) {

                $validated_data[ $option ] = $this->check_for_images( $option_data );

            } elseif( 'image' == $option || 'featuredimage' == $option ) {

                /* DEBUG
                echo $option_data; */

                $import_image = media_sideload_image( $option_data , 0 );

                if( NULL != $import_image ) {

                    $get_image_id = $this->get_attachment_id_from_url( $import_image );

                    if( NULL != $get_image_id ) {
                        $validated_data[ $option ] = $get_image_id;
                    } else {
                        $validated_data[ $option ] = $option_data;
                    }
                }
            } else {
                $validated_data[ $option ] = $option_data;
            }
        }

        return $validated_data;

    }

    /**
    *  Import
    */

    public function import() {

        $data = $_POST[ 'widget_data' ];

        global $wp_registered_sidebars;

        // Get all available widgets site supports
        $available_widgets = $this->available_widgets();

        // Get all existing widget instances
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
        }

        // Begin results
        $results = array();

        foreach( $data as $sidebar_id => $sidebar_data ) {

            // If this is a builder page, set the ID to the current page we are importing INTO
            if( FALSE !== strpos( $sidebar_id , 'obox-hatch-builder-' ) ) $sidebar_id = 'obox-hatch-builder-' . $_POST[ 'post_id' ];

            // Check if sidebar is available on this site
            // Otherwise add widgets to inactive, and say so
            if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                /*
                * Debug
                * echo print_r( $wp_registered_sidebars[$sidebar_id], true );
                */

                $sidebar_available = true;
                $use_sidebar_id = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message = '';
            } else {
                $sidebar_available = false;
                $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                $sidebar_message_type = 'error';
                $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', HATCH_THEME_SLUG );
            }

            // Result for sidebar
            $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
            $results[$sidebar_id]['message_type'] = $sidebar_message_type;
            $results[$sidebar_id]['message'] = $sidebar_message;
            $results[$sidebar_id]['widgets'] = array();

            // Loop widgets
            foreach ( $sidebar_data as $widget_instance_id => $widget ) {
                /*
                * Debug
                * echo print_r( $widget, true );
                */

                // Check for and import images
                foreach ( $widget as $option => $widget_data ){
                    $widget[ $option ] = $this->check_for_images( $widget_data );
                }

                $fail = false;

                // Get id_base (remove -# from end) and instance ID number
                $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

                // Does widget with identical settings already exist in same sidebar?
                if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

                    // Get existing widgets in this sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' );
                    $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

                    // Loop widgets with ID base
                    $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                    foreach ( $single_widget_instances as $check_id => $check_widget ) {

                        // Is widget in same sidebar and has identical settings?
                        if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

                            $fail = true;
                            $widget_message_type = 'warning';
                            $widget_message = __( 'Widget already exists', HATCH_THEME_SLUG ); // explain why widget not imported

                            break;

                        }

                    }

                }

                // No failure
                if ( ! $fail ) {

                    // Add widget instance
                    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                    $single_widget_instances[] = (array) $widget; // add it

                        // Get the key it was given
                        end( $single_widget_instances );
                        $new_instance_id_number = key( $single_widget_instances );

                        // If key is 0, make it 1
                        // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                        if ( '0' === strval( $new_instance_id_number ) ) {
                            $new_instance_id_number = 1;
                            $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                            unset( $single_widget_instances[0] );
                        }

                        // Move _multiwidget to end of array for uniformity
                        if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                            $multiwidget = $single_widget_instances['_multiwidget'];
                            unset( $single_widget_instances['_multiwidget'] );
                            $single_widget_instances['_multiwidget'] = $multiwidget;
                        }

                        // Update option with new widget
                        update_option( 'widget_' . $id_base, $single_widget_instances );

                    // Assign widget instance to sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                    $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

                    // Success message
                    if ( $sidebar_available ) {
                        $widget_message_type = 'success';
                        $widget_message = __( 'Imported', HATCH_THEME_SLUG );
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message = __( 'Imported to Inactive', HATCH_THEME_SLUG );
                    }

                }
                // Result for widget instance
                $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = isset( $widget->title ) ? $widget->title : __( 'No Title', HATCH_THEME_SLUG ); // show "No Title" if widget instance is untitled
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

            }
        }

        die( print_r( json_encode( $results , true ) ) );
    }
}

if( !function_exists( 'hatch_builder_export_init' ) ) {
    function hatch_builder_export_init(){
        global $pagenow, $post;

        // Make sure we're on the post edit screen
        if( 'post.php' != $pagenow ) return;

        // Make sure we're editing a post
        if( 'page' != get_post_type( $post->ID ) || 'builder.php' != basename( get_page_template() ) ) return;

        $hatch_migrator = new Hatch_Widget_Migrator();
        $hatch_migrator->init();

    }
}

add_action( 'admin_head' , 'hatch_builder_export_init', 10 );

if( !function_exists( 'hatch_builder_export_ajax_init' ) ) {
    function hatch_builder_export_ajax_init(){
        $hatch_migrator = new Hatch_Widget_Migrator();
        add_action( 'wp_ajax_hatch_import_widgets', array( $hatch_migrator, 'import' ) );
    }
}

add_action( 'init' , 'hatch_builder_export_ajax_init' );