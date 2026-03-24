<?php

/**
 * Plugin Name: Vagonic Sortable Lite
 * Plugin URI: https://vagonic.com
 * Description: Unique product sorting plugin for Woocommerce. Check out the pro version for multi-category editing and more. vagonic.com
 * Version: 1.7
 * Author: vagonic
 * Author URI: https://vagonic.com
 * Text Domain: vagonic-sortable-lite
 * Domain Path: /languages/
 *
 * @package Vagonic Sortable Lite
 */

if (!defined('ABSPATH')) {
	exit;
}

//====== Init ======
add_action('init', 'vagonic_sortable_lite_init');
if (!function_exists('vagonic_sortable_lite_init')) {
	function vagonic_sortable_lite_init()
	{
		if (function_exists('determine_locale')) {
			$locale = determine_locale();
		} else {
			// @todo Remove when start supporting WP 5.0 or later.
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		$locale = apply_filters('plugin_locale', $locale, 'vagonic-sortable-lite');

		unload_textdomain('vagonic-sortable-lite');
		load_textdomain('vagonic-sortable-lite', WP_PLUGIN_DIR . '/vagonic-sortable-lite/languages/' . $locale . '.mo');
	}
}


include "inc/functions.php";

//====== Add Admin Menu ======
add_action('admin_menu', 'vagonic_sortable_lite_register_submenu_page', 99);

if (!function_exists('vagonic_sortable_lite_register_submenu_page')) {
	function vagonic_sortable_lite_register_submenu_page()
	{
		if (is_user_logged_in()) {
			$user = wp_get_current_user();
			$role = (array) $user->roles;

			if (in_array('administrator', $role)) {
				add_submenu_page(
					'edit.php?post_type=product',
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					'manage_options',
					'vagonic-sortable-lite-page',
					'vagonic_sortable_lite_callback'
				);
			} else if (in_array('shop_manager', $role)) {
				add_submenu_page(
					'edit.php?post_type=product',
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					'shop_manager',
					'vagonic-sortable-lite-page',
					'vagonic_sortable_lite_callback'
				);
			} else if (current_user_can('manage_woocommerce')) {
				add_submenu_page(
					'edit.php?post_type=product',
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					__('Vagonic Sortable Lite', 'vagonic-sortable-lite'),
					'shop_manager',
					'vagonic-sortable-lite-page',
					'vagonic_sortable_lite_callback'
				);
			}
		}
	}
}

//====== Load Admin Page View ======
if (!function_exists('vagonic_sortable_lite_callback')) {
	function vagonic_sortable_lite_callback()
	{
		include "page.php";
	}
}

//====== Add Scripts and Styles ======
add_action('admin_enqueue_scripts', 'vagonic_sortable_lite_enqueue');
if (!function_exists('vagonic_sortable_lite_enqueue')) {
	function vagonic_sortable_lite_enqueue($hook)
	{
		if ('product_page_vagonic-sortable-lite-page' != $hook) {
			return;
		}

		// Stylesheets
		wp_register_style('bootstrap4css', (plugin_dir_url(__FILE__) . "/css/bootstrap.min.css"), false);
		wp_register_style('vagonic_sortable_lite_app_css', (plugin_dir_url(__FILE__) . "/css/app.css"), false);
		wp_register_style('vagonic_sortable_lite_material_icons_css', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons', false);
		wp_register_style('vagonic_sortable_lite_toggle_css', (plugin_dir_url(__FILE__) . "/css/bootstrap4-toggle.min.css"), false);
		wp_register_style('vagonic_sortable_lite_toast_css', (plugin_dir_url(__FILE__) . "/css/toastify.min.css"), false);
		wp_register_style('vagonic_sortable_lite_tippy_css', (plugin_dir_url(__FILE__) . "/css/scale.css"), false);
		wp_enqueue_style('bootstrap4css');
		wp_enqueue_style('vagonic_sortable_lite_material_icons_css');
		wp_enqueue_style('vagonic_sortable_lite_app_css');
		wp_enqueue_style('vagonic_sortable_lite_toggle_css');
		wp_enqueue_style('vagonic_sortable_lite_toast_css');
		wp_enqueue_style('vagonic_sortable_lite_tippy_css');

		// Javascripts
		wp_register_script('bootstrap4', (plugin_dir_url(__FILE__) . "/js/bootstrap.min.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_app_js', (plugin_dir_url(__FILE__) . "/js/app.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_popper_js', (plugin_dir_url(__FILE__) . "/js/popper.min.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_tippy_js', (plugin_dir_url(__FILE__) . "/js/tippy-bundle.umd.min.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_sortable_js', (plugin_dir_url(__FILE__) . "/js/Sortable.min.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_toggle_js', (plugin_dir_url(__FILE__) . "/js/bootstrap4-toggle.min.js"), array(), false, true);
		wp_register_script('vagonic_sortable_lite_toast_js', (plugin_dir_url(__FILE__) . "/js/toastify-js.js"), array(), false, true);
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_script('bootstrap4');
		wp_enqueue_script('vagonic_sortable_lite_popper_js');
		wp_enqueue_script('vagonic_sortable_lite_tippy_js');
		wp_enqueue_script('vagonic_sortable_lite_sortable_js');
		wp_enqueue_script('vagonic_sortable_lite_app_js');
		wp_enqueue_script('vagonic_sortable_lite_toggle_js');
		wp_enqueue_script('vagonic_sortable_lite_toast_js');
	}
}

//====== Get Categories ======
add_action('wp_ajax_vagonic_sortable_lite_get_categories', 'vagonic_sortable_lite_get_categories');
if (!function_exists('vagonic_sortable_lite_get_categories')) {
	function vagonic_sortable_lite_get_categories()
	{
		$categories = vagonic_sortable_lite_get_taxonomy_hierarchy('product_cat');
		foreach ($categories as $value) {
?>
			<div class="list-group-item list-group-item-action">
				<a class="" id="<?php echo $value->id ?>"><?php echo $value->value ?></a>
				<div class="button-right">
					<div class="button-vagonic">
						<a class="btn btn-fab btn-list-icon" data-toggle="tooltip" data-placement="right" title="Kategoriye Gözat" target="_blank" href="<?php echo get_category_link($value->id) ?>">
						</a>
					</div>
				</div>
			</div>
		<?php
		}

		exit();
	}
}

//====== Get Products in Category ======
add_action('wp_ajax_vagonic_sortable_lite_get_category_products', 'vagonic_sortable_lite_get_category_products');
if (!function_exists('vagonic_sortable_lite_get_category_products')) {
	function vagonic_sortable_lite_get_category_products()
	{
		if (!empty($_POST) && isset($_POST['cat_id']) && isset($_POST['isPrice']) && isset($_POST['isStock'])) {
			$cat_id = sanitize_text_field($_POST['cat_id']);
			$isPrice = sanitize_text_field($_POST['isPrice']);
			$isStock = sanitize_text_field($_POST['isStock']);
			vagonic_sortable_lite_get_products($cat_id, true, $isPrice == "true" ? true : false, $isStock == "true" ? true : false);
		}
	}
}

//====== Get Tags ======
add_action('wp_ajax_vagonic_sortable_lite_get_tags', 'vagonic_sortable_lite_get_tags');
if (!function_exists('vagonic_sortable_lite_get_tags')) {
	function vagonic_sortable_lite_get_tags()
	{
		$tags = vagonic_sortable_lite_get_taxonomy_hierarchy('product_tag');
		foreach ($tags as $value) {
		?>
			<div class="list-group-item list-group-item-action">
				<a class="" id="<?php echo $value->id ?>"><?php echo $value->value ?></a>
				<div class="button-right">
					<div class="button-vagonic">
						<a class="btn btn-fab btn-list-icon" data-toggle="tooltip" data-placement="right" title="Etikete Gözat" target="_blank" href="<?php echo get_tag_link($value->id) ?>">
						</a>
					</div>
				</div>
			</div>
<?php


		}
		exit();
	}
}

//====== Get Products in Tag ======
add_action('wp_ajax_vagonic_sortable_lite_get_tag_products', 'vagonic_sortable_lite_get_tag_products');
if (!function_exists('vagonic_sortable_lite_get_tag_products')) {
	function vagonic_sortable_lite_get_tag_products()
	{
		if (!empty($_POST) && isset($_POST['tag_id']) && isset($_POST['isPrice']) && isset($_POST['isStock'])) {
			$tag_id = sanitize_text_field($_POST['tag_id']);
			$isPrice = sanitize_text_field($_POST['isPrice']);
			$isStock = sanitize_text_field($_POST['isStock']);
			vagonic_sortable_lite_get_products($tag_id, false, $isPrice == "true" ? true : false, $isStock == "true" ? true : false);
		}
		exit();
	}
}

//====== Save Form ======
add_action('wp_ajax_vagonic_sortable_lite_save', 'vagonic_sortable_lite_save');
if (!function_exists('vagonic_sortable_lite_save')) {
	function vagonic_sortable_lite_save()
	{
		if (!empty($_POST)) {
			$product_ids = isset($_POST['product_id']) ?
				array_map('sanitize_text_field', wp_unslash($_POST['product_id'])) :
				array();

			$menu_orders = isset($_POST['menu_order']) ?
				array_map('sanitize_text_field', wp_unslash($_POST['menu_order'])) :
				array();

			$i = 0;

			$type = isset($_POST['cat_id']) ? true : false;
			$id = $type ? sanitize_text_field($_POST['cat_id']) : sanitize_text_field($_POST['tag_id']);



			if (is_array($product_ids) && is_array($menu_orders)) {
				global $wpdb;

				// Defaults set menu_order is 9999
				$params = array(
					'post_type'         => 'product',
					'posts_per_page'     => -1,
					'post_status'        => array('publish'),
					'tax_query' => array(
						array(
							'taxonomy' => ($type) ? 'product_cat' : 'product_tag',
							'field' => 'term_id',
							'terms' => $id
						)
					),
				);

				$sql_query = "UPDATE {$wpdb->prefix}posts
					SET menu_order = ( CASE ";
				$fields_in = '';

				$wc_query = new WP_Query($params);

				if ($wc_query->have_posts()) :
					while ($wc_query->have_posts()) : $wc_query->the_post();
						global $post;

						$sql_query .= "WHEN ID = '" . $post->ID . "' THEN '9999' ";
						$fields_in .= $post->ID . ',';
					endwhile;
				endif;
				wp_reset_postdata();

				$fields_in = rtrim($fields_in, ',');

				$sql_query .= "END ) 
				WHERE ID IN(" . $fields_in . ")";

				$wpdb->query($sql_query);


				// Save
				$sql_query = "UPDATE {$wpdb->prefix}posts
					SET menu_order = ( CASE ";
				$fields_in = '';

				foreach ($product_ids as $product_id) {
					$product_id = intval($product_id);
					$menu_order = intval($menu_orders[$i]);


					$sql_query .= "WHEN ID = '" . $product_id . "' THEN '" . $menu_order . "' ";
					$fields_in .= $product_id . ',';

					$i++;
				}

				$fields_in = rtrim($fields_in, ',');

				$sql_query .= "END ) 
				WHERE ID IN(" . $fields_in . ")";

				$wpdb->query($sql_query);
			}
			echo _e('success_message', 'vagonic-sortable-lite');
			exit();
		}
	}
}

?>