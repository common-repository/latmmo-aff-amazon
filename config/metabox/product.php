<?php

CSF::createMetabox(LATMMO_AMAZON_PRODUCT_OPTIONS, [
    'title' => esc_html__('Details', 'latmmo-aff-amazon'),
    'post_type' => 'latmmo-product',
    'data_type' => 'unserialize',
    'priority' => 'high',
    'context' => 'normal',
]);


CSF::createSection(LATMMO_AMAZON_PRODUCT_OPTIONS, [
    'fields' => [
        [
            'id'        => '_amazon_img',
            'type'      => 'text',
            'title'     => esc_html__('Featured Image', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_asin',
            'type'      => 'text',
            'title'     => esc_html__('ASIN', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_url',
            'type'      => 'text',
            'title'     => esc_html__('Url', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_price',
            'type'      => 'text',
            'title'     => esc_html__('Price', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_stock',
            'type'      => 'text',
            'title'     => esc_html__('Stock', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_brand',
            'type'      => 'text',
            'title'     => esc_html__('Brand', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_merchant_name',
            'type'      => 'text',
            'title'     => esc_html__('Merchant Name', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_merchant_id',
            'type'      => 'text',
            'title'     => esc_html__('Merchant ID', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_review_count',
            'type'      => 'text',
            'title'     => esc_html__('Review Count', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_rating',
            'type'      => 'text',
            'title'     => esc_html__('Rating', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_system_rating',
            'type'      => 'text',
            'title'     => esc_html__('System Rating', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => '_featured',
            'type'      => 'textarea',
            'title'     => esc_html__('Featured', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => 'is_prime',
            'type'      => 'switcher',
            'title'     => esc_html__('Is Prime', 'latmmo-aff-amazon')
        ],

        [
            'id'        => '_gallery',
            'type'      => 'group',
            'title'     => esc_html__('Gallery', 'latmmo-aff-amazon'),
            'fields'    => [
                [
                    'id'    => 'url',
                    'type'  => 'text',
                    'title' => esc_html__('Url', 'latmmo-aff-amazon')
                ]
            ]
        ],

        [
            'id'        => '_price_history',
            'type'      => 'group',
            'title'     => esc_html__('Price History', 'latmmo-aff-amazon'),
            'fields'    => [
                [
                    'id'    => 'date',
                    'type'  => 'date',
                    'title' => esc_html__('Date', 'latmmo-aff-amazon')
                ],

                [
                    'id'    => 'price',
                    'type'  => 'text',
                    'title' => esc_html__('Price', 'latmmo-aff-amazon')
                ],
            ]
        ],
    ]
]);