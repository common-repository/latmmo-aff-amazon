<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

/**
 * Product amazon link
 */
if (!function_exists('latmmo_amazon_single_product_amazon_url')) {
    function latmmo_amazon_single_product_amazon_url($id) {
        $amazon_url     = get_post_meta($id, '_url', true);
        $amazon_url     = latmmo_amazon_link_make_money($amazon_url);

        return $amazon_url;
    }
}

/**
 * Product featured
 */
if (!function_exists('latmmo_amazon_single_product_featured')) {
    function latmmo_amazon_single_product_featured($id) {
        $featured   = get_post_meta($id, '_featured', true);
        $featured   = explode('%ocs%', $featured);

        return $featured;
    }
}

/**
 * Product Brand
 */
if (!function_exists('latmmo_amazon_single_product_brand')) {
    function latmmo_amazon_single_product_brand($id) {
        $brand  = get_post_meta($id, '_brand', true);

        return $brand;
    }
}

/**
 * Product Rating
 */
if (!function_exists('latmmo_amazon_single_product_system_rating')) {
    function latmmo_amazon_single_product_system_rating($id) {
        $rating  = get_post_meta($id, '_system_rating', true);

        return $rating;
    }
}

/**
 * Product Image
 */
if (!function_exists('latmmo_amazon_single_product_image')) {
    function latmmo_amazon_single_product_image($id) {
        $image  = get_post_meta($id, '_amazon_img', true);

        return $image;
    }
}

/**
 * Product Is Prime
 */
if (!function_exists('latmmo_amazon_single_product_is_prime')) {
    function latmmo_amazon_single_product_is_prime($id) {
        $prime  = get_post_meta($id, 'is_prime', true);

        return $prime;
    }
}

/**
 * Product Price
 */
if (!function_exists('latmmo_amazon_single_product_price')) {
    function latmmo_amazon_single_product_price($id) {
        $prime  = get_post_meta($id, '_price', true);

        return $prime;
    }
}

/**
 * Product Review Count
 */
if (!function_exists('latmmo_amazon_single_product_review_count')) {
    function latmmo_amazon_single_product_review_count($id) {
        $count  = get_post_meta($id, '_review_count', true);

        return $count;
    }
}