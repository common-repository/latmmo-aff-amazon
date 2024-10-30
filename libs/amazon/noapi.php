<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('Latmmo_Amazon_Get_Product_NoApi')) {
    class Latmmo_Amazon_Get_Product_NoApi extends Latmmo_Amazon_Get_Product_Base {
        public static function search_item($keyword) {
            $url    = 'https://ws-na.amazon-adsystem.com/widgets/q';
            $params = [
                'Keywords'          => $keyword,
                'MarketPlace'       => 'US',
                'callback'          => 'search_callback',
                'Operation'         => 'GetResults',
                'TemplateId'        => 'MobileSearchResults',
                'ServiceVersion'    => '20070822',
                'InstanceId'        => '',
                'dataType'          => 'jsonp'
            ];

            $x          = new Restclient();
            $response   = $x->get($url, $params);
            $response   = $response->response;
            $response   = trim($response);
            $response   = str_replace('search_callback', '', $response);
            $response   = trim($response, "()");
            $response   = preg_replace('/(\w+) :/i', '"$1" :', $response);
            $response   = str_replace('MarketPlace: ', '"MarketPlace": ', $response);
            $response   = str_replace('InstanceId: ', '"InstanceId": ', $response);
            $response   = json_decode($response, true);

            $items      = latmmo_get_value_in_array($response, 'results');
            $result     = [];

            if (!empty($items)) {
                foreach ($items as $item) {
                    $result[latmmo_get_value_in_array($item, 'ASIN')] = [
                        'Rating'        => latmmo_get_value_in_array($item, 'Rating'),
                        'TotalReviews'  => latmmo_get_value_in_array($item, 'TotalReviews'),
                    ];
                }
            }

            return $result;
        }
    }
}