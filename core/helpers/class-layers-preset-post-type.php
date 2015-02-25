<?php

class Layers_Preset_Post_Type {

	const POST_TYPE = 'layers_preset';

	public static function init() {
		self::register_post_type();
	}

	private static function register_post_type() {
		register_post_type( self::POST_TYPE, array(
			'labels' => array(
				'name' => 'Presets'
			),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'supports' => array( 'title', 'thumbnail' )
		) );
	}

	public static function get_query() {
		$args = array(
			'post_type' => self::POST_TYPE,
			'nopaging' => true
		);
		$query = new WP_Query( $args );
		return $query;
	}

}

add_action( 'init', array( 'Layers_Preset_Post_Type', 'init' ) );