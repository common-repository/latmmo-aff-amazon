<?php

CSF::createSection(LATMMO_AMAZON_SHORTCODE, [
    'title'     => esc_html__('Single Product', 'latmmo-aff-amazon'),
    'view'      => 'normal',
    'shortcode' => 'amazon_single_product',
    'fields'    => [
        [
            'id'            => 'asin',
            'type'          => 'text',
            'title'         => esc_html__('Asin Code', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'product_id',
            'type'          => 'select',
            'title'         => esc_html__('Select Product', 'latmmo-aff-amazon'),
            'options'		=> 'posts',
            'chosen'        => true,
            'ajax'          => true,
            'query_args'	=> [
                'post_type' => 'oca-product',
            ],
            'dependency'    => ['asin', '==', '']
        ],

        [
            'id'            => 'btn_text',
            'type'          => 'text',
            'title'         => esc_html__('Button Text', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Buy From Amazon', 'latmmo-aff-amazon')
        ],

        [
            'id'            => 'note',
            'type'          => 'text',
            'title'         => esc_html__('Note', 'latmmo-aff-amazon'),
            'default'       => esc_html__('Image Credit: Amazon')
        ]
    ]
]);