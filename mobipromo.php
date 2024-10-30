<?php
/*
Plugin Name:    MobiPromo
Plugin URI:     https://getmobipromo.com/
Description:    MobiPromo plugin provides an easy way to verify that you are the owner of a Wordpress website when connecting it to a mobile app created with MobiPromo.
Version:        1.0.0
Author:         MobiPromo
Author URI:     https://getmobipromo.com/
License:        GPL2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('MOBIPROMO_VERSION', '1.0.0');

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there! I'm just a plugin, not much I can do when called directly.";
	exit;
}

if ( is_admin() ) require_once dirname( __FILE__ ) . '/admin.php';

add_action('wp_head', 'mobipromo_wp_head');

register_uninstall_hook(__FILE__, 'mobipromo_delete_plugin_options');

// Add 'mobipromo-site-verification' meta tag to the head of any page
function mobipromo_wp_head() {
	$options = get_option('mobipromo_options');

	if (trim($options['site_verification_key']) != '') {
		echo <<<MOBIPROMO_META
<meta name="mobipromo-site-verification" content="{$options['site_verification_key']}">
MOBIPROMO_META;
	}
}

// Remove mobipromo options
function mobipromo_delete_plugin_options() {
	delete_option('mobipromo_options');
}

?>
