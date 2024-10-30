<?php

// Set-up hooks
add_action('admin_init', 'mobipromo_init' );
add_action('admin_menu', 'mobipromo_add_options_page');

// Init plugin options to white list our options
function mobipromo_init(){
	register_setting( 'mobipromo_plugin_options', 'mobipromo_options', 'mobipromo_validate_options' );
}

// Add menu page
function mobipromo_add_options_page() {
	add_options_page('MobiPromo', 'MobiPromo', 'manage_options', 'mobipromo-settings', 'mobipromo_render_form');
}

// Render the Plugin options form
function mobipromo_render_form() {
	?>
	<div class="wrap">

		<!-- Plugin header and description -->
		<h2>MobiPromo</h2>
		<p>Insert the website verification key obtained when you connected your Wordpress website to a MobiPromo mobile app.</p>
		<p>This key is used to verify that you are the owner of a Wordpress website and to make sure that only you can display
			content from your website into your MobiPromo mobile apps.</p>


		<!-- Beginning of the plugin options form -->
		<form method="post" action="options.php">
			<?php settings_fields('mobipromo_plugin_options'); ?>
			<?php $options = get_option('mobipromo_options'); ?>

			<!-- Table Structure Containing Form Controls -->
			<!-- Each Plugin Option Defined on a New Table Row -->
			<table class="form-table">
				<tr>
					<th scope="row">Website verification key</th>
					<td>
						<input type="text" size="57" name="mobipromo_options[site_verification_key]" value="<?php echo $options['site_verification_key']; ?>" />
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
			</p>
		</form>

		<div style="margin-top:15px; font-style: italic;">
			Creating a mobile app with MobiPromo it's easy and free!
			<br>
			If you haven't created your mobile app yet, just follow the steps below:
			<ol>
				<li>Signup for a free account at <a href="https://getmobipromo.com/" target="_blank">https://getmobipromo.com</a></li>
				<li>Create a new mobile app and give it a name</li>
				<li>Go to the mobile app editor, click <b>Wordpress integration</b> and fill in the address of your website</li>
				<li>A website verification key will be generated for you. Copy that key and insert it in the form above</li>
			</ol>
		</div>

	</div>
	<?php
}

// Sanitize and validate input. Accepts an array, returns a sanitized array.
function mobipromo_validate_options($input) {
	$input['site_verification_key'] =  wp_filter_nohtml_kses($input['site_verification_key']); // Sanitize input (strip html tags, and escape characters)
	if (trim($input['site_verification_key']) == '') {
		add_settings_error( "mobipromo_options", "site_verification_key", "The site verification key can't be empty", $type = 'error' );
	}
	return $input;
}

// Display a 'Settings' link on the main Plugins page
add_filter( 'plugin_action_links', 'mobipromo_plugin_action_links', 10, 2 );
function mobipromo_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/mobipromo.php' ) ) {
		$links[] = '<a href="options-general.php?page=mobipromo-settings">'.__('Settings').'</a>';
	}
	return $links;
}

?>
