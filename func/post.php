<?php

/**
 * Create thumbnail post for single page
 */
if (! function_exists('latmmo_single_thumbnail')) {
    function latmmo_single_thumbnail($size = 'full') {
        if (post_password_required() || is_attachment() || ! has_post_thumbnail() || !latmmo_get_option('blog_single_image_show')) {
            return;
        }

        global $post;

        echo '<div class="post-thumbnail">';
        echo '<a href="' . esc_url(get_the_permalink($post->ID)) . '" class="latmmo-image">';
        echo get_the_post_thumbnail($post->ID, $size);
        echo '</a>';
        echo '</div>';
    }
}

/**
 * Create title post for single page
 */
if (!function_exists('latmmo_single_title')) {
    function latmmo_single_title() {
        global $post;

        echo '<h2 class="entry-title">';
        echo '<a href="' . esc_url(get_the_permalink($post->ID)) . '">';
        echo get_the_title($post->ID);
        echo '</a>';
        echo '</h2>';
    }
}

/**
 * Create date of post for single post
 */
if (!function_exists('latmmo_single_date')) {
    function latmmo_single_date($format = false) {
        global $post;

        $format = ($format == false) ? get_option('date_format') : $format;

        echo '<div class="entry-date">';
        echo '<a href="' . esc_url(get_the_permalink($post->ID)) . '" rel="bookmark">';
        echo '<span>' . get_the_date($format) . '</span>';
        echo '</a>';
        echo '</div>';
    }
}

/**
 * Create author of post for single post
 */
if (!function_exists('latmmo_single_author')) {
    function latmmo_single_author() {
        echo '<div class="entry-author author vcard">';
        echo '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html__('By ', 'latmmo') . get_the_author() . '</a>';
        echo '</div>';
    }
}

/**
 * Create comments of post for single post
 */
if (!function_exists('latmmo_single_comments')) {
    function latmmo_single_comments() {
        echo '<div class="entry-comments-link">';
        echo '<i class="fa fa-comments" aria-hidden="true"></i>';
        echo comments_number('0', '1', '%');
        echo '</div>';
    }
}

/**
 * Create content for single post
 */
if (!function_exists('latmmo_single_content')) {
    function latmmo_single_content() {
        the_content(esc_html__( 'Read More', 'latmmo'));

        wp_link_pages(
            array(
                'before'        => '<div class="page-links latmmo-pagination"><span class="page-links-title">' . esc_html__('Pages:', 'latmmo') . '</span>',
                'after'         => '</div>',
                'link_before'   => '<span>',
                'link_after'    => '</span>',
            )
        );
    }
}