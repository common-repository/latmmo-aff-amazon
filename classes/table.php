<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('Latmmo_Amazon_Table')) {
    class Latmmo_Amazon_Table {
        public function __construct() {
            add_action('admin_print_scripts-post.php', array($this, 'import_product_modal_content'), 99);
            add_action('admin_print_scripts-post-new.php', array($this, 'import_product_modal_content'), 99);
            add_action('admin_footer', array($this, 'enqueue_admin_scripts'), 20);

            add_action('wp_ajax_latmmo_product_search_ajax', array($this, 'product_search_ajax'));
            add_action('wp_ajax_nopriv_latmmo_product_search_ajax', array($this, 'product_search_ajax'));

            add_action('wp_ajax_latmmo_import_product_to_table_ajax', array($this, 'import_product_ajax'));
            add_action('wp_ajax_nopriv_latmmo_import_product_to_table_ajax', array($this, 'import_product_ajax'));

            add_action('wp_ajax_latmmo_table_update_info_when_change_product', array($this, 'ajax_get_product_info'));
            add_action('wp_ajax_nopriv_latmmo_table_update_info_when_change_product', array($this, 'ajax_get_product_info'));
        }

        public function enqueue_admin_scripts() {
            wp_enqueue_style('latmmo-amazon-table-style', LATMMO_AMAZON_DIR_URL . 'assets/css/admin/table.css', array(), false);

            wp_enqueue_script('latmmo-amazon-table-script', LATMMO_AMAZON_DIR_URL . '/assets/js/admin/table.js', array('jquery'), false, true);
            wp_localize_script('latmmo-amazon-table-script', 'latmmo_script', array(
                'ajax_url'		=> admin_url('admin-ajax.php'),
                'import_btn'    => esc_html__('Import Product', 'latmmo-aff-amazon'),
                'popup_name'    => esc_html__('Import Product From Amazon', 'latmmo-aff-amazon')
            ));
        }

        public function import_product_modal_content() {
            $screen = get_current_screen();

            global $post;

            if (isset($screen->post_type) && $screen->post_type == 'latmmo-table-compare') {
                add_thickbox();
                ?>
                <div id="latmmoModalImportProduct" style="display:none;">
                    <div class="latmmo-search-form">
                        <input type="text" class="input-search" placeholder="<?php echo esc_html__('Please enter asin or keyword', 'latmmo-aff-amazon'); ?>"/>
                        <button type="button" class="latmmo-btn-search button button-primary"><?php echo esc_html__('Search', 'latmmo-aff-amazon'); ?></button>
                    </div>
                    <p class="latmmo-intro"><?php echo esc_html__('Please check to product you want chosen', 'latmmo-aff-amazon'); ?></p>
                    <div class="latmmo-search-content"></div>
                </div>
                <?php
            }
        }

        public function product_search_ajax() {
            $s = sanitize_text_field($_POST['s']);

            $amazon_api = new Latmmo_Amazon_Get_Product_Api();
            $products   = $amazon_api->search_items($s);

            $html = [];

            if (!empty($products)) {
                $html[] = '<div class="item-products">';

                foreach ($products as $product) {
                    $html[] = '<div class="item-product">';
                    $html[] = '<input type="checkbox" class="item-check" />';
                    $html[] = '<div class="item-content">';
                    $html[] = '<div class="item-img"><img src="' . latmmo_get_value_in_array($product, 'image') . '" /></div>';
                    $html[] = '<div class="item-title">' . latmmo_get_value_in_array($product, 'title') . '</div>';
                    $html[] = '<div class="item-asin">' . latmmo_get_value_in_array($product, 'asin') . '</div>';
                    $html[] = '</div>';
                    $html[] = '<input type="hidden" class="item-val" value="' . base64_encode(json_encode($product)) . '" />';
                    $html[] = '</div>';
                }

                $html[] = '</div>';

                $html[] = '<div class="item-btn-sumbit"><button class="button button-secondary">' . esc_html__('Submit') . '</button></div>';
            }

            echo json_encode(implode('', $html));
            exit;
        }

        public function generate_field_product_template($data, $c) {
            $html = '';

            ob_start();
            ?>
            <div class="csf-cloneable-content" id="ui-id-<?php echo esc_attr($c); ?>">
                <div class="csf-field csf-field-select select-product-db">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Product', 'latmmo-aff-amazon'); ?></h4>
                    </div>
                    <div class="csf-fieldset">
                        <select name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][product]" class="csf-chosen" data-depend-id="product">
                            <option value="<?php echo esc_attr(latmmo_get_value_in_array($data, 'product')); ?>" selected="">
                                <?php echo esc_attr(latmmo_get_value_in_array($data, 'name')); ?>
                            </option>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="csf-field csf-field-text">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Image', 'latmmo-aff-amazon'); ?></h4>
                    </div>
                    <div class="csf-fieldset">
                        <input type="text" name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][image]"
                               value="<?php echo latmmo_get_value_in_array($data, 'image'); ?>"
                                                     data-depend-id="image" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="csf-field csf-field-text">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Asin', 'latmmo-aff-amazon'); ?></h4>
                    </div>
                    <div class="csf-fieldset">
                        <input type="text" name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][asin]"
                              value="<?php echo latmmo_get_value_in_array($data, 'asin'); ?>"
                                                     data-depend-id="asin" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="csf-field csf-field-text">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Score', 'latmmo-aff-amazon'); ?></h4>
                    </div>
                    <div class="csf-fieldset">
                        <input type="text" name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][score]"
                               value="<?php echo latmmo_get_value_in_array($data, 'score'); ?>" data-depend-id="score">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="csf-field csf-field-text">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Price', 'latmmo-aff-amazon'); ?></h4>
                    </div>
                    <div class="csf-fieldset">
                        <input type="text" name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][price]"
                               value="<?php echo latmmo_get_value_in_array($data, 'price'); ?>" data-depend-id="price">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="csf-field csf-field-text">
                    <div class="csf-title">
                        <h4><?php echo esc_html__('Review Count', 'latmmo-aff-amazon'); ?></h4></div>
                    <div class="csf-fieldset">
                        <input type="text" name="_la_tc_product_list[_product_list][<?php echo esc_attr($c); ?>][review_count]"
                                value="<?php echo latmmo_get_value_in_array($data, 'review_count'); ?>" data-depend-id="review_count">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <?php

            $html .= ob_get_clean();

            return $html;
        }

        public function import_product_ajax() {
            $products   = (array) $_POST['data'];
            $count      = (int) sanitize_text_field($_POST['l']);

            $i = 1;

            $html = [];

            if (!empty($products)) {
                foreach ($products as $product) {
                    $product = base64_decode($product);
                    $product = (array)json_decode($product);

                    $product_class = new Latmmo_Amazon_Product();

                    $product_id = $product_class->import_amazon_product($product);

                    $rating         = latmmo_get_value_in_array($product, 'rating');
                    $rating         = ($rating) ? (float) $rating : 0;

                    $data = [
                        'product'       => $product_id,
                        'name'          => latmmo_get_value_in_array($product, 'title'),
                        'image'         => latmmo_get_value_in_array($product, 'image'),
                        'asin'          => latmmo_get_value_in_array($product, 'asin'),
                        'score'         => (float)($rating*2),
                        'price'         => latmmo_get_value_in_array($product, 'price'),
                        'review_count'  => latmmo_get_value_in_array($product, 'review_count')
                    ];

                    $html[] = $this->generate_field_product_template($data, $count + $i);

                    $i++;
                }
            }

            echo json_encode(implode('', $html));
            exit;
        }

        public function ajax_get_product_info() {
            $pid = sanitize_text_field($_POST['p']);

            $html = [
                'img'   => get_post_meta($pid, '_amazon_img', true),
                'rate'  => get_post_meta($pid, '_system_rating', true),
                'asin'  => get_post_meta($pid, '_asin', true),
                'price' => get_post_meta($pid, '_price', true),
                'rc'    => get_post_meta($pid, '_review_count', true),
            ];

            echo json_encode($html);
            exit;
        }
    }

    new Latmmo_Amazon_Table();
}