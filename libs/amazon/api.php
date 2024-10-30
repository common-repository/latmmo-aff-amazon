<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ProductAdvertisingAPIClientException;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
use Amazon\ProductAdvertisingAPI\v1\Configuration;

require_once(LATMMO_AMAZON_DIR_PATH . '/libs/paapi5-php-sdk/vendor/autoload.php');

if (!class_exists('Latmmo_Amazon_Get_Product_Api')) {
    class Latmmo_Amazon_Get_Product_Api extends Latmmo_Amazon_Get_Product_Base {
        public function search_items($keyword, $arpg = false) {
            $config = new Configuration();

            /*
             * Add your credentials
             */
            # Please add your access key here
            $config->setAccessKey(latmmo_get_option('amazon_access_key'));
            # Please add your secret key here
            $config->setSecretKey(latmmo_get_option('amazon_secret_key'));

            # Please add your partner tag (store/tracking id) here
            $partnerTag = latmmo_get_option('amazon_tag_id');

            if (latmmo_get_value_in_array($arpg, 'tag_id') && latmmo_get_value_in_array($arpg, 'tag_id') != '') {
                $partnerTag = latmmo_get_value_in_array($arpg, 'tag_id');
            }

            /*
            * PAAPI host and region to which you want to send request
            * For more details refer:
            * https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
            */
            $config->setHost(self::get_host_region_by_locale('host'));
            $config->setRegion(self::get_host_region_by_locale('region'));

            $apiInstance = new DefaultApi(
            /*
             * If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
             * This is optional, `GuzzleHttp\Client` will be used as default.
             */
                new GuzzleHttp\Client(),
                $config
            );

            /*
             * Specify the category in which search request is to be made
             * For more details, refer:
             * https://webservices.amazon.com/paapi5/documentation/use-cases/organization-of-items-on-amazon/search-index.html
             */
            $searchIndex = latmmo_get_option('amazon_search_index');

            if (latmmo_get_value_in_array($arpg, 'search_type') && latmmo_get_value_in_array($arpg, 'search_type') != '') {
                $searchIndex = latmmo_get_value_in_array($arpg, 'search_type');
            }

            # Specify item count to be returned in search result
            $itemCount = (int) latmmo_get_option('amazon_search_limit_item');

            if (latmmo_get_value_in_array($arpg, 'item_limits') && latmmo_get_value_in_array($arpg, 'item_limits') != '') {
                $itemCount = (int) latmmo_get_value_in_array($arpg, 'item_limits');
            }

            if (latmmo_get_value_in_array($arpg, 'item_page') && latmmo_get_value_in_array($arpg, 'item_page') != '') {
                $ItemPage = latmmo_get_value_in_array($arpg, 'item_page');
            } else {
                $ItemPage = 1;
            }

            /*
             * Choose resources you want from SearchItemsResource enum
             * For more details,
             * refer: https://webservices.amazon.com/paapi5/documentation/search-items.html#resources-parameter
             */
            $resources = [
                SearchItemsResource::ITEM_INFOTITLE,
                SearchItemsResource::OFFERSLISTINGSPRICE,
                SearchItemsResource::OFFERSLISTINGSAVAILABILITYMESSAGE,
                SearchItemsResource::OFFERSLISTINGSMERCHANT_INFO,
                SearchItemsResource::IMAGESPRIMARYLARGE,
                SearchItemsResource::IMAGESVARIANTSLARGE,
                SearchItemsResource::ITEM_INFOBY_LINE_INFO,
                SearchItemsResource::ITEM_INFOFEATURES,
                SearchItemsResource::ITEM_INFOMANUFACTURE_INFO,
                SearchItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE

            ];

            # Forming the request
            $searchItemsRequest = new SearchItemsRequest();
            $searchItemsRequest->setSearchIndex($searchIndex);
            $searchItemsRequest->setKeywords($keyword);
            $searchItemsRequest->setItemCount($itemCount);
            $searchItemsRequest->setItemPage($ItemPage);
            $searchItemsRequest->setPartnerTag($partnerTag);
            $searchItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
            $searchItemsRequest->setResources($resources);

            # Validating request
            $invalidPropertyList = $searchItemsRequest->listInvalidProperties();
            $length = count($invalidPropertyList);
            if ($length > 0) {
//            foreach ($invalidPropertyList as $invalidProperty) {
//                echo $invalidProperty, PHP_EOL;
//            }

                return [
                    'error_code'    => -3,
                    'amz_code'      => -2,
                    'msg'           => esc_html__('Error forming the request', 'latmmo-aff-amazon')
                ];
            }

            # Sending the request
            try {
                $searchItemsResponse = $apiInstance->searchItems($searchItemsRequest);

                # Parsing the response
                if ($searchItemsResponse->getSearchResult() !== null) {
                    $items = $searchItemsResponse->getSearchResult()->getItems();

                    $products = [];

                    if (!empty($items)) {
                        //$other_info_items = latmmo_amazon_search_item_no_api($keyword);

                        foreach ($items as $item) {
                            $item_arr = [];

                            $item_arr['asin']   = $item->getASIN();
                            $item_arr['url']    = $item->getDetailPageURL();

                            if ($item->getItemInfo() !== null && $item->getItemInfo()->getTitle() !== null && $item->getItemInfo()->getTitle()->getDisplayValue() !== null) {
                                $item_arr['title'] = $item->getItemInfo()->getTitle()->getDisplayValue();
                            } else {
                                $item_arr['title'] = '';
                            }

                            if ($item->getImages() != null
                                and $item->getImages()->getPrimary() != null
                                and $item->getImages()->getPrimary()->getLarge() != null
                                and $item->getImages()->getPrimary()->getLarge()->getURL() != null) {

                                $item_arr['image'] = $item->getImages()->getPrimary()->getLarge()->getURL();
                            } else {
                                $item_arr['image'] = '';
                            }


                            if ($item->getImages() != null and $item->getImages()->getVariants() != null) {
                                $item_arr['gallery'] = [];
                                foreach ($item->getImages()->getVariants() as $variant) {
                                    $item_arr['gallery'][] = $variant->getLarge()->getURL();
                                }
                            } else {
                                $item_arr['gallery'] = [];
                            }

                            if ($item->getItemInfo() != null
                                and $item->getItemInfo()->getByLineInfo() != null
                                and $item->getItemInfo()->getByLineInfo()->getBrand() != null
                                and $item->getItemInfo()->getByLineInfo()->getBrand()->getDisplayValue() != null) {

                                $item_arr['brand'] = $item->getItemInfo()->getByLineInfo()->getBrand()->getDisplayValue();
                            } else {
                                $item_arr['brand'] = '';
                            }

                            if ($item->getItemInfo() != null
                                and $item->getItemInfo()->getFeatures() != null
                                and $item->getItemInfo()->getFeatures()->getDisplayValues() != null) {

                                $item_arr['featured']   = $item->getItemInfo()->getFeatures()->getDisplayValues();
                                $item_arr['desc']       = $item->getItemInfo()->getFeatures()->getDisplayValues();
                            } else {
                                $item_arr['featured'] = '';
                            }

                            if ($item->getOffers() !== null
                                and $item->getOffers() !== null
                                and $item->getOffers()->getListings() !== null
                                and $item->getOffers()->getListings()[0]->getPrice() !== null
                                and $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() !== null) {

                                $item_arr['price']  = $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount();
                            } else {
                                $item_arr['price'] = '';
                            }

                            if ($item->getOffers() !== null
                                and $item->getOffers() !== null
                                and $item->getOffers()->getListings() !== null
                                and $item->getOffers()->getListings()[0]->getAvailability() !== null
                                and $item->getOffers()->getListings()[0]->getAvailability()->getMessage() !== null) {

                                $item_arr['stock']  = $item->getOffers()->getListings()[0]->getAvailability()->getMessage();
                            } else {
                                $item_arr['stock']  = '';
                            }

                            if ($item->getOffers() !== null
                                and $item->getOffers() !== null
                                and $item->getOffers()->getListings() !== null
                                and $item->getOffers()->getListings()[0]->getMerchantInfo() !== null
                                and $item->getOffers()->getListings()[0]->getMerchantInfo()->getName() !== null) {

                                $item_arr['merchant_name']  = $item->getOffers()->getListings()[0]->getMerchantInfo()->getName();
                                $item_arr['merchant_id']    = $item->getOffers()->getListings()[0]->getMerchantInfo()->getId();
                            } else {
                                $item_arr['merchant_name']  = '';
                                $item_arr['merchant_id']    = '';
                            }

                            if ($item->getOffers() !== null
                                and $item->getOffers() !== null
                                and $item->getOffers()->getListings() !== null
                                and $item->getOffers()->getListings()[0]->getDeliveryInfo() !== null
                                and $item->getOffers()->getListings()[0]->getDeliveryInfo()->getIsPrimeEligible() !== null) {

                                $item_arr['is_prime']  = $item->getOffers()->getListings()[0]->getDeliveryInfo()->getIsPrimeEligible();
                            } else {
                                $item_arr['is_prime']   = false;
                            }

                            //get data without api
                            $item_info = Latmmo_Amazon_Get_Product_NoApi::search_item($item->getASIN());
                            if (latmmo_get_value_in_array($item_info, $item->getASIN())) {
                                $info = latmmo_get_value_in_array($item_info, $item->getASIN());
                                $item_arr['review_count']   = latmmo_get_value_in_array($info, 'TotalReviews');
                                $item_arr['rating']         = latmmo_get_value_in_array($info, 'Rating');
                            } else {
                                $item_arr['review_count']   = '';
                                $item_arr['rating']         = 0;
                            }
//                        global $wp_filesystem;
//
//                        if (empty($wp_filesystem)) {
//                            require_once(ABSPATH . '/wp-admin/includes/file.php');
//                            WP_Filesystem();
//                        }
//
//                        $response   = $wp_filesystem->get_contents($item->getDetailPageURL());
//                        $dom        = new DOMDocument();
//
//                        $internalErrors = libxml_use_internal_errors(true);
//                        $dom->loadHTML($response);
//
//                        if ($dom->getElementById('acrCustomerReviewText')->nodeValue != null) {
//                            $item_arr['review_count'] = $dom->getElementById('acrCustomerReviewText')->nodeValue;
//                        } else {
//                            $item_arr['review_count'] = '';
//                        }
//
//                        if ($dom->getElementById('productDescription')->nodeValue != null) {
//                            $item_arr['desc'] = $dom->getElementById('productDescription')->nodeValue;
//                        } else {
//                            $item_arr['desc'] = '';
//                        }

                            //libxml_use_internal_errors($internalErrors);
                            // end get data without api

                            if ((int) $item_arr['rating'] > 0) {
                                $products[] = $item_arr;
                            }

                        }
                    }

                    return $products;
                }

                if ($searchItemsResponse->getErrors() !== null) {
                    return [
                        'error_code'    => -1,
                        'amz_code'      => $searchItemsResponse->getErrors()[0]->getCode(),
                        'msg'           => $searchItemsResponse->getErrors()[0]->getMessage()
                    ];
                }

            } catch (ApiException $exception) {
                return [
                    'error_code'    => -2,
                    'amz_code'      => $exception->getCode(),
                    'msg'           => $exception->getMessage()
                ];
//
//            if ($exception->getResponseObject() instanceof ProductAdvertisingAPIClientException) {
//                $errors = $exception->getResponseObject()->getErrors();
//                foreach ($errors as $error) {
//                    echo "Error Type: ", $error->getCode(), PHP_EOL;
//                    echo "Error Message: ", $error->getMessage(), PHP_EOL;
//                }
//            } else {
//                echo "Error response body: ", $exception->getResponseBody(), PHP_EOL;
//            }
            } catch (Exception $exception) {
                return [
                    'error_code'    => -3,
                    'amz_code'      => -1,
                    'msg'           => $exception->getMessage()
                ];
            }
        }
    }
}