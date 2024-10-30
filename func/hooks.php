<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:45 PM
 */

if (!function_exists('latmmo_amazon_cron_products')) {
    function latmmo_amazon_cron_products() {
        $arpg = array(
            'post_type'         => 'latmmo-product',
            'posts_per_page'    => -1
        );

        $product_list = new WP_Query($arpg);

        if ($product_list->have_posts()) {
            while ($product_list->have_posts()) {
                $product_list->the_post();

                global $post;

                $asin           = get_post_meta($post->ID, '_asin', true);
                $price_history  = get_post_meta($post->ID, '_price_history', true);

                $amazon_api     = new Latmmo_Amazon_Get_Product_Api();
                $product        = $amazon_api->search_items($asin, ['item_limits' => 1]);

                if (!empty($product)) {
                    if (latmmo_get_value_in_array($product, 'error_code') == -1) {
                        return;
                    }

                    $product        = $product[0];
                    $price          = latmmo_get_value_in_array($product, 'price');
                    $review_count   = latmmo_get_value_in_array($product, 'review_count');
                    $rating         = latmmo_get_value_in_array($product, 'rating');
                    $stock          = latmmo_get_value_in_array($product, 'stock');

                    $price_history[] = [
                        'date'  => date_i18n('m/d/Y'),
                        'price' => $price
                    ];

                    update_post_meta($post->ID, '_price_history', $price_history);
                    update_post_meta($post->ID, '_stock', $stock);
                    update_post_meta($post->ID, '_price', $price);
                    update_post_meta($post->ID, '_review_count', $review_count);
                    update_post_meta($post->ID, '_rating', $rating);
                    update_post_meta($post->ID, '_system_rating', (float)($rating*2));
                }
            }
        }

        wp_reset_query();
        wp_reset_postdata();
    }

    add_action('latmmo_cron_amazon_product', 'latmmo_amazon_cron_products');
}