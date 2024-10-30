<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('Latmmo_Amazon_Admin')) {
    class Latmmo_Amazon_Admin {
        public function __construct() {
            if (!is_admin()) {
                return;
            }

            add_action('admin_footer', array($this, 'enqueue_admin_scripts'), 20);
        }

        public function enqueue_admin_scripts() {
            wp_enqueue_style('latmmo-amazon-admin-style', LATMMO_AMAZON_DIR_URL . 'assets/css/admin/admin.css', array(), false);

//            wp_enqueue_script('latmmo-amazon-admin-script', LATMMO_AMAZON_DIR_URL . '/assets/js/admin.js', array('jquery'), false, true);
//            wp_localize_script('latmmo-amazon-admin-script', 'latmmo_script', array(
//                'ajax_url'		=> admin_url('admin-ajax.php'),
//            ));
        }
    }

    new Latmmo_Amazon_Admin();
}