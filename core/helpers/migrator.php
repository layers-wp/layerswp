<?php /**
 * Widget Exporter
 *
 * This file contains the widget Export/Import functionality in Layers
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Widget_Migrator {

	private static $instance;

	private static $widget_backup_key;

	/**
	*  Initiator
	*/
	public static function get_instance(){
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Layers_Widget_Migrator();
		}
		return self::$instance;
	}
	/**
	*  Constructor
	*/
	public function __construct() {
	}

	public function init() {

		// Add current builder pages as presets
		add_filter( 'layers_preset_layouts' , array( $this , 'add_builder_preset_layouts') );

	}


	/**
	*  Make sure that the template directory is nice ans clean for JSON
	*/

	function get_translated_dir_uri(){
		return str_replace('/', '\/', get_template_directory_uri() );
	}

	/**
	*  Make sure that the stylesheet directory is nice ans clean for JSON
	*/

	function get_translated_stylesheet_uri(){
		return str_replace('/', '\/', get_stylesheet_directory_uri() );
	}

	/**
	*  Layers Preset Widget Page Layouts
	*/
	function get_preset_layouts(){
		$layers_preset_layouts = array();

		$layers_preset_layouts = array(

			'application' => array(
					'title' => __( 'Application' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/application.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-555":{"layers-widget-slide-152":{"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","slide_height":"550","design":{"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"slide_ids":"575","slides":{"575":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":""}},"title":"Incredible Application","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"#","link_text":"Purchase Now"}}},"layers-widget-column-125":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-center","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"Unbelievable Features","excerpt":"Our services run deep and are backed by over ten years of experience.","column_ids":"347,191","columns":{"347":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imageratios":"image-no-crop","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":""}},"width":"6","title":"Your feature title","excerpt":"Give us a brief description of the feature that you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""},"191":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":""}},"width":"6","title":"Your feature title","excerpt":"Give us a brief description of the feature that you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""}}},"layers-widget-slide-154":{"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","slide_height":"350","design":{"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"slide_ids":"701","slides":{"701":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":""}},"title":"Purchase for $0.99","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"#","link_text":"Purchase Now"}}}}}' )
				),
			'contact-page' => array(
					'title' => __( 'Contact Page' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/contact-page.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-557":{"layers-widget-map-15":{"design":{"layout":"layout-fullwidth","fonts":{"align":"text-center","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"0","right":"","bottom":"0","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"map_height":"400","show_google_map":"on","title":"","excerpt":"","google_maps_location":"Green Point, Cape Town, South Africa","google_maps_long_lat":"","address_shown":"","contact_form":""},"layers-widget-column-130":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"154,981","columns":{"154":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"large","color":""}},"width":"9","title":"About Us","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.\r\n\r\nMauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus, porta eget auctor id, rhoncus et massa. Aliquam erat volutpat.\r\n\r\nSed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa.\r\n\r\nMauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus, porta eget auctor id, rhoncus et massa. Aliquam erat volutpat.","link":"","link_text":""},"981":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imageratios":"image-landscape","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"3","title":"Come visit us!","excerpt":"Building\r\nStreet\r\nTown\r\nCountry","link":"","link_text":""}}},"layers-widget-column-131":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"#f3f3f3","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"962,93,77,478","columns":{"962":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"3","title":"Philosophy title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"","link_text":""},"93":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"3","title":"Philosophy title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"","link_text":""},"77":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"3","title":"Philosophy title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"","link_text":""},"478":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"3","title":"Philosophy title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","link":"","link_text":""}}}}}' )
				),
			'landing' => array(
					'title' => __( 'Landing Page' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/landing.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-556":{"layers-widget-column-127":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-center","size":"large","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"Amazing Opportunity","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit.","column_ids":"187,228,881","columns":{"187":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"small","color":""}},"width":"4","title":"Unique Selling Point","excerpt":"Give us a brief description of what you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""},"228":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"small","color":""}},"width":"4","title":"Unique Selling Point","excerpt":"Give us a brief description of what you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""},"881":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"small","color":""}},"width":"4","title":"Unique Selling Point","excerpt":"Give us a brief description of what you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""}}},"layers-widget-column-128":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"187","columns":{"187":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imageratios":"image-no-crop","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":""}},"width":"12","title":"Featured Image","excerpt":"","link":"","link_text":""}}},"layers-widget-slide-156":{"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","slide_height":"350","design":{"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"slide_ids":"236","slides":{"236":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"medium","color":""}},"title":"Wow. Just wow. I\'ve yet to use a site builder that\'s as good as this.","excerpt":"Mrs. WordPress","link":"","link_text":""}}}}}' )
				),
			'lookbook-page' => array(
					'title' => __( 'Lookbook Page' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/lookbook-page.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-563":{"layers-widget-slide-158":{"design":{"layout":"layout-full-screen","advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","slide_height":"550","slide_ids":"276,257,405,523","slides":{"276":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":""}},"title":"2015 Lookbook","excerpt":"","link":"","link_text":""},"257":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-right","fonts":{"align":"text-center","size":"large","color":""}},"title":"Unique ecommerce item","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""},"405":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-left","fonts":{"align":"text-center","size":"large","color":""}},"title":"Unique ecommerce item","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""},"523":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-right","fonts":{"align":"text-center","size":"large","color":""}},"title":"Unique ecommerce item","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""}}}}}' )
				),
			'one-pager' => array(
					'title' => __( 'One Pager' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/one-pager.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-566":{"layers-widget-slide-160":{"design":{"layout":"layout-full-screen","advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"show_slider_arrows":"on","show_slider_dots":"on","slide_time":"","slide_height":"550","slide_ids":"817,77,954","slides":{"817":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-center","size":"large","color":""}},"title":"One Page Feature Title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""},"77":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-left","fonts":{"align":"text-center","size":"large","color":""}},"title":"Second Feature Title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""},"954":{"design":{"background":{"image":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/tile.png","color":"#efefef","repeat":"repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-right","fonts":{"align":"text-center","size":"large","color":""}},"title":"Third Feature Title","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim.","link":"","link_text":""}}},"layers-widget-column-138":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"0","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"488","columns":{"488":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"https:\/\/vimeo.com\/29959550","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"12","title":"","excerpt":"","link":"","link_text":""}}},"layers-widget-column-139":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"30","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"575,52,488","columns":{"575":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""},"52":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""},"488":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Your service title","excerpt":"Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.","link":"","link_text":""}}},"layers-widget-column-140":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-center","size":"medium","color":""},"background":{"image":"","color":"#f3f3f3","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"Our Work","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.","column_ids":"575,953,410,16,796,728","columns":{"575":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""},"953":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""},"410":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""},"16":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""},"796":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""},"728":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\u2019ve meticulously created.","link":"","link_text":""}}},"layers-widget-map-17":{"design":{"layout":"layout-fullwidth","fonts":{"align":"text-center","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"0","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"map_height":"400","show_google_map":"on","title":"Find Us","excerpt":"We are based in one of the most beautiful places on earth. Come visit us!","google_maps_location":"Green Point, Cape Town, South Africa","google_maps_long_lat":"","address_shown":"","contact_form":""}}}' )
				),
			'portfolio-page' => array(
					'title' => __( 'Portfolio Page' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/portfolio-page.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-565":{"layers-widget-column-136":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"Our Amazing Work","excerpt":"Our services run deep and are backed by over ten years of experience.","column_ids":"552,654,592,854,454,939","columns":{"552":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""},"654":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""},"592":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""},"854":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""},"454":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""},"939":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"' . $this->get_translated_dir_uri() . '\/assets\/images\/preset-layouts\/demo-image.png","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"4","title":"Portfolio Item","excerpt":"Give us a brief description of the work you\'ve meticulously created.","link":"","link_text":""}}}}}' )
				),
			'video-page' => array(
					'title' => __( 'Video Page' , 'layerswp' ),
					'screenshot' => '//layerswp.s3.amazonaws.com/preset-layouts/video-page.png',
					'screenshot_type' => 'png',
					'json' => esc_attr( '{"obox-layers-builder-564":{"layers-widget-column-133":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-center","size":"large","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"0","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"Welcome to our short film","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit.","column_ids":"153","columns":{"153":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"https:\/\/vimeo.com\/29959550","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"12","title":"","excerpt":"","link":"","link_text":""}}},"layers-widget-column-134":{"design":{"layout":"layout-boxed","gutter":"on","fonts":{"align":"text-left","size":"medium","color":""},"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"advanced":{"customclass":"","customcss":"","padding":{"top":"","right":"","bottom":"","left":""},"margin":{"top":"","right":"","bottom":"","left":""}}},"title":"","excerpt":"","column_ids":"621,795","columns":{"621":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"medium","color":""}},"width":"6","title":"About this video","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa.\r\n\r\nAenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa. Aliquam vitae nunc vestibulum mauris tempor suscipit id sed lacus. Vestibulum arcu risus, porta eget auctor id, rhoncus et massa. Aliquam erat volutpat.","link":"","link_text":""},"795":{"design":{"background":{"image":"","color":"","repeat":"no-repeat","position":"center"},"featuredimage":"","featuredvideo":"","imagealign":"image-top","fonts":{"align":"text-left","size":"small","color":""}},"width":"6","title":"Video Credits","excerpt":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa. Sed ac orci libero, eu dignissim enim. Aenean urna sem, cursus ut elementum sed, pellentesque ac massa. Mauris sit amet semper massa.","link":"","link_text":""}}}}}' )
				),
			'blank' => array(
					'title' => __( 'Blank Page' , 'layerswp' ),
					'screenshot' => NULL,
					'json' => esc_attr( '{}' ),
					'container-css' => 'blank-product'
				),
		);

		return apply_filters( 'layers_preset_layouts' , $layers_preset_layouts );
	}

	/**
	*  Add our builder pages as presets
	*
	* @param array array of preset layouts that have been set
	*/
	function add_builder_preset_layouts( $presets ){

		// Get array of builder pages that exist
		$builder_pages = layers_get_builder_pages();

		// Start preset page bucket
		$page_presets = array();

		// Loop through the pages and add them to the preset list
		foreach ( $builder_pages as $page ) {
			$page_presets[ $page->ID ] = array(
				'title' => esc_attr( $page->post_title ),
				'screenshot' => get_permalink( $page->ID ),
				'screenshot_type' => 'dynamic',
				'json' =>  esc_attr( json_encode( $this->export_data( $page ) ) ),
				'container-css' => 'l_admin-hide layers-existing-page-preset'
			);
		}

		return array_merge( $presets, $page_presets );
	}

	/**
	* Layers Page Layout Screenshot Generator
	*
	* Generates an image tag for the screenshot for use in the preset layout selector
	*
	* @param string URL to use for the screenshot
	* @param string png (for static images) | dynamic (for existing pages)
	* @return string <img> tag
	*/
	function generate_preset_layout_screenshot( $url = NULL, $type = 'screenshot' ){

		// If there is no URL to parse, return nothing
		if( NULL == $url ) return;

		// Dynamic types generate a screenshot from the WordPress mshots service
		if( 'dynamic' == $type ) {
			$image_url =  '//s.wordpress.com/mshots/v1/' . urlencode( $url ) . '?w=' . 320 . '&h=' . 480;
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
	*  Get specific widget data
	*/
	function get_widget_data( $widget_key ) {
		global $wp_widget_factory;

		foreach( $wp_widget_factory->widgets as $widget_object => $widget_data ) {
			if(  $widget_key == $widget_data->id_base ){
				return $widget_data;
			}
		}
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
	* @param object Post Object of page to generate export data
	* @return array An array of sidebar ids that are valid for this page
	*/

	public function get_valid_sidebars( $post_object ) {
		global $layers_widgets;

		// Get all widget instances for each widget
		$widget_instances = $this->get_widget_instances();

		// Get page sidebar ID
		$page_sidebar_id = 'obox-layers-builder-' . $post_object->ID;

		// Get sidebars and their unique widgets IDs
		$sidebars_widgets = get_option( 'sidebars_widgets' );

		// Setup valid_sidebars() array
		$valid_sidebars = array();

		// Setup valid sidebars
		$valid_sidebars[] = $page_sidebar_id;

		// Get all dynamic sidebars
		$dynamic_sidebars = $layers_widgets->get_dynamic_sidebars();

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
				if( FALSE !== strpos( $widget_id, 'layers-widget-sidebar' ) ) {

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
	* @param object Post Object of page to generate export data for
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
	* Widget As Content
	*
	* @param object Widget Export data
	* @return string A plain text version of the page content
	*/

	function page_widgets_as_content( $export_data = NULL ) {

		if( empty( $export_data ) ) return false;

		if( is_string( $export_data ) ) $export_data = json_decode( $export_data );
		// Set the bare content variable
		$page_content = '';

		// Loop through raw export data and populate the content
		foreach( $export_data as $data ){
			if( isset( $data->name ) ) {
$page_content .= '* ' . $data->name. '
';
			}
		}

		return $page_content;
	}

	/**
	* Widget Plain Text
	*
	* @param object Post Object of page to generate export data for
	* Get widget data for a specific page in plain english
	*/

	function page_widget_data( $post_or_widget_json = NULL ){

		if( is_object( $post_or_widget_json ) ) {
			// Get sidebar and widget data for this page
			$sidebars_widgets = $this->page_sidebars_widgets( $post_or_widget_json );
		} else {
			$sidebars_widgets = json_decode( $post_or_widget_json );
		}

		if( empty( $sidebars_widgets ) ) return;

		$keys = array();

		foreach( $sidebars_widgets as $option => $data ){

			foreach( $data as $widget_instance_id => $widget_info ) {

				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$id_base = str_replace( ' - ', '', $id_base );
				$widget_data = $this->get_widget_data( $id_base );
				$keys[ $widget_instance_id ] = $widget_data;
			}
		}

		// Return modified sidebar widgets
		return $keys;

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
					$validated_data[ $option ] = stripslashes( $option_data );
				}

			} else {
				$validated_data[ $option ] = stripslashes( $option_data );
			}
		}

		return $validated_data;
	}

	/**
	*  Get attachment ID from URL, used when importing images
	*/

	public function get_attachment_id_from_url($img_tag) {
		global $wpdb;

		if( is_object( $img_tag ) ) return;

		preg_match("/src='([^']+)/i", $img_tag , $img_url_almost );

		if( empty( $img_url_almost ) ) return NULL;

		$url = str_ireplace( "src='", "",  $img_url_almost[0]);

		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $url ) );
	}

	/**
	*  Check if this image exists in our media library
	*/

	public function check_for_image_in_media( $image_url = NULL ){
		global $wpdb;

		if( NULL == $image_url ) return;

		$image_pieces = explode( '/', $image_url );

		$i = $image_pieces[count($image_pieces)-1];

		// Setup the Stylesheet directories to pick up the images from a local directory
		$theme_image_dir = get_stylesheet_directory() . '/assets/preset-images/' . $i;
		$theme_image_url = get_stylesheet_directory_uri() . '/assets/preset-images/' . $i;

		$media_library_image = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid LIKE %s", "%$i%" ) );

		// If the image we are looking for exists in the media library send it over
		if( $media_library_image ) return $media_library_image;

		// If the image we are looking for exists in the theme directory, use that instead
		if( file_exists( $theme_image_dir ) ) {
			return $this->get_attachment_id_from_url( media_sideload_image( $theme_image_url, 0 ) );
		}

		// If nothing is found, just return NULL
		return NULL;
	}

	/**
	*  Import Images
	*/

	public function check_for_images( $data ) {

		$validated_data = array();

		if( !is_array( $data ) ) return stripslashes( $data );

		foreach( $data as $option => $option_data ){

			if( is_array( $option_data ) ) {

				$validated_data[ $option ] = $this->check_for_images( $option_data );

			} elseif( 'image' == $option || 'featuredimage' == $option ) {

				// Check to see if this image exists in our media library already
				$check_for_image = $this->check_for_image_in_media( $option_data );

				if( NULL != $check_for_image ) {
					$get_image_id = $check_for_image;
				} else {
					// @TODO: Try improve the image loading
					$import_image = media_sideload_image( $option_data , 0 );

					if( NULL != $import_image && !is_wp_error( $import_image ) ) {
						$get_image_id = $this->get_attachment_id_from_url( $import_image );
					}
				}

				if( isset( $get_image_id ) ) {
					$validated_data[ $option ] = $get_image_id;
				} else {
					$validated_data[ $option ] = stripslashes( $option_data );
				}

			} else {

				$validated_data[ $option ] = stripslashes( $option_data );

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

		if( !check_ajax_referer( 'layers-migrator-import', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

		// Set the page ID
		$import_data[ 'post_id' ] = $_POST[ 'post_id' ];

		// Set the Widget Data for import
		$import_data[ 'widget_data' ] = $_POST[ 'widget_data' ];

		// Run data import
		$import_progress = $this->import( $import_data );

		$results = array(
				'post_id' => $import_data[ 'post_id' ],
				'data_report' => $import_progress,
				'customizer_location' => admin_url() . 'customize.php?url=' . esc_url( get_permalink( $import_data[ 'post_id' ] ) )
			);

		do_action( 'layers_backup_sidebars_widgets' );

		die( json_encode( $results ) );
	}

	/**
	* Ajax Duplication
	*
	* This function takes a page, generates export cod and creates a duplicate
	*/

	public function do_ajax_duplicate(){

		if( !check_ajax_referer( 'layers-migrator-duplicate', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

		// We need a page title and post ID for this to work
		if( !isset( $_POST[ 'post_title' ] ) || !isset( $_POST[ 'post_id' ]  ) ) return;

		$pageid = layers_create_builder_page( esc_attr( $_POST[ 'post_title' ] . ' ' . __( '(Copy)' , 'layerswp' ) ) );

		// Create the page sidebar on the fly
		Layers_Widgets::register_builder_sidebar( $pageid );

		// Set the page ID
		$import_data[ 'post_id' ] = $pageid;

		$post = get_post( $_POST[ 'post_id' ] );

		// Set the Widget Data for import
		$import_data[ 'widget_data' ] = $this->export_data( $post );

		// Run data import
		$import_progress = $this->import( $import_data );

		$results = array(
				'post_id' => $pageid,
				'data_report' => $import_progress,
				'page_location' => admin_url() . 'post.php?post=' . $pageid . '&action=edit&message=1'
			);

		do_action( 'layers_backup_sidebars_widgets' );

		die( json_encode( $results ) );
	}

	/**
	* Ajax Update Builder Page details
	*
	* This function will update the builder page with a new page title and more (once we add more)
	*/

	public function update_builder_page(){

		// We need a page title and post ID for this to work
		if( !isset( $_POST[ 'post_title' ] ) || !isset( $_POST[ 'post_id' ]  ) ) return;

		$pageid = layers_create_builder_page( esc_attr( $_POST[ 'post_title' ] ), esc_attr( $_POST[ 'post_id' ] ) );

		die( $pageid );
	}

	/**
	* Ajax Create a Builder Page from a preset page
	*
	* This function takes on the Preset Page Data and runs the import() function
	*/

	public function create_builder_page_from_preset(){
		global $layers_widgets, $wpdb;

		if( !check_ajax_referer( 'layers-migrator-preset-layouts', 'nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce


		remove_action('pre_post_update', 'wp_save_post_revision');
		$post = array();
		$import_data = array();

		/**
		* Check to see if we've created a builder page before
		*/

		$check_builder_pages = layers_get_builder_pages();

		if( isset( $_POST[ 'post_title' ] )  ){
			$page_title = $_POST[ 'post_title' ];
		} else {
			$page_title = __( 'Home Page' , 'layerswp' );
		}

		/**
		* Create Builder Page
		*/

		$import_data[ 'post_id' ] = layers_create_builder_page( $page_title );
		$new_page_id = $import_data[ 'post_id' ];
		$new_page = get_post( $import_data[ 'post_id' ] );

		/**
		* Register sidebar
		*/

		$layers_widgets->register_builder_sidebar( $new_page_id );

		/**
		* Set Import Parameters
		*/

		if( isset( $_POST[ 'widget_data' ] ) ) {
			$import_data[ 'widget_data' ] = $_POST[ 'widget_data' ];
		} else {
			$import_data[ 'widget_data' ] = NULL;
		}

		/*
		* Run Import
		*/

		$import_progress = $this->import( $import_data, TRUE );

		/**
		* Maybe set home page
		*/

		if( count( $check_builder_pages ) == 0 ){
			update_option( 'page_on_front', $new_page_id );
			update_option( 'show_on_front', 'page' );
		}

		/**
		* Create Page
		*/
		$page_raw_widget_data = array(
			'post_id' => $new_page_id,
			'post_title' => esc_attr( $page_title ),
			'widget_data' => $import_data[ 'widget_data' ]
		);

		$export_data = $this->page_widget_data( json_encode( $import_data[ 'widget_data' ] ) );

		update_post_meta( $new_page_id, '_layers_widget_order', trim( $this->page_widgets_as_content( $export_data ) ) );

		update_option( 'layers_cron_page_backup' , $new_page_id );

		/*
		* Send results home
		*/

		$results = array(
			'post_id' => $new_page_id,
			'post_title' => esc_attr( $page_title ),
			'data_report' => $import_progress,
			'customizer_location' => admin_url() . 'customize.php?url=' . esc_url( get_permalink( $new_page_id ) )
		);

		die( json_encode( $results ) );
	}

	/**
	*  Import
	*/

	public static function clear_page_sidebars_widget( $sidebar_key = NULL ){

		global $sidebars_widgets;

		if( NULL == $sidebar_key ) return;

		if( isset( $sidebars_widgets[ $sidebar_key ] ) ){

			$sidebar_data = $sidebars_widgets[ $sidebar_key ];

			foreach ( $sidebar_data as $widget ) {
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget );
				$instance_id_number = str_replace( $id_base . '-', '', $widget );

				$single_widget_instances = get_option( 'widget_' . $id_base );

				// Remove this page's widgets
				if( isset( $single_widget_instances[ $instance_id_number ] ) ){
					unset( $single_widget_instances[ $instance_id_number ] );
				}

				update_option( 'widget_' . $id_base, $single_widget_instances );
			}

			// Remove this page's widget information
			unset( $sidebars_widgets[ $sidebar_key ] );

			update_option( 'sidebars_widgets', $sidebars_widgets );
		}

	}

	/**
	*  Import
	*/

	public function import( $import_data = NULL, $is_preset = FALSE, $clear_page = FALSE ) {

		if( NULL == $import_data ) return;

		global $wp_registered_sidebars, $sidebars_widgets;

		// Get all available widgets site supports
		$available_widgets = $this->available_widgets();

		// Get all existing widget instances
		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data[ 'id_base' ] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}

		// Begin results
		$results = array();

		if( empty( $import_data[ 'widget_data' ] ) ) return;

		foreach( $import_data[ 'widget_data' ] as $sidebar_id => $sidebar_data ) {

			$layers_sidebar_key = 'obox-layers-builder-';

			if( FALSE !== $clear_page && isset( $import_data[ 'post_id' ] ) ) $this->clear_page_sidebars_widget( $layers_sidebar_key . $import_data[ 'post_id' ] );

			// If this is a builder page, set the ID to the current page we are importing INTO
			if( FALSE !== strpos( $sidebar_id , $layers_sidebar_key ) ) $sidebar_id = $layers_sidebar_key . $import_data[ 'post_id' ];

			// Check if sidebar is available on this site
			// Otherwise add widgets to inactive, and say so
			if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
				$sidebar_available = true;
				$use_sidebar_id = $sidebar_id;
				$sidebar_message_type = 'success';
				$sidebar_message = '';
			} elseif( isset( $import_data[ 'post_hash' ] ) ) {
				$args = array(
					'meta_key' => '_layers_hash',
					'meta_value' => $import_data[ 'post_hash' ],
					'post_type' => 'page',
					'post_status' => 'publish,draft',
					'posts_per_page' => 1
				);

				$check_for_post = get_posts($args);

				if( !empty( $check_for_post ) ){
					$new_post_id = $check_for_post[0]->ID;
				} else {
					$new_post_id = layers_create_builder_page( $import_data[ 'post_title' ] );
					update_post_meta( $new_post_id, '_layers_hash', $import_data[ 'post_hash' ], false );
				}

				if( $new_post_id ) {
					$sidebar_available = true;
					$use_sidebar_id = $layers_sidebar_key . $new_post_id;
					$sidebar_message_type = 'success';
					$sidebar_message = '';
				} else {
					$sidebar_available = false;
					$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
					$sidebar_message_type = 'error';
					$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)' , 'layerswp' );
				}
			} else {
				$sidebar_available = false;
				$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
				$sidebar_message_type = 'error';
				$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)' , 'layerswp' );
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
							$widget_message = __( 'Widget already exists' , 'layerswp' ); // explain why widget not imported

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
						$widget_message = __( 'Imported' , 'layerswp' );
					} else {
						$widget_message_type = 'warning';
						$widget_message = __( 'Imported to Inactive' , 'layerswp' );
					}

				}
				// Result for widget instance
				$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
				$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = isset( $widget->title ) ? $widget->title : __( 'No Title' , 'layerswp' ); // show "No Title" if widget instance is untitled
				$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
				$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

			}
		}
		ob_start();
		dynamic_sidebar( 'obox-layers-builder-' . $import_data[ 'post_id' ] );
		$results[ 'sidebar_html' ] = trim( ob_get_clean() );

		if( FALSE == $is_preset ) {
			do_action( 'layers_backup_sidebars_widgets' );
		}

		return $results;
	}
}

if( !function_exists( 'layers_builder_export_init' ) ) {
	function layers_builder_export_init(){
		global $pagenow, $post;

		// Make sure we're on the post edit screen
		if( 'post.php' != $pagenow ) return;

		// Make sure we're editing a post
		if( 'page' != get_post_type( $post->ID ) || 'builder.php' != basename( get_page_template() ) ) return;

		$layers_migrator = new Layers_Widget_Migrator();
		$layers_migrator->init();

	}
}
add_action( 'admin_head' , 'layers_builder_export_init', 10 );

if( !function_exists( 'layers_builder_export_ajax_init' ) ) {
	function layers_builder_export_ajax_init(){
		$layers_migrator = new Layers_Widget_Migrator();

		add_action( 'wp_ajax_layers_import_widgets', array( $layers_migrator, 'do_ajax_import' ) );
		add_action( 'wp_ajax_layers_create_builder_page_from_preset', array( $layers_migrator, 'create_builder_page_from_preset' ), 50 );
		add_action( 'wp_ajax_layers_update_builder_page', array( $layers_migrator, 'update_builder_page' ) );
		add_action( 'wp_ajax_layers_duplicate_builder_page', array( $layers_migrator, 'do_ajax_duplicate' ) );
	}
}
add_action( 'init' , 'layers_builder_export_ajax_init' );


/**
*  Simple output of a JSON'd string of the widget data
*/

function layers_create_export_file(){

	$layers_migrator = new Layers_Widget_Migrator();

	// Make sur a post ID exists or return
	if( !isset( $_GET[ 'post' ] ) ) return;

	// Get the post ID
	$post_id = $_GET[ 'post' ];

	$post = get_post( $post_id );

	$widget_data = json_encode( $layers_migrator->export_data( $post ) );

	$filesize = strlen( $widget_data );

	// Headers to prompt "Save As"
	header( 'Content-Type: application/json' );
	header( 'Content-Disposition: attachment; filename=' . $post->post_name .'-' . date( 'Y-m-d' ) . '.json' );
	header( 'Expires: 0' );
	header( 'Cache-Control: must-revalidate' );
	header( 'Pragma: public' );
	header( 'Content-Length: ' . $filesize );

	// Clear buffering just in case
	@ob_end_clean();
	flush();

	// Output file contents
	die( $widget_data );

	// Stop execution
	wp_redirect( admin_url( 'post.php?post=' . $post->ID . '&action=edit'  ) );

}
if( isset( $_GET[ 'layers-export' ] ) ) {
	add_action( 'init' , 'layers_create_export_file' );
}