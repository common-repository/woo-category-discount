<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
class WCD_Admin {

    public $model, $scripts;

    // Class constructor
    function __construct() {

        global $wcd_model, $wcd_scripts;

        $this->model = $wcd_model;
        $this->scripts = $wcd_scripts;
    }

    /**
     * WooCommerce custom product tab
     * 
     * Adds a new tab to the Product Data postbox in the admin product interface
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_add_write_panel_tab() {

        // Add Discount Category row in Woocommerce metabox on product page
        echo "<li class=\"wcd_write_panel_tab\"><a href=\"#wildprog_disc_cat\"><span>" . esc_html( __('Discount Category', 'woocatdisc') ) . "</span></a></li>";
    }

    /**
     * WooCommerce custom product tab data
     * 
     * Adds the panel to the Product Data postbox in the product interface
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_product_write_panel() {

        // Get global variable
        global $post, $thepostid, $product_object, $wp_roles;

        // Get prefix
        $prefix = WOO_CAT_DISC_META_PREFIX;
        $wcd_data = get_post_meta($thepostid, $prefix . 'disc_pro_cats', true);

        // Include html for Discount Categories row on product metabox page
        include(WOO_CAT_DISC_ADMIN_DIR . '/product-metabox/html-product-discount-categories.php');
    }

    /**
     * WooCommerce custom product tab data
     * 
     * Adds the panel to the Product Data postbox in the product interface
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_product_save_data($post_id, $post) {

        // Get global variable
        global $post_type;

        // Get prefix
        $prefix = WOO_CAT_DISC_META_PREFIX;

        // Declare variables
        $wcd_data = $formatted_wcd_data = $new_data = array();

        // If data is set in $_POST
        if (!empty($_POST['wcd_data'])) {

            $wcd_data = $this->model->wcd_nohtml_kses( $_POST['wcd_data'] );

            // Loop on discount categories data
            foreach ($wcd_data as $data) {

                // If user have not removed the discount category
                if (!isset($data['disc_remove'])) {

                    // If disc_day is not empty than set it as empty array
                    if (!isset($data['disc_day'])) {
                        $data['disc_day'] = array();
                    }

                    // If disc_role is not empty than set it as empty array
                    if (!isset($data['disc_role'])) {
                        $data['disc_role'] = array();
                    }

                    // Loop on all data
                    foreach ($data as $key => $value) {

                        // If value is not array than remove slashes and trim it
                        if (!is_array($value)) {

                            $value = $this->model->wcd_escape_slashes_deep(trim($value));
                        }
                        $new_data[$key] = $value;
                    }

                    // Create new array with the order which user choose
                    $formatted_wcd_data[$data['disc_cat_position']] = $new_data;
                }
            }

            // Update data in post meta
            update_post_meta($post_id, $prefix . 'disc_pro_cats', $formatted_wcd_data);
        }
    }

    /**
     * Handles to add discount category in product meta
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_add_disc_cat() {

        // Declare variables
        $i = 0;
        $taxonomy = $term_meta = $disc_role = $disc_day = $disc_cat_name = $disc_type = $disc_label = $disc_start_date = $disc_end_date = '';
        $sanitized_post = $this->model->wcd_nohtml_kses($_POST);

        // If not empty position
        if (!empty($sanitized_post['i'])) {

            $i = $sanitized_post['i'];
        }

        // Get discount category
        $disc_cat_id = !empty($sanitized_post['taxonomy']) ? $sanitized_post['taxonomy'] : '';

        // Get discount types
        $disc_types = $this->model->wcd_get_disc_types();

        // Get all roles
        $all_roles = $this->model->wcd_get_available_roles();

        // Get all available days
        $day_arr = $this->model->wcd_get_days_arr();

        // Include html for discount category on product page
        include(WOO_CAT_DISC_ADMIN_DIR . '/product-metabox/html-add-disc-cat.php');
        wp_die();
    }

    /**
     * Adding Hooks
     *
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    function add_hooks() {

        // Add metabox in products
        add_action('woocommerce_product_write_panel_tabs', array($this, 'wcd_add_write_panel_tab'));

        // Add action to add html for adding in woocommerce write panel
        add_action('woocommerce_product_data_panels', array($this, 'wcd_product_write_panel'));

        // Add action to save product meta
        add_action('woocommerce_process_product_meta', array($this, 'wcd_product_save_data'), 20, 2);

        // Add action to add discount category
        add_action('wp_ajax_wcd_add_disc_cat', array($this, 'wcd_add_disc_cat'));
    }

}

?>