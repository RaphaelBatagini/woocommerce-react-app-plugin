<?php
/**
 * Plugin Name: E-commerce React App
 * Description: Plugin to integrate with E-commerce React App
 * Version: 1.0.0
 * Text Domain: ecommerce
 * Domain Path: /i18n/languages/
 */

// return multiple image sizes when getting products from API
function prepare_product_images($response) {
    global $_wp_additional_image_sizes;

    if (empty($response->data)) {
        return $response;
    }

    foreach ($response->data['images'] as $key => $image) {
        foreach ($_wp_additional_image_sizes as $size => $value) {
            $image_info = wp_get_attachment_image_src($image['id'], $size);
            $response->data['images'][$key][$size] = $image_info[0];
        }
    }
    return $response;
}

add_filter('woocommerce_rest_prepare_product_object', 'prepare_product_images', 10, 1);