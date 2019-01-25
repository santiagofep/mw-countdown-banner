<?php
/*
	Plugin Name: Countdown Banner
	Description: Show coupons and hide the banner after especified time
	Version: 1.0
	Text Domain: mw-countdown-banner
	Domain Path: /languages
*/
if ( ! defined( 'WPINC' ) )  die; 

/**
 * Enqueue Admin Scripts
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 */
function mwcb_enqueue_admin_scripts( $hook ) {
 
    if( is_admin() ) { 

        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'mwcb_admin_js', plugins_url( '/assets/admin/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}
add_action( 'admin_enqueue_scripts', 'mwcb_enqueue_admin_scripts' );

/**
 * Enqueue Scripts
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
 */
function mwcb_enqueue_public_scripts( $hook ) {
    $data = get_option('mwcb_settings');
    if ($data[enabled] != true) {
       return;
    }
    if ($data[dposts] == true and is_single() ) {
        return;
    }
    if ($data[dpages] == true and is_page() ) {
        return;
    }
    if ($data[dcart] == true and is_cart() ) {
        return;
    }
    if ($data[dcheckout] == true and is_checkout() ) {
        return;
    }

 	wp_enqueue_script( 'mwcb_js', plugins_url( '/assets/dist/mwcb.js', __FILE__ ), array( 'jquery' ), '1.0.1', true );
 	
 	$data[days] = __('days','mw-countdown-banner');
 	$data[hours] = __('hours','mw-countdown-banner');
 	$data[min] = __('min','mw-countdown-banner');
 	$data[sec] = __('sec','mw-countdown-banner');
 	wp_localize_script( 'mwcb_js', 'mwcb', $data );
}
add_action( 'wp_enqueue_scripts', 'mwcb_enqueue_public_scripts' );

/**
 * Admin Menu
 */
require_once 'includes/admin/menu-page.php';


