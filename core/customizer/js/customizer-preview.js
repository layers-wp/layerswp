/**
* Customizer Preview JS file
*
* This file contains global widget functions
*
* @package Layers
* @since Layers 1.0.4
* Contents
* 1 - Fix customizer FOUC during render
*
* Author: Obox Themes
* Author URI: http://www.oboxthemes.com/
* License: GNU General Public License v2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery.noConflict();

jQuery(document).ready(function($) {

	/**
	 * 1- Fix customizer FOUC during render
	 *
	 * Fix issue where font size is incorrectly displayed due to % font-size in an iframe in chrome
	 */

	$('body').css({ 'font-size': '1.5rem' });
	setTimeout(function() {
		$('body').css({ 'font-size': '1.5rem' });
	},3000 );

});