<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(LATMMO_AMAZON_OPTIONS, [
    'title'		=> esc_html__('Addons', 'latmmo-aff-amazon'),
    'icon'		=> 'fa fa-puzzle-piece',
    'fields'	=> [
        [
            'type'      => 'addons',
            'addons'    => [
                [
                    'title'         => esc_html__('Auto Import', 'latmmo-aff-amazon'),
                    'thumbnail'     => '',
                    'id'            => 'auto_import',
                    'desc'          => esc_html__('Plugin allow auto import product from amazon', 'latmmo-aff-amazon'),
                    'detail_url'    => '#',
                    'buy_now_url'   => '#',
                    'class'         => 'Latmmo_Amazon_Auto_Import'
                ],

                [
                    'title'         => esc_html__('Templates', 'latmmo-aff-amazon'),
                    'thumbnail'     => '',
                    'id'            => 'templates',
                    'desc'          => esc_html__('Plugin have more layout and design', 'latmmo-aff-amazon'),
                    'detail_url'    => '#',
                    'buy_now_url'   => '#',
                    'class'         => 'Latmmo_Amazon_Templates_Pro'
                ]
            ]
        ],
    ]
]);