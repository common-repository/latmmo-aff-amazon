<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:45 PM
 */

/**
 * Get config from library
 */
if (! function_exists('latmmo_get_option')) {
	function latmmo_get_option($option_name = '', $default = '', $name = LATMMO_AMAZON_OPTIONS) {
		$options = get_option($name);

		if (! empty($option_name) && ! empty($options[ $option_name ])) {
			return $options[ $option_name ];
		} else {
			return (! empty($default)) ? $default : null;
		}

	}
}

if (!function_exists('latmmo_load_file_path')) {
    function latmmo_load_file_path($file, $path, $load = true) {
        $file       = ltrim($file, '/');
        $file       = $file . '.php';
        $override   = apply_filters('latmmo_amazon_path', 'latmmo-aff-amazon');

        if (file_exists(get_parent_theme_file_path($override .'/'. $file))) {
            $path = get_parent_theme_file_path($override .'/'. $file);
        } elseif (file_exists(get_theme_file_path($override .'/'. $file))) {
            $path = get_theme_file_path($override .'/'. $file);
        } else {
            $path = $path .'/'. $file;
        }

        if (!empty($path) && ! empty($file) && $load) {
            global $wp_query;
            if (is_object($wp_query) && function_exists('load_template')) {
                load_template($path, true);
            } else {
                require_once($path);
            }
        } else {
            return $file;

        }
    }
}

/**
 * Get array value.
 */
if (! function_exists('latmmo_get_value_in_array')) {
	function latmmo_get_value_in_array($array, $key, $default = false) {
		return isset($array[ $key ]) ? $array[ $key ] : $default;
	}
}

/**
 * Get registered sidebars
 */
if (! function_exists('latmmo_wp_registered_sidebars')) {
    function latmmo_wp_registered_sidebars() {
        global $wp_registered_sidebars;

        $widgets	= array();

        if (! empty($wp_registered_sidebars)) {
            foreach ($wp_registered_sidebars as $key => $value) {
                $widgets[$key]	= $value['name'];
            }
        }

        return array_reverse($widgets);
    }
}

/**
 * Create excerpt by post id
 */
if (! function_exists('latmmo_get_excerpt_content')) {
    function latmmo_get_excerpt_content($content, $length, $post_id) {
        $excerpt 	= $content;
        $words 		= explode(' ', $excerpt, $length + 1);

        if (count($words) > $length) {
            array_pop($words);
            array_push($words, '...');
            $excerpt = implode(' ', $words);
            $excerpt = $excerpt . '<a href="' . get_the_permalink($post_id) . '">' . esc_html__(' more', 'latmmo-aff-amazon'). '</a>';
        }

        return $excerpt;
    }
}