<?php
/*
 * Plugin Name: Zahok
 * Plugin URI: https://zahok.com
 * Description: This plugin connects your platform with zahok.com, bringing you its most valuable features right to your fingertips. Additionally, it offers exclusive extra functionalities designed to enhance and optimize your eCommerce operations. Unlock the power of advanced customer insights, fraud prevention tools, and business-enhancing features to take your online store to the next level.
 * Version: 1.0
 * Author: A One Devs ( Md Rukon Shekh )
 * Author URI: https://aonedevs.com
 * Text Domain: zahok
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
require_once plugin_dir_path(__FILE__) . 'options/admin-options.php';
require_once plugin_dir_path(__FILE__) . 'inc/wc/order-ui.php';
require_once plugin_dir_path(__FILE__) . 'inc/wc/wc-actions.php';
define('ZAHOK_URL','http://127.0.0.1:8000');
function zahok_init() {
	
} 
add_action( 'init', 'zahok_init' );
add_action('admin_menu', function(){
    add_menu_page(
        'Zahok Settings',       // Page title
        'Zahok',                // Menu title
        'manage_options',           // Capability required
        'zahok-settings',                // Menu slug
        'zahok_options_form',     // Callback function
        'dashicons-admin-generic',  // Menu icon
        20                          // Position
    );
});

add_action('admin_init', 'zahok_admin_init');

function zahok_admin_init() {
    /*
    register_setting(
        'zahok_settings_group',
        'zahok_api_key'
    );
    */
    
}

function zahok_enqueue_script($hook) {
    // Load the script only on specific admin pages if needed
    /*
    if ('zahok' !== $hook) {
        return;
    }
    */
    wp_enqueue_style('magnific-popup_style',plugin_dir_url( __FILE__ ) . 'assets/js/magnific/magnific-popup.css');
    wp_enqueue_style('zahok_main_style',plugin_dir_url( __FILE__ ) . 'assets/css/main.css');
    wp_enqueue_script('magnific-popup',plugin_dir_url( __FILE__ ) . 'assets/js/magnific/jquery.magnific-popup.min.js',['jquery'],null,true);
    wp_register_script('zahok_main', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery','magnific-popup'), '1.0',true);
    wp_localize_script(
        'zahok_main',
        'zahok',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            //'nonce'    => wp_create_nonce('my_custom_nonce'),
        ]
    );
    
    wp_enqueue_script('zahok_main');
}
add_action('admin_enqueue_scripts', 'zahok_enqueue_script');