<?php

defined('ABSPATH') or die;

if (!function_exists('amazon_single_product')) {
    function amazon_single_product($atts, $content = '', $key = '') {
        extract(shortcode_atts(array(
            'product_id'    => '',
            'asin'          => '',
            'btn_text'      => '',
            'note'          => '',

        ), $atts));

        /**
         * Code now
         */
        $html = [];


        $arpg = array(
            'post_type' => 'latmmo-product',
        );

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

        $product_single_query = new WP_Query($arpg);

        $html[] = '<div class="latmmo-shortcode os-single-product"><div class="latmmo-s-inner">';

        if ($product_single_query->have_posts()) {
            while ($product_single_query->have_posts()) {
                $product_single_query->the_post();

                global $post;

                $url    = get_post_meta($post->ID, '_url', true);
                $image  = get_post_meta($product_id, '_amazon_img', true);

                $html[] = '<div class="item-product">';
                $html[] = '<div class="item-image"><img src="' . esc_url($image) . '" /></div>';
                $html[] = '<div class="item-title">' . get_the_title() . '</div>';

                if ($btn_text) {
                    $html[] = '<a class="item-btn" href="' . latmmo_amazon_link_make_money($url) . '" target="_blank" rel="nofollow">' . esc_attr($btn_text) . '</a>';
                }

                if ($note) {
                    $html[] = '<div class="item-note">' . esc_attr($note) . '</div>';
                }

                $html[] = '</div>';
            }
        }

        wp_reset_postdata();
        wp_reset_postdata();

        $html[] = '</div></div>';

        return implode('', $html);
    }

    add_shortcode('amazon_single_product', 'amazon_single_product');
}
