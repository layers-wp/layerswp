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

        // Add current builder pages as presets
        add_filter( 'hatch_preset_layouts' , array( $this , 'add_builder_preset_layouts') );

    }

    /**
    *  Simple output of a JSON'd string of the widget data
    */
    function display_export_box( $post ){ ?>
        <textarea id="<?php echo HATCH_THEME_SLUG . '-import-wiget-data'; ?>" style="width: 100%;" rows="15"><?php echo esc_attr( json_encode( $this->export_data( $post ) ) ); ?></textarea>
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
                    'title' => __( 'Portfolio Page', HATCH_THEME_SLUG ),
                    'description' => __( 'Portfolio page, we recommend importing the <a href="http://cdn.oboxsites.com/hatch/hatch-beta-content.xml?ver="' . rand( 0, 100 ) . '>Hatch demo content</a> first.', HATCH_THEME_SLUG ),
                    'screenshot' => get_template_directory_uri() . '/core/assets/images/preset-layouts/portfolio.jpg',
                    'screenshot_type' => 'png',
                    'json' => esc_attr( '{"obox-hatch-builder-85":{"hatch-widget-banner-13":{"slide_time":"","banner_height":"350","banner_ids":"276","banners":{"276":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/portfolio-bg.jpg","color":"#ffffff","repeat":"repeat","position":"center"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":"#ffffff"}},"title":"Welcome to our Portfolio","excerpt":"Check out our latest work","link":"","link_text":""}}},"hatch-widget-portfolio-5":{"design":{"layout":"layout-boxed","fonts":{"align":"text-left","size":"medium","color":""},"columns":"3","gutter":"on","liststyle":"list-masonry","imageratios":"image-no-crop","background":{"image":"","color":"","repeat":"no-repeat","position":"center"}},"text_style":"overlay","show_titles":"on","show_excerpts":"on","excerpt_length":"200","show_call_to_action":"on","call_to_action":"View Project","title":"","excerpt":"","category":"0","posts_per_page":"12","order":"{\"orderby\":\"date\",\"order\":\"desc\"}"}}}' )
                ),
            'blog' => array(
                    'title' => __( 'Blog Page', HATCH_THEME_SLUG ),
                    'description' => __( 'Masonry style blog list page with an intro slider, we recommend importing the <a href="http://cdn.oboxsites.com/hatch/hatch-beta-content.xml?ver="' . rand( 0, 100 ) . '">Hatch demo content</a> first.', HATCH_THEME_SLUG ),
                    'screenshot' => get_template_directory_uri() . '/core/assets/images/preset-layouts/blog.jpg',
                    'screenshot_type' => 'png',
                    'json' => esc_attr( '{"obox-hatch-builder-95":{"hatch-widget-banner-9":{"slide_time":"","banner_height":"350","banner_ids":"280","banners":{"280":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/desk.jpg","color":"#000","repeat":"no-repeat","position":"center","stretch":"on","darken":"on"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":"#fff"}},"title":"Our Blog","excerpt":"Find out the latest news about our products and company","link":"","link_text":""}}},"hatch-widget-post-5":{"design":{"layout":"layout-boxed","fonts":{"align":"text-left","size":"medium","color":""},"columns":"3","gutter":"on","liststyle":"list-masonry","imageratios":"image-square","background":{"image":"","color":"","repeat":"no-repeat","position":"center"}},"text_style":"regular","show_titles":"on","show_excerpts":"on","excerpt_length":"120","show_call_to_action":"on","call_to_action":"Read More","title":"","excerpt":"","category":"0","posts_per_page":"7","order":"{\"orderby\":\"date\",\"order\":\"desc\"}"}}}' )
                ),
            'business' => array(
                    'title' => __( 'Business Page', HATCH_THEME_SLUG ),
                    'screenshot' => get_template_directory_uri() . '/core/assets/images/preset-layouts/home.jpg',
                    'screenshot_type' => 'png',
                    'json' => esc_attr( '{"obox-hatch-builder-29":{"hatch-widget-banner-5":{"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","banner_height":"550","banner_ids":"813,172,568","banners":{"813":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/forest-landscape-2.jpg","color":"#000","repeat":"no-repeat","position":"center","stretch":"on","darken":"on"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":"#fff"}},"title":"Slider Number 1","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut.","link":"#","link_text":"See More"},"172":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/iceland-landscape.jpg","color":"#000","repeat":"no-repeat","position":"center","stretch":"on","darken":"on"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":"#fff"}},"title":"Slider Number 2","excerpt":"Vestibulum arcu risus, porta eget auctor id, rhoncus et massa. Aliquam erat volutpat.","link":"#","link_text":"See More"},"568":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/lake.jpg","color":"#000","repeat":"no-repeat","position":"center"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":"#fff"}},"title":"Slider Number 3","excerpt":"Mauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus, porta eget auctor id, rhoncus et massa.","link":"#","link_text":"See More"}}},"hatch-widget-module-5":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"}},"title":"Features","excerpt":"This \"content\" widget allows you to place any amount of text and images into a multi-column layout.","module_ids":"947,423,63","modules":{"947":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/city_sunlight1.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"4","title":"Content Item 1","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero.","link":"","link_text":""},"423":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/sunset.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"4","title":"Content Item 2","excerpt":"Mauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus.","link":"","link_text":""},"63":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/meeting.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"4","title":"Content Item 3","excerpt":"Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa.","link":"","link_text":""}}},"hatch-widget-banner-7":{"slide_time":"","banner_height":"350","banner_ids":"813,194","banners":{"813":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/2-Matthew-Wiebe.jpg","color":"#000","repeat":"no-repeat","position":"center","stretch":"on","darken":"on"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":"#fff"}},"title":"Hatch is the best WordPress Site Builder I\'ve used since I began using the CMS.","excerpt":"~ Mrs WordPress","link":"","link_text":""},"194":{"design":{"background":{"image":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/japan.jpg","color":"#000","repeat":"no-repeat","position":"center","stretch":"on","darken":"on"},"featuredimage":"","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":"#fff"}},"title":"I cannot wait to start using this on all of my projects in 2015!","excerpt":"~ Mr Developer","link":"","link_text":""}}},"hatch-widget-module-6":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"}},"title":"What we offer","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus.","module_ids":"947,423,63,967","modules":{"947":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/3-Todd-Quackenbush.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"3","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting.","link":"","link_text":""},"423":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/5-Todd-Quackenbush.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"3","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting.","link":"","link_text":""},"63":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/6-Monstruo-Estudio.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"3","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting.","link":"","link_text":""},"967":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"http:\/\/live-hatch.pantheon.io\/wp-content\/uploads\/2014\/12\/bridge.jpg","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"3","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting.","link":"","link_text":""}}}}}' )
                ),
        );

        return apply_filters( 'hatch_preset_layouts' , $hatch_preset_layouts );
    }

    /**
    *  Add our builder pages as presets
    *
    * @param array array of preset layouts that have been set
    */
    function add_builder_preset_layouts( $presets ){

        // Get array of builder pages that exist
        $builder_pages = hatch_get_builder_pages();

        // Start preset page bucket
        $page_presets = array();

        // Loop through the pages and add them to the preset list
        foreach ( $builder_pages as $page ) {
            $page_presets[ $page->ID ] = array(
                'title' => esc_attr( $page->post_title ),
                'screenshot' => get_permalink( $page->ID ),
                'screenshot_type' => 'dynamic',
                'json' =>  esc_attr( json_encode( $this->export_data( $page ) ) ),
                'container_css' => 'hatch-hide hatch-existing-page-preset'
            );
        }

        return array_merge( $presets, $page_presets );
    }

    /**
    * Hatch Page Layout Screenshot Generator
    *
    * Generates an image tag for the screenshot for use in the preset layout selector
    *
    * @param varchar URL to use for the screenshot
    * @param varchar png (for static images) | dynamic (for existing pages)
    * @return varchar <img> tag
    */
    function generate_preset_layout_screenshot( $url = NULL, $type = 'screenshot' ){

        // If there is no URL to parse, return nothing
        if( NULL == $url ) return;

        // Dynamic types generate a screenshot from the WordPress mshots service
        if( 'dynamic' == $type ) {
            $image_url =  'http://s.wordpress.com/mshots/v1/' . urlencode( $url ) . '?w=' . 320 . '&h=' . 480;
        } else {
            $image_url = $url;
        }

        $img = '<img src="' . esc_url( $image_url ) . '" width="320" />';

        return $img;

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
    * @param object Post Object of page to generate export data for
    * @return array An array of sidebar ids that are valid for this page
    */

    public function get_valid_sidebars( $post_object ) {
        global $hatch_widgets;

        // Get all widget instances for each widget
        $widget_instances = $this->get_widget_instances();

        // Get page sidebar ID
        $page_sidebar_id = 'obox-hatch-builder-' . $post_object->ID;

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

    public function page_sidebars_widgets( $post_object = NULL ) {

        if( NULL == $post_object ){
            global $post;
        } else {
            $post = $post_object;
        }

        // Get all widget instances for each widget
        $widget_instances = $this->get_widget_instances();

        // Get valid sidebars to query
        $valid_sidebars = $this->get_valid_sidebars( $post );

        if ( NULL == $valid_sidebars ) return;

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

    function export_data( $post = NULL ){

        if( NULL == $post ) {
            global $post;
        }

        // Get sidebar and widget data for this page
        $sidebars_widgets = $this->page_sidebars_widgets( $post );

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
    * Ajax Import Instantiator
    *
    * This function takes on the widget_data post object and runs the import() function
    */

    public function do_ajax_import(){

        // Set the page ID
        $import_data[ 'post_id' ] = $_POST[ 'post_id' ];

        // Set the Widget Data for import
        $import_data[ 'widget_data' ] = $_POST[ 'widget_data' ];

        // Run the import
        die( $this->import( $import_data ) );
    }

    /**
    * Ajax Create a Builder Page from a preset page
    *
    * This function takes on the Preset Page Data and runs the import() function
    */

    public function create_builder_page_from_preset(){
        global $hatch_widgets;

        $check_builder_pages = hatch_get_builder_pages();

        if( 0 == count( $check_builder_pages ) ){
            $post_title = __( 'Home Page' );
        } else {
            $post_title = $_POST[ 'post_title' ];
        }

        // Generate builder page and return page ID
        $import_data[ 'post_id' ] = hatch_create_builder_page(  );
        $new_page = get_page( $import_data[ 'post_id' ] );

        // Register Builder Sidebar
        $hatch_widgets->register_builder_sidebar( $import_data[ 'post_id' ] );

        // Add Widget Data to the import array
        $import_data[ 'widget_data' ] = $_POST[ 'widget_data' ];

        // Run data import
        $import_progress = $this->import( $import_data );

        if( count( $check_builder_pages ) == 0 ){
            update_option( 'page_on_front', $import_data[ 'post_id' ] );
            update_option( 'show_on_front', 'page' );
        }

        $results = array(
                'post_id' => $import_data[ 'post_id' ],
                'post_title' => $new_page->post_title,
                'importer' => $import_progress,
                'customizer_location' => admin_url() . 'customize.php?url=' . esc_url( get_the_permalink( $import_data[ 'post_id' ] ) )
            );

        die( json_encode( $results ) );
    }

    /**
    *  Import
    */

    public function import( $import_data = NULL ) {

        if( NULL == $import_data ) return;

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

        foreach( $import_data[ 'widget_data' ] as $sidebar_id => $sidebar_data ) {

            // If this is a builder page, set the ID to the current page we are importing INTO
            if( FALSE !== strpos( $sidebar_id , 'obox-hatch-builder-' ) ) $sidebar_id = 'obox-hatch-builder-' . $import_data[ 'post_id' ];

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

        return $results;
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
        add_action( 'wp_ajax_hatch_import_widgets', array( $hatch_migrator, 'do_ajax_import' ) );
        add_action( 'wp_ajax_hatch_create_builder_page_from_preset', array( $hatch_migrator, 'create_builder_page_from_preset' ) );
    }
}

add_action( 'init' , 'hatch_builder_export_ajax_init' );