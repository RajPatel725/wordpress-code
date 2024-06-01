<?php
/*
Plugin Name:Form Data
Plugin URI:
Description:A simple WordPress plugin. ky kam ma nthi aavtu.
Author:Raj Patel
Author URI:linkedin.com/in/raj-patel-725v
Version: 1.0
Text Domain: form-data 
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_activation_hook(__FILE__, 'form_data_activate');
register_deactivation_hook(__FILE__, 'form_data_deactivation');

function form_data_activate()
{

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'form_data';
    $sql = "CREATE TABLE `$table_name` (
    `id` int(11) NOT NULL,
    `name` varchar(500) DEFAULT NULL,
    `contact` varchar(500) DEFAULT NULL,
    `massage` varchar(500) DEFAULT NULL,
    PRIMARY KEY(id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function form_data_deactivation()
{

    global $wpdb;
    global $table_prefix;
    $table_name = $wpdb->prefix . 'form_data';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

}


add_action('admin_menu', 'form_data_menu');

function form_data_menu()
{

    add_menu_page('Form Data', 'Form Data', 5, __FILE__, 'form_data_list');
}

function form_data_list()
{

    include ('form_data_list.php');
}

include ('short_code.php');