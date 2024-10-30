<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:52 PM
 */

if (!function_exists('latmmo_create_postype_amazon_product')) {
    function latmmo_create_postype_amazon_product() {
        $args		= array(
            'labels'			=> array(
                'name' 			=> esc_html__('Amazon Product', 'latmmo-aff-amazon'),
                'singular_name' => esc_html__('Amazon Product', 'latmmo-aff-amazon'),
                'add_new_item'	=> esc_html__('Add Product', 'latmmo-aff-amazon'),
                'add_new'		=> esc_html__('Add Product', 'latmmo-aff-amazon'),
            ),
            'public' 				=> true,
            'has_archive' 			=> false,
            'publicly_queryable'  	=> true,
            'exclude_from_search'	=> false,
            'supports'				=> array('title', 'editor', 'thumbnail'),
            'show_in_nav_menus'     => false,
            'show_in_menu'          => 'latmmo',
            'rewrite'				=> array(
                'slug' 			=> 'amazon-product',
                'with_front'    => true,
                'feeds'         => true,
                'pages'			=> true,
            ),
        );

        register_post_type('latmmo-product', $args);
    }

    add_action('init', 'latmmo_create_postype_amazon_product');
}

if (!function_exists('latmmo_create_postype_table_compare')) {
    function latmmo_create_postype_table_compare() {
        $args		= array(
            'labels'			=> array(
                'name' 			=> esc_html__('Table Compare', 'latmmo-aff-amazon'),
                'singular_name' => esc_html__('Table Compare', 'latmmo-aff-amazon'),
                'add_new_item'	=> esc_html__('Add Table', 'latmmo-aff-amazon'),
                'add_new'		=> esc_html__('Add Table', 'latmmo-aff-amazon'),
            ),
            'public' 				=> true,
            'has_archive' 			=> false,
            'publicly_queryable'  	=> true,
            'exclude_from_search'	=> false,
            'supports'				=> array('title'),
            'show_in_nav_menus'     => false,
            'show_in_menu'          => 'latmmo',
            'rewrite'				=> array(
                'slug' 			=> 'table-compare',
                'with_front'    => true,
                'feeds'         => true,
                'pages'			=> true,
            ),
        );

        register_post_type('latmmo-table-compare', $args);
    }

    add_action('init', 'latmmo_create_postype_table_compare');
}