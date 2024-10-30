<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(LATMMO_AMAZON_OPTIONS, [
    'title'		=> esc_html__('Table Compare', 'latmmo-aff-amazon'),
    'icon'		=> 'fa fa-table',
    'fields'	=> [
        [
            'id'            => 'table_fields_visible',
            'type'          => 'sorter',
            'title'         => esc_html__('Fields Visible', 'latmmo-aff-amazon'),
            'default'       => [
                'enabled'   => [
                    'title'     => esc_html__('Title', 'latmmo-aff-amazon'),
                    'image'     => esc_html__('Image', 'latmmo-aff-amazon'),
                    'price'     => esc_html__('Price', 'latmmo-aff-amazon'),
                    'asin'      => esc_html__('Asin', 'latmmo-aff-amazon'),
                    'score'     => esc_html__('Score', 'latmmo-aff-amazon'),
                    'rc'        => esc_html__('Review Count', 'latmmo-aff-amazon'),
                ],
                'disabled'  => []
            ]
        ],
        [
            'id'            => 'table_enable_redirect_single_product',
            'type'          => 'switcher',
            'title'         => esc_html__('Enable Redirect Single Product', 'latmmo-aff-amazon'),
        ],
        [
            'id'            => 'table_text_view_on_amazon',
            'type'          => 'text',
            'title'         => esc_html__('Text View on Amazon', 'latmmo-aff-amazon'),
            'default'       => esc_html__('View on Amazon', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'table_text_score',
            'type'          => 'text',
            'title'         => esc_html__('Text Score', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Score', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_rating_note',
            'type'          => 'textarea',
            'title'         => esc_html__('Score Note', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'table_end_note',
            'type'          => 'textarea',
            'title'         => esc_html__('Table End Note', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'price_text_desc',
            'type'          => 'text',
            'title'         => esc_html__('Price Text Description', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'price_text_note',
            'type'          => 'textarea',
            'title'         => esc_html__('Price Text Note', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'table_text_badge_no',
            'type'          => 'text',
            'title'         => esc_html__('Text No Badge', 'latmmo-aff-amazon'),
            'default'       => esc_html__('No Badge', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_text_badge_best_feature',
            'type'          => 'text',
            'title'         => esc_html__('Text Badge Best Feature', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Best Feature', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_text_badge_best_overall',
            'type'          => 'text',
            'title'         => esc_html__('Text Badge Best Overall', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Best Overall', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_text_badge_best_performance',
            'type'          => 'text',
            'title'         => esc_html__('Text Badge Best Performance', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Best Performance', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_text_badge_best_budget',
            'type'          => 'text',
            'title'         => esc_html__('Text Badge Best Budget', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Best Budget', 'latmmo-aff-amazon'),
        ],
    ]
]);