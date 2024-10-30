<?php
CSF::createSection(LATMMO_AMAZON_SHORTCODE, [
    'title'     => esc_html__('Product History', 'latmmo-aff-amazon'),
    'view'      => 'normal',
    'shortcode' => 'latmmo_product_history',
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
            'id'            => 'custom_class',
            'type'          => 'text',
            'title'         => esc_html__('Custom Class', 'latmmo-aff-amazon')
        ]
    ]
]);