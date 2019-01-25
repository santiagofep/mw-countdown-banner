<?php
if ( ! defined( 'WPINC' ) )  die;

/**
 * Settings Page Example
 * @link https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */

function mw_ecommerce_tools_page_html () {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
	</div>
	<?php
}
function mwcb_options_page_html () {
   // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
      <h1><?php esc_html_e( 'Countdown Banner' , 'mw-countdown-banner' ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'mwcd' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'mwcd' );
        // output save settings button
        submit_button( 'Save Settings' );
        ?>
      </form>
    </div>
    <?php

    $setting = get_option('mwcb_settings');
    print_r($setting);
}

function mwcb_options_page() {

	if (empty ( $GLOBALS['admin_page_hooks']['mw_ecommerce_tools'] ) ) {
		add_menu_page(
	        'Ecommerce Tools',
	        'Ecommerce Tools',
	        'manage_options',
	        'mw_ecommerce_tools',
	        'mw_ecommerce_tools_page_html',
	        'dashicons-cart',
	        9000
	    );
	}

	add_submenu_page(
	    'mw_ecommerce_tools',
	    'Ecommerce Tools',
	    'Countdown Banner',
	    'manage_options',
	    'mwcd',
	    'mwcb_options_page_html'
	); 
}
add_action( 'admin_menu', 'mwcb_options_page' );

/**
 * Registers a setting.
 */
function mwcd_settings_init() {
	register_setting( 'mwcd', 'mwcb_settings');
	add_settings_section( 'mwcb_settings_section', __('Display Settings', 'mw-countdown-banner'), 'mwcb_settings_section_cb', 'mwcd' );

	add_settings_field( 'mwcb_img_field', __('Image url', 'mw-countdown-banner'), 'mwcb_img_field_cb', 'mwcd', 'mwcb_settings_section' );
	add_settings_field( 'mwcb_textarea_field', __('Text', 'mw-countdown-banner'), 'mwcb_textarea_field_cb', 'mwcd', 'mwcb_settings_section' );
	add_settings_field( 'mwcb_textcolor_field', __('Text color', 'mw-countdown-banner'), 'mwcb_textcolor_field_cb', 'mwcd', 'mwcb_settings_section' );
	add_settings_field( 'mwcb_bgcolor_field', __('Background color', 'mw-countdown-banner'), 'mwcb_bgcolor_field_cb', 'mwcd', 'mwcb_settings_section' );
	add_settings_field( 'mwcb_cdtime_field', __('Timer', 'mw-countdown-banner'), 'mwcb_cdtime_field_cb', 'mwcd', 'mwcb_settings_section' );
    add_settings_field( 'mwcb_cookie_field', __('Cookie duration', 'mw-countdown-banner'), 'mwcb_cookie_field_cb', 'mwcd', 'mwcb_settings_section' );
	add_settings_field( 'mwcb_exclude_field', __('Dont show in', 'mw-countdown-banner'), 'mwcb_exclude_field_cb', 'mwcd', 'mwcb_settings_section' );
} 
add_action( 'admin_init', 'mwcd_settings_init' );



function mwcb_settings_section_cb () {
	esc_html_e( 'In this secction you can change the styles, messages and display configuration of the banner' , 'mw-countdown-banner' );
}

function mwcb_img_field_cb () {
	// get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>
    <input type="text" name="mwcb_settings[imgurl]" value="<?php echo isset( $setting[imgurl] ) ? esc_attr( $setting[imgurl] ) : ''; ?>" style="width: 295px">
    <?php
}

function mwcb_textarea_field_cb () {
	// get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>
    <textarea name="mwcb_settings[text]" id="" cols="38" rows="3"><?php echo isset( $setting[text] ) ? esc_attr( $setting[text] ) : ''; ?></textarea>
    <?php
}

function mwcb_textcolor_field_cb () {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>
    <input type="text" name="mwcb_settings[textcolor]" value="<?php echo isset( $setting[textcolor] ) ? esc_attr( $setting[textcolor] ) : ''; ?>" class="mwcb-color-picker">
    <?php
}

function mwcb_bgcolor_field_cb () {
	// get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>
    <input type="text" name="mwcb_settings[bgcolor]" value="<?php echo isset( $setting[bgcolor] ) ? esc_attr( $setting[bgcolor] ) : ''; ?>" class="mwcb-color-picker">
    <?php
}

function mwcb_cdtime_field_cb () {
	// get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>	
    	<label>
    		<input type="number" min="0" max="365" name="mwcb_settings[cdtimerdays]" style="width:45px" value="<?php echo isset( $setting[cdtimerdays] ) ? esc_attr( $setting[cdtimerdays] ) : '0'; ?>">
    		<span><?php esc_html_e( 'Days', 'mw-countdown-banner' ) ?>, </span>
    	</label>
    	<label>
    		<input type="number" min="0" max="23" name="mwcb_settings[cdtimerhours]" style="width:45px" value="<?php echo isset( $setting[cdtimerhours] ) ? esc_attr( $setting[cdtimerhours] ) : '0'; ?>">
    		<span><?php esc_html_e( 'Hours', 'mw-countdown-banner' ) ?>, </span>
    	</label>
    	<label>
    		<input type="number" min="0" max="59" name="mwcb_settings[cdtimerminutes]" style="width:45px" value="<?php echo isset( $setting[cdtimerminutes] ) ? esc_attr( $setting[cdtimerminutes] ) : '0'; ?>">
    		<span><?php esc_html_e( 'Minutes', 'mw-countdown-banner' ) ?>, </span>
    	</label>
    	<label>
    		<input type="number" min="0" max="59" name="mwcb_settings[cdtimerseconds]" style="width:45px" value="<?php echo isset( $setting[cdtimerseconds] ) ? esc_attr( $setting[cdtimerseconds] ) : '0'; ?>">
    		<span><?php esc_html_e( 'Seconds', 'mw-countdown-banner' ) ?> </span>
    	</label>
		
    <?php
}

function mwcb_cookie_field_cb() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>  
    <input type="number" name="mwcb_settings[cookieduration]" value="<?php echo isset( $setting[cookieduration] ) ? esc_attr( $setting[cookieduration] ) : '0'; ?>" style="width: 50px;"> <strong><?php esc_html_e( 'Days', 'mw-countdown-banner' ) ?></strong>
    <p><?php esc_html_e( 'How much time the banner should disappear when the timer ends','mw-countdown-banner' ) ?></p>
    <?php
}

function mwcb_exclude_field_cb () {
	// get the value of the setting we've registered with register_setting()
    $setting = get_option('mwcb_settings');
    // output the field
    ?>	
    	<label for="mwcb-d-checkout">
			<?php esc_html_e( 'Checkout page', 'mw-countdown-banner' ) ?>
			<input id="mwcb-d-checkout" type="checkbox">
		</label>
		<label for="mwcb-d-cart">
			<?php esc_html_e( 'Cart page', 'mw-countdown-banner' ) ?>
			<input id="mwcb-d-cart" type="checkbox">
		</label>
		<label for="mwcb-d-pages">
			<?php esc_html_e( 'Pages', 'mw-countdown-banner' ) ?>
			<input id="mwcb-d-pages" type="checkbox">
		</label>
		<label for="mwcb-d-posts">
			<?php esc_html_e( 'Posts', 'mw-countdown-banner' ) ?>
			<input id="mwcb-d-posts" type="checkbox">
		</label>
    <?php
}