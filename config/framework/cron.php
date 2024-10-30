<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(LATMMO_AMAZON_OPTIONS, [
    'title'		=> esc_html__('Cronjob', 'latmmo-aff-amazon'),
    'icon'		=> 'fa fa-code',
    'fields'	=> [
        [
            'type'      => 'heading',
            'content'   => esc_html__('How to setup cronjob', 'latmmo-aff-amazon')
        ],

        [
            'type'      => 'notice',
            'style'     => 'success',
            'content'   => esc_html__('Step 1: Install plugin WP Crontrol', 'latmmo-aff-amazon')
        ],

        [
            'type'      => 'notice',
            'style'     => 'success',
            'content'   => __('Step 2: Create new cron events with name <strong>latmmo_cron_amazon_product</strong>', 'latmmo-aff-amazon')
        ],

        [
            'type'      => 'notice',
            'style'     => 'success',
            'content'   => esc_html__('Step 3: Chosen schedule for this event', 'latmmo-aff-amazon')
        ],
    ]
]);