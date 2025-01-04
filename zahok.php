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