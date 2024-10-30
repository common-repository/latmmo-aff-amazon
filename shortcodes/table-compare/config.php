<?php

CSF::createSection(LATMMO_AMAZON_SHORTCODE, [
    'title'     => esc_html__('Table Compare', 'latmmo-aff-amazon'),
    'view'      => 'normal',
    'shortcode' => 'latmmo_table_compare',
    'fields'    => [
        [
            'id'            => 'id',
            'type'          => 'select',
            'title'         => esc_html__('Select Table', 'latmmo-aff-amazon'),
            'options'		=> 'posts',
            'chosen'        => true,
            'ajax'          => true,
            'query_args'	=> [
                'post_type' => 'latmmo-table-compare',
            ],
        ],
    ]
]);