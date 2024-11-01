<?php

/**
 * Plugin Name: Category Discounts for WooCommerce
 * Description: With Category Discount Extension, you can create set discounts by assigning product to some category.
 * Version: 1.0.8
 * Author: WildProgrammers
 * Author URI: http://wildprogrammers.com/
 * Text Domain: woocatdisc
 * Domain Path: languages
 *
 * WC tested up to: 6.3.1
 * 
 * @package Category Discounts for WooCommerce
 * @category Core
 * @author WildProgrammers
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Basic plugin definitions
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
if (!defined('WOO_CAT_DISC_PLUGIN_VERSION')) {
    define('WOO_CAT_DISC_PLUGIN_VERSION', '1.0.8'); //Plugin version number
}
if (!defined('WOO_CAT_DISC_DIR')) {
    define('WOO_CAT_DISC_DIR', dirname(__FILE__)); // plugin dir
}
if (!defined('WOO_CAT_DISC_URL')) {
    define('WOO_CAT_DISC_URL', plugin_dir_url(__FILE__)); // plugin url
}
if (!defined('WOO_CAT_DISC_INC_DIR')) {
    define('WOO_CAT_DISC_INC_DIR', WOO_CAT_DISC_DIR . '/includes'); // Plugin include dir
}
if (!defined('WOO_CAT_DISC_INC_URL')) {
    define('WOO_CAT_DISC_INC_URL', WOO_CAT_DISC_URL . 'includes'); // Plugin include url
}
if (!defined('WOO_CAT_DISC_ADMIN_DIR')) {
    define('WOO_CAT_DISC_ADMIN_DIR', WOO_CAT_DISC_INC_DIR . '/admin'); // plugin admin dir
}
if (!defined('WOO_CAT_DISC_PLUGIN_BASENAME')) {
    define('WOO_CAT_DISC_PLUGIN_BASENAME', basename(WOO_CAT_DISC_DIR)); //Plugin base name
}
if (!defined('WOO_CAT_DISC_META_PREFIX')) {
    define('WOO_CAT_DISC_META_PREFIX', '_wcd_'); // meta data box prefix
}

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
register_activation_hook(__FILE__, 'wcd_install');

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
function wcd_install() {

    global $wpdb;
}

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @package Category Discounts for WooCommerce
 *  @since 1.0.0
 */
register_deactivation_hook(__FILE__, 'wcd_uninstall');

/**
 * Plugin Setup (On Deactivation)
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
function wcd_uninstall() {

    global $wpdb;
}

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
function wcd_load_text_domain() {

    // Set filter for plugin's languages directory
    $wcd_lang_dir = dirname(plugin_basename(__FILE__)) . '/languages/';
    $wcd_lang_dir = apply_filters('wcd_languages_directory', $wcd_lang_dir);

    // Traditional WordPress plugin locale filter
    $locale = apply_filters('plugin_locale', get_locale(), 'woocatdisc');
    $mofile = sprintf('%1$s-%2$s.mo', 'woocatdisc', $locale);

    // Setup paths to current locale file
    $mofile_local = $wcd_lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/' . WOO_CAT_DISC_PLUGIN_BASENAME . '/' . $mofile;

    if (file_exists($mofile_global)) { // Look in global /wp-content/languages/wildprog-woo-cat-discount folder
        load_textdomain('woocatdisc', $mofile_global);
    } elseif (file_exists($mofile_local)) { // Look in local /wp-content/plugins/wildprog-woo-cat-discount/languages/ folder
        load_textdomain('woocatdisc', $mofile_local);
    } else { // Load the default language files
        load_plugin_textdomain('woocatdisc', false, $wcd_lang_dir);
    }
}

// Add action to load plugin
add_action('plugins_loaded', 'wcd_plugin_loaded');

/**
 * Load Plugin
 * 
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
function wcd_plugin_loaded() {

    //check Woocommerce is activated or not
    if (class_exists('Woocommerce')) {

        // load first plugin text domain
        wcd_load_text_domain();

        // Global variables
        global $wcd_scripts, $wcd_model, $wcd_admin, $wcd_public;

        // Script class handles most of script functionalitiC:\Users\PC-19\Downloadses of plugin
        include_once(WOO_CAT_DISC_INC_DIR . '/class-woo-cat-disc-scripts.php');
        $wcd_scripts = new WCD_Scripts();
        $wcd_scripts->add_hooks();

        // Model class handles most of model functionalities of plugin
        include_once(WOO_CAT_DISC_INC_DIR . '/class-woo-cat-disc-model.php');
        $wcd_model = new WCD_Model();

        include_once(WOO_CAT_DISC_INC_DIR . '/class-woo-cat-disc-public.php');
        $wcd_public = new WCD_Public();
        $wcd_public->add_hooks();

        // Admin class handles most of admin panel functionalities of plugin
        include_once(WOO_CAT_DISC_ADMIN_DIR . '/class-woo-cat-disc-admin.php');
        $wcd_admin = new WCD_Admin();
        $wcd_admin->add_hooks();
    }
}

?>