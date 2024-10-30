<?php
/*
Plugin Name: 		LATMMO Aff Amazon
Description:		Amazon Aff LATMMO is the best plugin for WordPress Amazon affiliates with a suite of features to help you more effectively promote Amazon products and earn commissions.
Version: 			1.0.0
Author: 			LAT team
Author URI:			https://tranngocthuy.com/latmmo/
*/

if (!defined('ABSPATH')) {
	return;
}

if (!class_exists('Latmmo_Amazon')) {
	class Latmmo_Amazon {
		public function __construct() {
			require_once 'define.php';

			$this->load_library();
			$this->load_helper();
			
			add_action('init', array(__CLASS__, 'load_config'), 2);
            add_action('init', array(__CLASS__, 'shortcodes'), 2);
            add_action('admin_menu', array($this, 'admin_menu_page'));

			if (!is_admin()) {
				add_action('wp_enqueue_scripts', array($this, 'action_enqueue_scripts'), 20);
			}
		}

		function admin_menu_page() {
            add_menu_page(
                esc_html__('LATMMO', 'latmmo-aff-amazon'),
                esc_html__('LATMMO', 'latmmo-aff-amazon'),
                'manage_options',
                'latmmo',
                null,
                'dashicons-amazon'
            );
        }

		// load library.
		public function load_library() {
			// Load core framework
			if (!class_exists('CSF')) {
				require_once LATMMO_AMAZON_DIR_PATH . '/libs/codestar-framework/codestar-framework.php';
			}

			// Load template framework
			if (!class_exists('Gamajo_Template_Loader')) {
                require_once LATMMO_AMAZON_DIR_PATH . '/libs/templates/class-gamajo-template-loader.php';
            }

            require_once LATMMO_AMAZON_DIR_PATH . '/libs/fields/addons.php';

			require_once LATMMO_AMAZON_DIR_PATH . '/libs/amazon/base.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/libs/amazon/api.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/libs/amazon/noapi.php';
		}

		// load config.
		public static function load_config() {
			require_once LATMMO_AMAZON_DIR_PATH . '/config/framework.php';
			require_once LATMMO_AMAZON_DIR_PATH . '/config/metabox.php';
		}

		// load helper.
		public function load_helper() {
            require_once LATMMO_AMAZON_DIR_PATH . '/classes/rest.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/classes/template.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/classes/admin.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/classes/table.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/classes/product.php';

			require_once LATMMO_AMAZON_DIR_PATH . '/func/base.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/func/resize.php';
			require_once LATMMO_AMAZON_DIR_PATH . '/func/post-type.php';
			require_once LATMMO_AMAZON_DIR_PATH . '/func/helpers.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/func/table.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/func/product.php';
			require_once LATMMO_AMAZON_DIR_PATH . '/func/hooks.php';
			require_once LATMMO_AMAZON_DIR_PATH . '/func/filters.php';
            require_once LATMMO_AMAZON_DIR_PATH . '/func/post.php';

		}

		public function action_enqueue_scripts() {
            wp_register_style('fancybox', LATMMO_AMAZON_DIR_URL . 'assets/css/vendor/fancybox.min.css', array(), false);
            wp_register_style('slick', LATMMO_AMAZON_DIR_URL . 'assets/css/vendor/slick.css', array(), false);
            wp_register_style('fontawesome', LATMMO_AMAZON_DIR_URL . 'assets/css/vendor/font-awesome/fontawesome.min.css', array(), false);
			wp_enqueue_style('latmmo-helper-style', LATMMO_AMAZON_DIR_URL . 'assets/css/style.css', array(), false);

			wp_register_script('fancybox', LATMMO_AMAZON_DIR_URL . '/assets/js/vendor/jquery.fancybox.min.js', array('jquery'), false, true);
            wp_register_script('slick', LATMMO_AMAZON_DIR_URL . '/assets/js/vendor/slick.min.js', array('jquery'), false, true);
            wp_register_script('chartjs', LATMMO_AMAZON_DIR_URL . '/assets/js/vendor/chart.min.js', array('jquery'), false, true);
            wp_register_script('latmmo-shortcode', LATMMO_AMAZON_DIR_URL . '/assets/js/fe/shortcode.js', array('jquery'), false, true);

            //wp_enqueue_script('chartjs');
			wp_enqueue_script('latmmo-amazon-script', LATMMO_AMAZON_DIR_URL . '/assets/js/fe/script.js', array('jquery'), false, true);
			wp_localize_script('latmmo-amazon-script', 'latmmo_script', array(
				'ajax_url'		=> admin_url('admin-ajax.php'),
			));
		}

		public static function shortcodes() {
            $path = LATMMO_AMAZON_DIR_PATH . '/shortcodes/';

            CSF::createShortcoder(LATMMO_AMAZON_SHORTCODE, [
                'button_title'  => esc_html__('LATMMO Shortcodes', 'latmmo-aff-amazon')
            ]);

            $shortcodes = [
                'table-compare',
                'single-product',
                'product-link',
                'product-history'
            ];

            foreach ($shortcodes as $shortcode) {
                if (is_admin() && file_exists($path . $shortcode . '/config.php')) {
                    require_once $path . $shortcode . '/config.php';
                }

                if (!is_admin() && file_exists($path . $shortcode . '/template.php')) {
                    require_once $path . $shortcode . '/template.php';
                }
            }
        }
	}

	new Latmmo_Amazon();
}