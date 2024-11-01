<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Scripts Class
 *
 * Handles adding scripts and styles
 * on needed pages
 *
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
class WCD_Scripts {

    public function __construct() {
        
    }

    /**
     * Enqueue Scripts
     * 
     * Handles to enqueue script on 
     * needed pages
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_enqueue_disc_cat_scripts($hook_suffix) {

        // Get global variable
        global $woocommerce;

        // Get current screen
        $screen = get_current_screen();

        // Enqueue taxonomy scripts
        if (($hook_suffix == 'edit-tags.php' || $hook_suffix == 'term.php') && $screen->taxonomy == 'wildprog_disc_category') {

            // Enqueue for datepicker
            wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker',
                'jquery-ui-slider'));

            // Register script
           //  wp_register_script('wcd_tax_scripts', WOO_CAT_DISC_INC_URL . '/js/woo-cat-disc-taxonomy-scripts.js', array('jquery'));

            //js directory url
            $js_dir = $woocommerce->plugin_url() . '/assets/js/';

            // Use minified libraries if SCRIPT_DEBUG is turned off
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            // Select2 js
            wp_register_script('select2', $js_dir . 'select2/select2' . $suffix . '.js', array('jquery'), '3.5.2');
            wp_register_script('wc-enhanced-select', $woocommerce->plugin_url() . '/assets/js/admin/wc-enhanced-select' . $suffix . '.js', array('jquery', 'select2'), WC_VERSION);
            wp_enqueue_script('wc-enhanced-select');
        }

        // Enqueue product scripts
        if (($hook_suffix == 'post.php' || $hook_suffix == 'post-new.php') && $screen->post_type == 'product') {

            // Register Script
            wp_enqueue_script('wcd_product_scripts', WOO_CAT_DISC_INC_URL . '/js/woo-cat-disc-product-scripts.js', array());

            wp_localize_script('wcd_product_scripts', 'wcd_product', array(
                'ajaxurl' => admin_url('admin-ajax.php', ( is_ssl() ? 'https' : 'http')),
                'remove_discount_cat' => __('Remove this Discount Category?', 'woocatdisc')
            ));

            // Enqueue for datepicker
            wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker',
                'jquery-ui-slider'));
        }

        //Check pages when you needed 
        if ($hook_suffix == 'woocommerce_page_wc-settings' && !empty($_REQUEST['tab']) && $_REQUEST['tab'] == 'wcd_settings') {

            // Register Script
            wp_enqueue_script('wcd_settings_scripts', WOO_CAT_DISC_INC_URL . '/js/woo-cat-disc-settings-scripts.js', array('jquery'));
        }
    }

    /**
     * Enqueue Styles
     * 
     * Handles to enqueue styles on 
     * needed pages
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_enqueue_disc_cat_styles($hook_suffix) {

        // Get global variable
        global $woocommerce;

        // Get current screen
        $screen = get_current_screen();

        // Enqueue taxonomy scripts
        if (($hook_suffix == 'edit-tags.php' || $hook_suffix == 'term.php') && $screen->taxonomy == 'wildprog_disc_category') {

            // Register style
            // wp_enqueue_style('wcd_tax_styles', WOO_CAT_DISC_INC_URL . '/css/woo-cat-disc-taxonomy-styles.css', array());

            // Enqueue for datepicker
            wp_enqueue_style('woo-vou-meta-jquery-ui-css', WOO_CAT_DISC_INC_URL . '/css/datetimepicker/date-time-picker.css', array());

            // Enqueue woocommerce admin style for select2
            wp_enqueue_style('woocommerce_public_select2_styles', WC()->plugin_url() . '/assets/css/select2.css', array(), WC_VERSION);
        }

        // Enqueue product scripts
        if (($hook_suffix == 'post.php' || $hook_suffix == 'post-new.php') && $screen->post_type == 'product') {

            // Register style
            wp_enqueue_style('wcd_product_styles', WOO_CAT_DISC_INC_URL . '/css/woo-cat-disc-product-styles.css', array());

            // Enqueue for datepicker
            wp_enqueue_style('woo-vou-meta-jquery-ui-css', WOO_CAT_DISC_INC_URL . '/css/datetimepicker/date-time-picker.css', array());
        }
    }

    /**
     * Adding Hooks
     *
     * Adding proper hoocks for the scripts.
     *
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function add_hooks() {

        // Add scripts for custom taxonomy page and product page
        add_action('admin_enqueue_scripts', array($this, 'wcd_enqueue_disc_cat_scripts'));

        // Add styles for custom taxonomy page and product page
        add_action('admin_enqueue_scripts', array($this, 'wcd_enqueue_disc_cat_styles'));
    }

}
