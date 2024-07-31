<?php
/*
Plugin Name: Custom Widget Plugin
Description: A custom plugin to create a setting and widget page.
Version: 1.0
Author: Raj Vadariya
*/

if (!defined('ABSPATH')) {
    exit;
}

// Include the main plugin class
require_once plugin_dir_path(__FILE__) . 'includes/class-custom-widget-plugin.php';
require_once plugin_dir_path(__FILE__) . 'class-custom-widget.php';


// Initialize the plugin
function run_custom_widget_plugin() {
    $plugin = new Custom_Widget_Plugin();
    $plugin->run();
}
run_custom_widget_plugin();

add_action('admin_enqueue_scripts', 'custom_plugin_enqueue_color_picker');
function custom_plugin_enqueue_color_picker($hook_suffix) {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_media();
    wp_enqueue_script('custom_plugin_color_picker', plugins_url('/custom-plugin.js', __FILE__), array('wp-color-picker', 'jquery'), false, true);
}
