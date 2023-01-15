<?php

/*
Plugin Name: Quick Price Edit For WooCommerce
Plugin URI: https://github.com/spjpierson/quick-edit-for-woocommerce
Description: A plugin to update the price of products quickly in one page under product tag you be able to update all your product price without having to go to all prices.
Version: 1.0
Requires at least: 5.2
Requires PHP:      7.2
Author: Spencer Pierson
Author URI:        https://www.linkedin.com/in/spencer-pierson-261a22a0/
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Update URI:        https://example.com/my-plugin/
Text Domain:       quick-edit-for-woocommerce
Domain Path:       /languages

*/


// Check if the WooCommerce plugin is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    // Include necessary files
    include('create-admin-page.php');
    $admin_page = new CreateAdminPage();

} else {
    // Die if WooCommerce is not active
    die ('You need WooCommerce for this plugin to work.');
} 

?>