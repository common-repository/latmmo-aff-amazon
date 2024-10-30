<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

/**
 * Product badge
 */
if (!function_exists('latmmo_amazon_table_compare_product_badge_text')) {
    function latmmo_amazon_table_compare_product_badge_text($badge, $custom_badge) {
        switch ($badge) {
            case '1':
                $badge_final = latmmo_get_option('table_text_badge_best_feature', esc_html__('Best Feature', 'latmmo-aff-amazon'));
                break;

            case '2':
                $badge_final = latmmo_get_option('table_text_badge_best_overall', esc_html__('Best Overall', 'latmmo-aff-amazon'));
                break;

            case '3':
                $badge_final = latmmo_get_option('table_text_badge_best_performance', esc_html__('Best Performance', 'latmmo-aff-amazon'));
                break;

            case '4':
                $badge_final = latmmo_get_option('table_text_badge_best_budget', esc_html__('Best Budget', 'latmmo-aff-amazon'));
                break;

            default:
                $badge_final = $custom_badge;
                break;
        }

        return $badge_final;
    }
}

/**
 * Query Product List
 */
if (!function_exists('latmmo_amazon_table_query_product_list')) {
    function latmmo_amazon_table_query_product_list($id) {
        $product_list   = get_post_meta($id, '_product_list', true);
        $product_id_arr = [];

        if (!empty($product_list)) {
            foreach ($product_list as $product) {
                $product_id_arr[] = latmmo_get_value_in_array($product, 'product');
            }
        }

        $args = [
            'post_type'         => 'latmmo-product',
            'post__in'          => $product_id_arr,
            'orderby'           => 'post__in',
            'posts_per_page'    => '-1'
        ];

        return $args;
    }
}

/**
 * Generate table content
 */
if (!function_exists('latmmo_amazon_table_generate_data_table_product_list')) {
    function latmmo_amazon_table_generate_data_table_product_list($id) {
        $product_list   = get_post_meta($id, '_product_list', true);
        $table_arr      = [];

        if (!empty($product_list)) {
            foreach ($product_list as $product) {
                $title_in_table = latmmo_get_value_in_array($product, 'custom_title');
                $score          = latmmo_get_value_in_array($product, 'score');
                $badge          = latmmo_get_value_in_array($product, 'badge');
                $custom_badge   = latmmo_get_value_in_array($product, 'custom_badge');
                $price          = latmmo_get_value_in_array($product, 'price');
                $badge_final    = latmmo_amazon_table_compare_product_badge_text($badge, $custom_badge);

                $table_arr[latmmo_get_value_in_array($product, 'product')] = [
                    'title'         => $title_in_table,
                    'score'         => $score,
                    'badge'         => $badge_final,
                    'price'         => $price,
                    'badge_base'    => $badge,
                ];
            }
        }

        return $table_arr;
    }
}

/**
 * Get fields visible
 */
if (!function_exists('latmmo_amazon_table_fields_visible')) {
    function latmmo_amazon_table_fields_visible($id) {
        $fields_visible_global  = latmmo_get_option('table_fields_visible');
        $fields_visible_global  = isset($fields_visible_global['enabled']) ? $fields_visible_global['enabled'] : [];

        $fields_visible_final = [];

        if (!empty($fields_visible_global)) {
            foreach ($fields_visible_global as $key => $value) {
                $fields_visible_final[] = $key;
            }
        }


        $fields_visible_type    = get_post_meta($id, 'fields_visible_type', true);
        $single_fields_visible  = get_post_meta($id, 'fields_visible', true);
        $single_fields_visible  = isset($single_fields_visible['enabled']) ? $single_fields_visible['enabled'] : [];

        $single_fields_visible_arr = [];

        if (!empty($single_fields_visible)) {
            foreach ($single_fields_visible as $key => $value) {
                $single_fields_visible_arr[] = $key;
            }
        }

        if ($fields_visible_type == 'custom') {
            $fields_visible_final = $single_fields_visible_arr;
        }

        return $fields_visible_final;
    }
}

/**
 * Check redirect url
 */
if (!function_exists('latmmo_amazon_table_redirect_single_product')) {
    function latmmo_amazon_table_redirect_single_product($table_id) {
        $global             = latmmo_get_option('table_enable_redirect_single_product');
        $single_redirect    = get_post_meta($table_id, 'table_enable_redirect_single_product', true);

        if ($single_redirect == '1') {
            $global = true;
        } else if ($single_redirect == '2') {
            $global = false;
        }

        return $global;
    }
}

/**
 * Generate product title in table
 */
if (!function_exists('latmmo_amazon_table_product_general_title')) {
    function latmmo_amazon_table_product_general_title($table_id, $product_id) {
        $fields_visible = latmmo_amazon_table_fields_visible($table_id);

        if (in_array('title', $fields_visible)) {
            return get_the_title($product_id);
        } else {
            return false;
        }
    }
}

/**
 * Generate product brand in table
 */
if (!function_exists('latmmo_amazon_table_product_general_brand')) {
    function latmmo_amazon_table_product_general_brand($table_id, $product_id) {
        return get_post_meta($product_id, '_brand', true);
    }
}

/**
 * Generate product featured in table
 */
if (!function_exists('latmmo_amazon_table_product_general_featured')) {
    function latmmo_amazon_table_product_general_featured($table_id, $product_id, $more = true) {
        $featured   = get_post_meta($product_id, '_featured', true);
        $featured   = explode('%ocs%', $featured);

        $html = [];

        if (!empty($featured)) {
            $html[] = '<ul>';

            foreach ($featured as $f) {
                $html[] = '<li>' . $f . '</li>';
            }

            $html[] = '</ul>';

            if ($more) {
                $html[] = '<div class="more">';
                $html[] = '<a href="' . esc_url(latmmo_amazon_table_product_general_url($table_id, $product_id)) . '" ' . esc_attr(latmmo_amazon_table_product_general_url_rel($table_id, $product_id)) . ' target="_blank">' . esc_html__('more', 'latmmo-aff-amazon') . '</a>';
                $html[] = '</a>';
                $html[] = '</div>';
            }
        }

        return implode('', $html);
    }
}

/**
 * Generate product score in table
 */
if (!function_exists('latmmo_amazon_table_product_general_score')) {
    function latmmo_amazon_table_product_general_score($table_id, $product_id, $custom_table) {
        $rating = latmmo_amazon_single_product_system_rating($product_id);
        $score  = isset(latmmo_get_value_in_array($custom_table, $product_id)['score']) ? latmmo_get_value_in_array($custom_table, $product_id)['score'] : $rating;

        $fields_visible = latmmo_amazon_table_fields_visible($table_id);

        if (in_array('score', $fields_visible)) {
            return $score;
        } else {
            return false;
        }
    }
}

/**
 * Generate product price in table
 */
if (!function_exists('latmmo_amazon_table_product_general_price')) {
    function latmmo_amazon_table_product_general_price($table_id, $product_id, $custom_table) {
        $price  = latmmo_amazon_single_product_price($product_id);
        $price  = isset(latmmo_get_value_in_array($custom_table, $product_id)['price']) ? latmmo_get_value_in_array($custom_table, $product_id)['price'] : $price;

        $fields_visible = latmmo_amazon_table_fields_visible($table_id);

        if (in_array('price', $fields_visible)) {
            return $price;
        } else {
            return false;
        }
    }
}

/**
 * Generate product badge in table
 */
if (!function_exists('latmmo_amazon_table_product_general_badge')) {
    function latmmo_amazon_table_product_general_badge($table_id, $product_id, $custom_table) {
        $badge = latmmo_get_value_in_array($custom_table, $product_id)['badge'] ? latmmo_get_value_in_array($custom_table, $product_id)['badge']  : '';

        return $badge;
    }
}

/**
 * Generate product image in table
 */
if (!function_exists('latmmo_amazon_table_product_general_image')) {
    function latmmo_amazon_table_product_general_image($table_id, $product_id) {
        $fields_visible = latmmo_amazon_table_fields_visible($table_id);

        if (in_array('image', $fields_visible)) {
            return get_post_meta($product_id, '_amazon_img', true);
        } else {
            return false;
        }
    }
}

/**
 * Generate product is prime in table
 */
if (!function_exists('latmmo_amazon_table_product_general_is_prime')) {
    function latmmo_amazon_table_product_general_is_prime($table_id, $product_id) {
        return get_post_meta($product_id, 'is_prime', true);
    }
}

/**
 * Generate product url in table
 */
if (!function_exists('latmmo_amazon_table_product_general_url')) {
    function latmmo_amazon_table_product_general_url($table_id, $product_id) {
        $amazon_url                 = latmmo_amazon_single_product_amazon_url($product_id);
        $enable_redirect_product    = latmmo_amazon_table_redirect_single_product($table_id);
        $product_url                = ($enable_redirect_product) ? get_the_permalink($product_id) : $amazon_url;

        return $product_url;
    }
}

/**
 * Generate product url rel in table
 */
if (!function_exists('latmmo_amazon_table_product_general_url_rel')) {
    function latmmo_amazon_table_product_general_url_rel($table_id, $product_id) {
        $amazon_url                 = latmmo_amazon_single_product_amazon_url($product_id);
        $enable_redirect_product    = latmmo_amazon_table_redirect_single_product($table_id);
        $product_url_rel            = ($enable_redirect_product) ? '' : 'rel="nofollow"';

        return $product_url_rel;
    }
}

/**
 * Generate text score in table
 */
if (!function_exists('latmmo_amazon_table_product_general_text_score')) {
    function latmmo_amazon_table_product_general_text_score($table_id) {
        $global = latmmo_get_option('table_text_score');
        $single = get_post_meta($table_id, 'table_text_score', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}

/**
 * Generate text score note in table
 */
if (!function_exists('latmmo_amazon_table_product_general_text_score_note')) {
    function latmmo_amazon_table_product_general_text_score_note($table_id) {
        $global = latmmo_get_option('table_rating_note');
        $single = get_post_meta($table_id, 'table_rating_note', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}

/**
 * Generate text score note in table
 */
if (!function_exists('latmmo_amazon_table_product_general_text_view_amazon')) {
    function latmmo_amazon_table_product_general_text_view_amazon($table_id) {
        $global = latmmo_get_option('table_text_view_on_amazon');
        $single = get_post_meta($table_id, 'table_text_view_on_amazon', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}

/**
 * Generate text score note in table
 */
if (!function_exists('latmmo_amazon_table_product_general_table_note_end')) {
    function latmmo_amazon_table_product_general_table_note_end($table_id) {
        $global = latmmo_get_option('table_end_note');
        $single = get_post_meta($table_id, 'table_end_note', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}

/**
 * Generate price text description in table
 */
if (!function_exists('latmmo_amazon_table_product_general_price_text_desc')) {
    function latmmo_amazon_table_product_general_price_text_desc($table_id) {
        $global = latmmo_get_option('price_text_desc');
        $single = get_post_meta($table_id, 'price_text_desc', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}

/**
 * Generate price text note in table
 */
if (!function_exists('latmmo_amazon_table_product_general_price_text_note')) {
    function latmmo_amazon_table_product_general_price_text_note($table_id) {
        $global = latmmo_get_option('price_text_note');
        $single = get_post_meta($table_id, 'price_text_note', true);
        $text   = ($single != '') ? $single : $global;

        return $text;
    }
}