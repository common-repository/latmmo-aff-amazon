<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

$args           = latmmo_amazon_table_query_product_list($table_id);
$table_arr      = latmmo_amazon_table_generate_data_table_product_list($table_id);
$modified_date  = get_the_modified_date(get_option('date_format'), $table_id);
$table_before   = get_post_meta($table_id, 'table_before', true);
$table_after    = get_post_meta($table_id, 'table_after', true);

$i = 1;

$product_query  = new WP_Query($args);
?>
<?php if ($table_before != '') : ?>
    <div class="latmmo-table-before">
        <?php echo wpautop($table_before); ?>
    </div>
<?php endif; ?>
<div class="latmmo-table-products">
    <h2>
        <?php echo get_the_title($table_id); ?>
    </h2>
    <div class="item-products">
        <?php if ($product_query->have_posts()) : ?>
            <?php while ($product_query->have_posts()) : ?>
                <?php $product_query->the_post(); ?>
                <?php
                global $post;

                $product_id = $post->ID;

                $amazon_url     = latmmo_amazon_single_product_amazon_url($product_id);
                $brand          = latmmo_amazon_table_product_general_brand($table_id, $product_id);
                $featured       = latmmo_amazon_table_product_general_featured($table_id, $product_id);
                $score          = latmmo_amazon_table_product_general_score($table_id, $product_id, $table_arr);
                $badge          = latmmo_amazon_table_product_general_badge($table_id, $product_id, $table_arr);
                $image          = latmmo_amazon_table_product_general_image($table_id, $product_id);
                $is_prime       = latmmo_amazon_table_product_general_is_prime($table_id, $product_id);
                $product_url    = latmmo_amazon_table_product_general_url($table_id, $product_id);
                $product_rel    = latmmo_amazon_table_product_general_url_rel($table_id, $product_id);
                $title          = latmmo_amazon_table_product_general_title($table_id, $product_id);
                $icon           = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12" y2="17"></line></svg>';
                ?>

                <div class="item-product">
                    <div class="item-top">
                        <div class="item-image">
                            <div class="item-badge">
                                <span class="n"><?php echo esc_attr($i); ?></span>
                                <span class="t"><?php echo esc_attr($badge); ?></span>
                            </div>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>"/>
                        </div>
                        <div class="item-bottom">
                            <div class="item-s-title">
                                <?php echo latmmo_get_value_in_array($table_arr, $post->ID)['title']; ?>
                            </div>
                            <div class="item-bottom-wrap">
                                <div class="item-bottom-left">
                                    <div class="item-title">
                                        <?php if ($title) : ?>
                                        <h3>
                                            <a href="<?php echo esc_url($product_url); ?>" <?php echo $product_rel; ?> target="_blank">
                                                <?php echo esc_attr($title); ?>
                                            </a>
                                        </h3>
                                        <?php endif; ?>
                                    </div>
                                    <div class="item-info">
                                        <div class="item-brand">
                                            <label><?php echo esc_html__('Brand', 'latmmo-aff-amazon'); ?></label>
                                            <span><?php echo esc_attr($brand); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-bottom-right">
                                    <div class="item-score">
                                        <label>
                                            <?php echo latmmo_amazon_table_product_general_text_score($table_id); ?>
                                        </label>
                                        <p>
                                            <span class="item-rating">
                                                <?php echo esc_attr($score); ?>
                                            </span>
                                            <span class="item-score-txt">
                                                <?php echo esc_html__('Rating Score', 'latmmo-aff-amazon'); ?>
                                            </span>
                                            <span class="h">
                                                <?php echo $icon; ?>
                                                <span class="hp">
                                                    <?php echo latmmo_amazon_table_product_general_text_score_note($table_id); ?>
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="item-link">
                                        <a href="<?php echo esc_url($amazon_url); ?>" target="_blank" rel="nofollow">
                                            <?php echo latmmo_amazon_table_product_general_text_view_amazon($table_id); ?>
                                        </a>
                                    </div>
                                    <?php if ($is_prime) : ?>
                                        <div class="item-prime">
                                            <div class="prime-logo">
                                                <?php echo esc_html__('Prime', 'latmmo-aff-amazon'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <?php echo $featured; ?>
                    </div>
                </div>
                <?php $i++; ?>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        wp_reset_query();
        wp_reset_postdata();
        ?>
    </div>
    <div class="latmmo-end-table">
        <span>
            <?php echo esc_html__('Last update on ', 'latmmo-aff-amazon'); ?>
            <?php echo esc_attr($modified_date); ?>
        </span>
        <?php echo latmmo_amazon_table_product_general_table_note_end($table_id); ?>
    </div>
</div>
<?php if ($table_after != '') : ?>
    <div class="latmmo-table-after">
        <?php echo wpautop($table_after); ?>
    </div>
<?php endif; ?>

