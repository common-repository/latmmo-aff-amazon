<?php

CSF::createSection(LATMMO_AMAZON_OPTIONS, [
    'title'     => esc_html__('General', 'latmmo-aff-amazon'),
    'icon'      => 'fa fa-amazon',
    'fields'    => [
        [
            'id'    => 'amazon_access_key',
            'type'  => 'text',
            'title' => esc_html__('Access Key', 'latmmo-aff-amazon'),
        ],

        [
            'id'    => 'amazon_secret_key',
            'type'  => 'text',
            'title' => esc_html__('Secret Key', 'latmmo-aff-amazon'),
        ],

        [
            'id'    => 'amazon_tag_id',
            'type'  => 'text',
            'title' => esc_html__('Tag ID', 'latmmo-aff-amazon'),
        ],

        [
            'id'        => 'amazon_search_locale',
            'type'      => 'select',
            'title'     => esc_html__('Locale', 'latmmo-aff-amazon'),
            'options'   => [
                'au'    => esc_html__('Australia', 'latmmo-aff-amazon'),
                'br'    => esc_html__('Brazil', 'latmmo-aff-amazon'),
                'ca'    => esc_html__('Canada', 'latmmo-aff-amazon'),
                'uk'    => esc_html__('United Kingdom', 'latmmo-aff-amazon'),
                'us'    => esc_html__('United States', 'latmmo-aff-amazon'),
            ],
            'default'   => 'us'
        ],

        [
            'id'        => 'amazon_search_index',
            'type'      => 'select',
            'title'     => esc_html__('Search Index Type', 'latmmo-aff-amazon'),
            'options'   => [
                'All'           => esc_html__('All', 'latmmo-aff-amazon'),
                'Keywords'      => esc_html__('Keywords', 'latmmo-aff-amazon'),
                'Actor'         => esc_html__('Actor', 'latmmo-aff-amazon'),
                'Artist'        => esc_html__('Artist', 'latmmo-aff-amazon'),
                'Author'        => esc_html__('Author', 'latmmo-aff-amazon'),
                'Brand'         => esc_html__('Brand', 'latmmo-aff-amazon'),
                'Title'         => esc_html__('Title', 'latmmo-aff-amazon'),
            ],
            'default'   => 'All',
        ],

        [
            'id'        => 'amazon_search_limit_item',
            'type'      => 'select',
            'title'     => esc_html__('Search Limit Items', 'latmmo-aff-amazon'),
            'options'   => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
            ],
            'default'   => '10',
        ],

        [
            'id'        => 'enable_make_money',
            'type'      => 'switcher',
            'title'     => esc_html__('Enable Make Money', 'latmmo-aff-amazon'),
        ],
    ]
]);