<?php

CSF::createSection(LATMMO_AMAZON_SHORTCODE, [
    'title'     => esc_html__('Product Link', 'latmmo-aff-amazon'),
    'view'      => 'normal',
    'shortcode' => 'latmmo_product_link',
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
    ]
]);