<?php

defined('ABSPATH') or die;

if (!function_exists('latmmo_shortcode_table_compare')) {
    function latmmo_shortcode_table_compare($atts, $content = '', $key = '') {
        extract(shortcode_atts(array(
            'id' => ''
        ), $atts));

        /**
         * Code now
         */
        $html = [];

        $html[] = '<div class="latmmo-shortcode latmmo-s-table-compare"><div class="latmmo-s-inner">';

        if (class_exists('Latmmo_Amazon_Templates_Pro')) {
            $template_global    = latmmo_get_option('table_layout_global', 'default');
            $layout_type        = get_post_meta($id, 'layout_type', true);
            $single_template    = get_post_meta($id, 'table_layout', true);
            $template           = ($layout_type == 'custom') ? $single_template : $template_global;
        } else {
            $template = 'default';
        }

        $html[] = '<div class="latmmo-tc-' . $template . '">';

        if ($template == 'default') {
            $tmp = new Latmmo_Amazon_Template();

            ob_start();
            set_query_var('table_id', $id);

            $tmp->get_template_part('shortcodes/table-compare/default');

            $html[] = ob_get_clean();
        } else {
            if (class_exists('Latmmo_Amazon_Templates_Pro')) {
                $tmp = new Latmmo_Amazon_Template_Pro();

                ob_start();
                set_query_var('table_id', $id);

                $tmp->get_template_part('table-compare/' . $template);

                $html[] = ob_get_clean();
            }
        }

        $html[] = '</div>';
        $html[] = '</div>';

        wp_reset_postdata();
        wp_reset_query();

        return implode('', $html);
    }

    add_shortcode('latmmo_table_compare', 'latmmo_shortcode_table_compare');
}
