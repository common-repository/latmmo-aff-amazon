<?php

CSF::createMetabox(LATMMO_AMAZON_TABLE_COMPARE_OPTIONS, [
    'title' => esc_html__('Details', 'latmmo-aff-amazon'),
    'post_type' => 'latmmo-table-compare',
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

CSF::createSection(LATMMO_AMAZON_TABLE_COMPARE_OPTIONS, [
    'title'     => esc_html__('General', 'latmmo-aff-amazon'),
    'fields'    => [
        [
            'id'            => 'fields_visible_type',
            'type'          => 'button_set',
            'title'         => esc_html__('Fields Visible Display', 'latmmo-aff-amazon'),
            'options'       => [
                ''          => esc_html__('Global', 'latmmo-aff-amazon'),
                'custom'    => esc_html__('Custom', 'latmmo-aff-amazon'),
            ],
            'default'       => ''
        ],

        [
            'id'            => 'fields_visible',
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
            ],
            'dependency'    => ['fields_visible_type', '==', 'custom']
        ],

        [
            'id'            => 'table_enable_redirect_single_product',
            'type'          => 'button_set',
            'title'         => esc_html__('Enable Redirect Single Product', 'latmmo-aff-amazon'),
            'options'       => [
                ''          => esc_html__('Global', 'latmmo-aff-amazon'),
                '1'         => esc_html__('True', 'latmmo-aff-amazon'),
                '2'         => esc_html__('False', 'latmmo-aff-amazon'),
            ],
            'default'       => ''
        ],

        [
            'id'            => 'table_text_view_on_amazon',
            'type'          => 'text',
            'title'         => esc_html__('Text View on Amazon', 'latmmo-aff-amazon'),
        ],

        [
            'id'            => 'table_text_score',
            'type'          => 'text',
            'title'         => esc_html__('Text Score', 'latmmo-aff-amazon'),
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
    ]
]);

CSF::createSection(LATMMO_AMAZON_TABLE_COMPARE_OPTIONS, [
    'title'     => esc_html__('Table Before', 'latmmo-aff-amazon'),
    'fields'    => [
        [
            'id'            => 'table_before',
            'type'          => 'wp_editor',
        ],
    ]
]);

CSF::createSection(LATMMO_AMAZON_TABLE_COMPARE_OPTIONS, [
    'title'     => esc_html__('Table After', 'latmmo-aff-amazon'),
    'fields'    => [
        [
            'id'            => 'table_after',
            'type'          => 'wp_editor',
        ],
    ]
]);

CSF::createMetabox(LATMMO_AMAZON_TABLE_COMPARE_PRODUCT_LIST_OPTIONS, [
    'title' => esc_html__('Product List', 'latmmo-aff-amazon'),
    'post_type' => 'latmmo-table-compare',
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

$product_fields = [
    [
        'id'    => 'product',
        'type'  => 'select',
        'title' => esc_html__('Product', 'latmmo-aff-amazon'),
        'options'		=> 'posts',
        'query_args'	=> [
            'post_type' => 'latmmo-product',
            'posts_per_page'    => '-1'
        ],
        'chosen'    => true,
        'class'     => 'select-product-db',
    ],

    [
        'id'    => 'image',
        'type'  => 'text',
        'title' => esc_html__('Image'),
        'class' => 'product-image',
        'after' => '<img class="ic" />'
    ],

    [
        'id'    => 'asin',
        'type'  => 'text',
        'title' => esc_html__('Asin', 'latmmo-aff-amazon'),
        'class' => 'product-asin',
        'subtitle'  => '<a target="_blank">' . esc_html__('View Product', 'latmmo-aff-amazon') . '</a>'
    ],

    [
        'id'    => 'score',
        'type'  => 'text',
        'title' => esc_html__('Score', 'latmmo-aff-amazon'),
        'class' => 'product-score'
    ],

    [
        'id'    => 'price',
        'type'  => 'text',
        'title' => esc_html__('Price', 'latmmo-aff-amazon'),
        'class' => 'product-price'
    ],

    [
        'id'    => 'review_count',
        'type'  => 'text',
        'title' => esc_html__('Review Count', 'latmmo-aff-amazon'),
        'class' => 'product-review-count'
    ],

    [
        'id'    => 'badge',
        'type'  => 'select',
        'title' => esc_html__('Badge', 'latmmo-aff-amazon'),
        'options' => [
            ''  => latmmo_get_option('table_text_badge_no', esc_html__('No Badge', 'latmmo-aff-amazon')),
            '1' => latmmo_get_option('table_text_badge_best_feature', esc_html__('Best Feature', 'latmmo-aff-amazon')),
            '2' => latmmo_get_option('table_text_badge_best_overall', esc_html__('Best Overall', 'latmmo-aff-amazon')),
            '3' => latmmo_get_option('table_text_badge_best_performance', esc_html__('Best Performance', 'latmmo-aff-amazon')),
            '4' => latmmo_get_option('table_text_badge_best_budget', esc_html__('Best Budget', 'latmmo-aff-amazon')),
        ]
    ],

    [
        'id'    => 'custom_badge',
        'type'  => 'text',
        'title' => esc_html__('Custom Badge', 'latmmo-aff-amazon'),
        'attributes' => [
            'placeholder'   => esc_html__('Custom Badge', 'latmmo-aff-amazon')
        ],
    ],

    [
        'id'    => 'custom_title',
        'type'  => 'text',
        'title' => esc_html__('Custom Title', 'latmmo-aff-amazon'),
    ],
];

$product_fields = apply_filters('latmmo_amazon_table_product_options', $product_fields);

CSF::createSection(LATMMO_AMAZON_TABLE_COMPARE_PRODUCT_LIST_OPTIONS, [
    'fields' => [
        [
            'id'                        => '_product_list',
            'type'                      => 'group',
            'accordion_title_auto'      => true,
            'accordion_title_number'    => true,
            'class'                     => 'latmmo-product-list',
            'fields'                    => $product_fields,
        ]
    ]
]);

if (isset($_GET['post'])) {
    CSF::createMetabox(LATMMO_AMAZON_TABLE_COMPARE_SHORTCODE_OPTIONS, [
        'title' => esc_html__('Shortcode', 'latmmo-aff-amazon'),
        'post_type' => 'latmmo-table-compare',
        'data_type' => 'unserialize',
        'priority' => 'low',
        'context' => 'side',
    ]);

    CSF::createSection(LATMMO_AMAZON_TABLE_COMPARE_SHORTCODE_OPTIONS, [
        'fields' => [
            [
                'id'        => 'shortcode',
                'type'      => 'text',
                'default'   => '[latmmo_table_compare id="' . sanitize_text_field($_GET['post']) . '"]',
                'attributes'    => [
                    'readonly'  => 'readonly'
                ]

            ],
        ]
    ]);
}