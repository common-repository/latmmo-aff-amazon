<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:42 PM
 */

CSF::createOptions(LATMMO_AMAZON_OPTIONS, [
	'framework_title' => esc_html__('LATMMO Settings', 'latmmo-aff-amazon'),
	'menu_title'      => esc_html__('LATMMO Settings', 'latmmo-aff-amazon'),
	'menu_slug'       => 'latmmo-settings',
    'show_form_warning' => false,
    'menu_icon'         => 'dashicons-clipboard'
]);

require_once 'framework/general.php';
require_once 'framework/table.php';
require_once 'framework/cron.php';
require_once 'framework/addon.php';