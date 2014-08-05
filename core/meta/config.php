<?php /**
  * Post & Page Meta Configuration File
 *
 * This file is used to define the post meta panels used the hatch theme for all post types
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Meta_Config {

	public function meta_data(){

		// Post Meta
		$custom_meta['post'] = array(
			);

		// Page Meta
		$custom_meta['page'] = array(
			'builder-button' => array(
				'title' => '',
				'elements' => array(),
				'position' => 'sidebar',
			)
		);

		return apply_filters( 'hatch_custom_meta', $custom_meta );
	}
}