<?php

/**
 * Plugin Name: Studio Core
 * Description: Plugin chứa post type lookbook, album, gallery, và booking.
 * Version: 1.0
 * Author: Nhím
 */
// Ngăn chặn truy cập trực tiếp
if (! defined('ABSPATH')) exit;

define('MY_STUDIO_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));
// Load post types
// require_once plugin_dir_path(__FILE__) . 'post-types/lookbook.php';
require_once plugin_dir_path(__FILE__) . 'post-types/album.php';

// Load hàm hỗ trợ
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';


// Require file chứa class widget
require_once plugin_dir_path(__FILE__) . 'widget/widget-demo.php';

// Đăng ký widget
function my_register_custom_widget()
{
    register_widget('My_Custom_Widget');
}
add_action('widgets_init', 'my_register_custom_widget');
