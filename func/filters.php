<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:45 PM
 */

if (!function_exists('latmmo_custom_template')) {
    function latmmo_custom_template($template) {
        //$tmpl = new Ocanus_Template();

//        if (is_single()) {
//            global $post;
//
//            $type = get_post_meta($post->ID, '_type', true);
//
//            if ($type ==  '2') {
//                $template 	= $tmpl->get_template_part('amazon/post', null, false);
//            }
//        }

        if (is_singular('oca-product')) {
            //$template 	= $tmpl->get_template_part('amazon/product', null, false);
        }

        return $template;
    }

    add_filter('template_include', 'latmmo_custom_template');
}
