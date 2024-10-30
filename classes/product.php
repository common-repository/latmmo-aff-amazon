<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('Latmmo_Amazon_Product')) {
    class Latmmo_Amazon_Product {
        function get_product_by_asin($asin) {
            $args = [
                'post_type'         => 'latmmo-product',
                'meta_key'          => '_asin',
                'meta_value'        => $asin,
                'posts_per_page'    => 1
            ];

            $asin_query = get_posts($args);

            if (!empty($asin_query)) {
                $product = reset($asin_query);
                return $product->ID;
            } else {
                return false;
            }
        }

        function import_product_by_asin($asin) {
            $check_asin = $this->get_product_by_asin($asin);

            if (!$check_asin) {
                $amazon_api = new Latmmo_Amazon_Get_Product_Api();
                $product    = $amazon_api->search_items($asin, ['item_limits' => 1]);

                if (!empty($product)) {
                    if (latmmo_get_value_in_array($product, 'error_code') == -1) {
                        return;
                    }

                    $product = $product[0];
                    $product_id = $this->import_amazon_product($product);

                    return $product_id;
                } else {
                    return false;
                }
            } else {
                return $check_asin;
            }
        }

        function import_amazon_product($product) {
            $asin           = latmmo_get_value_in_array($product, 'asin');
            $price          = latmmo_get_value_in_array($product, 'price');
            $url            = latmmo_get_value_in_array($product, 'url');
            $image          = latmmo_get_value_in_array($product, 'image');
            $brand          = latmmo_get_value_in_array($product, 'brand');
            $featured       = latmmo_get_value_in_array($product, 'featured');
            $featured       = is_array($featured) ? implode('%ocs%', $featured) : $featured;
            $review_count   = latmmo_get_value_in_array($product, 'review_count');
            $rating         = latmmo_get_value_in_array($product, 'rating');
            $rating         = ($rating) ? (float) $rating : 0;
            $desc           = latmmo_get_value_in_array($product, 'desc');
            $merchant_name  = latmmo_get_value_in_array($product, 'merchant_name');
            $merchant_id    = latmmo_get_value_in_array($product, 'merchant_id');
            $stock          = latmmo_get_value_in_array($product, 'stock');
            $gallery        = latmmo_get_value_in_array($product, 'gallery');
            $is_prime       = latmmo_get_value_in_array($product, 'is_prime');

            if ($this->get_product_by_asin($asin)) {
                $product_id = $this->get_product_by_asin($asin);

                update_post_meta($product_id, '_price', $price);

                $price_history = get_post_meta($product_id, '_price_history', true);
                $price_history[] = [
                    'date'  => date_i18n('m/d/Y'),
                    'price' => $price
                ];

                update_post_meta($product_id, '_price_history', $price_history);
            } else {
                $new_product	= array(
                    'post_title'		=> latmmo_get_value_in_array($product, 'title'),
                    'post_type'			=> 'latmmo-product',
                    'post_status'		=> 'publish',
                    'post_content'		=> $featured,
                    'guid'              => 'latmmo_uid_' . uniqid(),
                );

                $product_id = wp_insert_post($new_product);

                if ($image && $image != '' && filter_var($image, FILTER_VALIDATE_URL)) {
                    //$media_id = Ocanus_Media::add_image_to_media_gallery($asin, $image);

                    //set_post_thumbnail($product_id, $media_id);
                }

                update_post_meta($product_id, '_asin', $asin);
                update_post_meta($product_id, '_url', $url);

                $price_history = [];
                $price_history[] = [
                    'date'  => date_i18n('m/d/Y'),
                    'price' => $price
                ];

                update_post_meta($product_id, '_price_history', $price_history);
            }

            update_post_meta($product_id, '_price', $price);
            update_post_meta($product_id, '_brand', $brand);
            update_post_meta($product_id, '_featured', $featured);
            update_post_meta($product_id, '_review_count', $review_count);
            update_post_meta($product_id, '_rating', $rating);
            update_post_meta($product_id, '_system_rating', (float)($rating*2));
            update_post_meta($product_id, '_amazon_img', $image);
            update_post_meta($product_id, '_merchant_name', $merchant_name);
            update_post_meta($product_id, '_merchant_id', $merchant_id);
            update_post_meta($product_id, '_stock', $stock);
            update_post_meta($product_id, 'is_prime', $is_prime);

            if (!empty($gallery)) {
                $gallery_data = [];

                foreach ($gallery as $url) {
                    $gallery_data[]['url'] = $url;
                }

                update_post_meta($product_id, '_gallery', $gallery_data);
            }

            return $product_id;
        }
    }
}