<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 6/2/2021
 * Time: 2:45 PM
 */

if (!function_exists('latmmo_amazon_link_make_money')) {
    function latmmo_amazon_link_make_money($url) {
        $enable_make_money = latmmo_get_option('enable_make_money');

        if (!$enable_make_money) {
            $url = remove_query_arg('tag', $url);
        }

        return $url;
    }
}

if (!function_exists('latmmo_svg_star')) {
    function latmmo_svg_star() {
        return '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.88px" height="116.864px" viewBox="0 0 122.88 116.864" enable-background="new 0 0 122.88 116.864" xml:space="preserve"><g><polygon fill-rule="evenodd" clip-rule="evenodd" points="61.44,0 78.351,41.326 122.88,44.638 88.803,73.491 99.412,116.864 61.44,93.371 23.468,116.864 34.078,73.491 0,44.638 44.529,41.326 61.44,0"/></g></svg>';
    }
}

