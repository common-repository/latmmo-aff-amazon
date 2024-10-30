<?php

defined('ABSPATH') or die;

if (!function_exists('latmmo_amazon_shortcode_product_history')) {
    function latmmo_amazon_shortcode_product_history($atts, $content = '', $key = '') {
        extract(shortcode_atts(array(
            'product_id'    => '',
            'asin'          => '',
            'class'         => '',

        ), $atts));

        /**
         * Code now
         */
        wp_enqueue_script('chartjs');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('latmmo-shortcode');

        $html = [];

        if ($asin) {
            $product    = new Latmmo_Amazon_Product();
            $product_id = $product->import_product_by_asin($asin);

            $arpg['meta_key']   = '_asin';
            $arpg['meta_value'] = $asin;
        } else {
            if ($product_id != '') {
                $arpg['p'] = $product_id;
            }
        }

        $arpg = array(
            'post_type' => 'latmmo-product',
            'p'         => $product_id
        );

        $product_history_query = new WP_Query($arpg);

        $html[] = '<div class="latmmo-shortcode os-product-history"><div class="latmmo-s-inner">';

        $html[] = '<div class="item-products">';

        if ($product_history_query->have_posts()) {
            while ($product_history_query->have_posts()) {
                $product_history_query->the_post();

                global $post;

                $product_history = get_post_meta($post->ID, '_price_history', true);

                $html[] = '<div class="item-product">';
                $html[] = '<div class="item-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';

                if (!empty($product_history)) {
                    $html[] = '<div class="item-date">';
                    $html[] = '<span>' . esc_html__('From', 'latmmo-aff-amazon') . '</span><input type="text" name="from" class="item-price-filter item-date-from"/>';
                    $html[] = '<span>' . esc_html__('To', 'latmmo-aff-amazon') . '</span><input type="text" name="to" class="item-price-filter item-date-to"/>';
                    $html[] = '<input type="hidden" value="' . $post->ID . '" class="item-p"/>';
                    $html[] = '</div>';

                    $html[] = '<div class="item-history">';

                    $date_arr   = [];
                    $price_arr  = [];

                    foreach ($product_history as $history) {
                        $date_arr[]     = latmmo_get_value_in_array($history, 'date');

                        $price = filter_var(latmmo_get_value_in_array($history, 'price'), FILTER_SANITIZE_NUMBER_FLOAT);
                        $price = floatval($price / 100);

                        $price_arr[]    = $price;

                    }

                    $html[] = '<canvas id="latmmoChart' . $post->ID . '" width="400" height="300" class="latmmoChart" data-date="' . implode('%%', $date_arr) . '" data-price="'. implode('%%', $price_arr) . '"></canvas>';

                    $html[] = '</div>';
                }

                $html[] = '</div>';
            }
        }

        wp_reset_postdata();
        wp_reset_postdata();

        $html[] = '</div>';

        $html[] = '</div></div>';

        return implode('', $html);
    }

    add_shortcode('latmmo_product_history', 'latmmo_amazon_shortcode_product_history');
}
