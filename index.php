<?php

/*
Plugin Name: Quick Price Edit For WooCommerce
Description: A plugin to update the price of products quickly.
Version: 1.0
Author: Spencer Pierson
*/

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    die ('You need WooCommerce for this plugin to work.');
}

include('create-admin-page.php');


$quick_edit_page = new CreateAdminPage();



?>