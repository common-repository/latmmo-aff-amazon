<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('Latmmo_Amazon_Get_Product_Base')) {
    class Latmmo_Amazon_Get_Product_Base {
        public function get_host_region_by_locale($type) {
            $locale = latmmo_get_option('amazon_search_locale', 'us');

            switch ($locale) {
                case 'au':
                    $host       = 'webservices.amazon.com.au';
                    $region     = 'us-west-2';
                    break;

                case 'br':
                    $host       = 'webservices.amazon.com.br';
                    $region     = 'us-east-1';
                    break;

                case 'ca':
                    $host       = 'webservices.amazon.ca';
                    $region     = 'us-east-1';
                    break;

                case 'uk':
                    $host       = 'webservices.amazon.co.uk';
                    $region     = 'eu-west-1';
                    break;

                case 'us':
                    $host       = 'webservices.amazon.com';
                    $region     = 'us-east-1';
                    break;

                default:
                    $host       = 'webservices.amazon.com';
                    $region     = 'us-east-1';
                    break;
            }

            if ($type == 'host') {
                return $host;
            } else if ($type == 'region') {
                return $region;
            }
        }
    }
}