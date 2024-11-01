<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Model Class
 * 
 * Handles generic plugin functionality.
 * 
 * @package Category Discounts for WooCommerce
 * @since 1.0.0
 */
class WCD_Model {

    public function __construct() {
        
    }

    /**
     * Escape Tags & Strip Slashes From Array
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_escape_slashes_deep($data = array(), $flag = false, $limited = false) {

        if ($flag != true) {
            $data = $this->wcd_nohtml_kses($data);
        } else {
            if ($limited == true) {
                $data = wp_kses_post($data);
            }
        }

        $data = esc_attr(stripslashes_deep($data));

        return $data;
    }

    /**
     * Strip Html Tags
     * 
     * It will sanitize text input (strip html tags, and escape characters)
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_nohtml_kses($data = array()) {

        if (is_array($data)) {
            $data = array_map(array($this, 'wcd_nohtml_kses'), $data);
        } elseif (is_string($data)) {
            $data = wp_filter_nohtml_kses($data);
        }

        return $data;
    }

    /**
     * Handles to return html for price range 
     * of variable products
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_format_price_range($product, $min_price, $max_price, $pro_min_disc, $pro_max_disc, $disc_text = '') {

        // Create html for variable product
        $price = sprintf(_x('<del>%1$s &ndash; %2$s</del>', 'Price range: from-to', 'woocatdisc'), is_numeric($min_price) ? wc_price($min_price) : $min_price, is_numeric($max_price) ? wc_price($max_price) : $max_price);
        $price .= sprintf(_x('%1$s &ndash; %2$s', 'Price range: from-to', 'woocatdisc'), is_numeric($pro_min_disc) ? wc_price($pro_min_disc) : $pro_min_disc, is_numeric($pro_max_disc) ? wc_price($pro_max_disc) : $pro_max_disc) . sprintf('<small>%s</small>', $disc_text);

        // Return html
        return apply_filters('wcd_format_simple_var_price', $price, $product, $min_price, $max_price, $pro_min_disc, $pro_max_disc, $disc_text);
    }

    /**
     * Handles to return all available roles
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_get_available_roles() {

        // Define global variables
        global $wp_roles;

        $all_roles = $wp_roles->roles; // Get all roles from global variables
        $guest_role = array('guest' => array('name' => __('Guest', 'woocatdisc'))); // Define guest role
        $all_roles = array_merge($guest_role, $all_roles); // Merge guest role
        // Return roles
        return apply_filters('wcd_available_user_roles', $all_roles);
    }

    /**
     * Handles to return discunt types
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_get_disc_types() {

        // Define discount type array
        $disc_types = array(
            'flat_disc' => __('Flat Discount', 'woocatdisc'),
            'perc_disc' => __('Percent Discount', 'woocatdisc'),
            'fix_price' => __('Fixed Price', 'woocatdisc')
        );

        // Return array
        return $this->wcd_nohtml_kses( $disc_types );
    }

    /**
     * Handles to return days array
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.3
     */
    public function wcd_get_days_arr() {

        // Define discount type array
        $day_arr = array(
            'mon' => __('Monday', 'woocatdisc'),
            'tue' => __('Tuesday', 'woocatdisc'),
            'wed' => __('Wednesday', 'woocatdisc'),
            'thu' => __('Thursday', 'woocatdisc'),
            'fri' => __('Friday', 'woocatdisc'),
            'sat' => __('Saturday', 'woocatdisc'),
            'sun' => __('Sunday', 'woocatdisc'),
        );

        // Return array
        return $this->wcd_nohtml_kses( $day_arr );
    }

    /**
     * Handles to get discount, given product_id and variation_id
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.0
     */
    public function wcd_get_disc_details_from_productid($product_id, $variation_id = '') {

        // Get prefix
        $prefix = WOO_CAT_DISC_META_PREFIX;

        // Get current user
        $user = wp_get_current_user();

        // Get product
        $product = wc_get_product($product_id);

        // Get discount category from product id
        $pro_disc_cat_datas = get_post_meta($product_id, $prefix . 'disc_pro_cats', true);

        // Initialize variable
        $data = array();

        // If product have some discount category enabled
        if (!empty($pro_disc_cat_datas)) {

            // Set flag
            $flag = false;

            // If user logged in than consider that user
            if (is_user_logged_in()) {

                $user_role = $user->roles['0']; //array of roles the user is part of.
            } else { // Else consider user as guest
                $user_role = 'guest';
            }

            // Loop on all discount categories
            foreach ($pro_disc_cat_datas as $pro_disc_cat_data) {

                // If user role is in selected discount category
                if (( empty($pro_disc_cat_data['disc_role'])) || (!empty($pro_disc_cat_data['disc_role'])) && in_array($user_role, $pro_disc_cat_data['disc_role'])) {

                    $today_ts = strtotime("now"); // Get timestamp for now
                    $today_day = strtolower(date('D')); // Get day name
                    // If start date is not empty
                    if (!empty($pro_disc_cat_data['disc_start_date'])) {

                        $disc_start_time_ts = strtotime($pro_disc_cat_data['disc_start_date']); // Get start date timestamp
                        // If start date is in future, continue
                        if (!empty($disc_start_time_ts) && $today_ts <= $disc_start_time_ts)
                            continue;
                    }

                    // If end date is not empty
                    if (!empty($pro_disc_cat_data['disc_end_date'])) {

                        $disc_end_time_ts = strtotime($pro_disc_cat_data['disc_end_date'] . ' +1 day'); // Get end date time stamp
                        // If end date is in past, continue
                        if (!empty($disc_end_time_ts) && $today_ts >= $disc_end_time_ts)
                            continue;
                    }

                    // If discount day is not in available days, continue
                    if (!empty($pro_disc_cat_data['disc_day']) && !in_array($today_day, $pro_disc_cat_data['disc_day'])) {

                        continue;
                    }

                    // If discount is empty, continue
                    if (empty($pro_disc_cat_data['disc_amt'])) {

                        continue;
                    }

                    // Extract data
                    extract($pro_disc_cat_data);
                    $flag = true;
                    break;
                }
            }

            // If flag is set
            if ($flag) {

                // Get discount label
                $data['disc_label'] = !empty($disc_label) ? $disc_label : $disc_cat_name;

                // Get discount type
                $data['disc_type'] = !empty($disc_type) ? $disc_type : 'flat_disc';

                // If product type is variable
                if ($product->is_type('variable') && !empty($variation_id)) {

                    // Get variation product
                    $variation_pro = wc_get_product($variation_id);

                    // Get price for variation
                    $data['price'] = $price = $variation_pro->get_price();
                } else {

                    // Get price for simple product
                    $data['price'] = $price = $product->get_price();
                }

                // If discount type is percent discount
                if ($disc_type == 'perc_disc') {

                    $disc_perc = $disc_amt;
                    // If discount amount is set to more than 100
                    if ($disc_perc > 100) {

                        $data['disc_price'] = 0; // Make discount price to 0
                        $data['disc_amt'] = $price; // And make discounted amount to total price
                    } else {

                        $data['disc_price'] = $price - ($price * $disc_perc / 100); // Calculate price after discount
                        $data['disc_amt'] = $price - $data['disc_price']; // Calculate total discount applied
                    }
                } elseif ($disc_type == 'flat_disc') { // If discount is flat discount
                    if ($disc_amt < $price) { // If discount amount is less than price
                        $data['disc_price'] = $price - $disc_amt; // Calculate price after discount
                        $data['disc_amt'] = $price - $data['disc_price']; // Calculate total discount applied
                    } else {

                        $data['disc_price'] = 0; // Make discount price to 0
                        $data['disc_amt'] = $price; // And make discounted amount to total price
                    }
                } elseif ($disc_type == 'fix_price') { // If discount is fix price
                    $data['disc_price'] = $disc_amt; // Set discount applied and price to the discount amount
                    if ($disc_amt < $price) { // If discount amount is less than price
                        $data['disc_amt'] = $price - $data['disc_price']; // Calculate total discount applied
                    } else {

                        $data['disc_amt'] = $disc_amt; // And make discounted amount to total price
                    }
                }
            }
        }

        // Return data
        return apply_filters('wcd_disc_data_from_productid', $data, $product_id, $variation_id);
    }

    /**
     * Handles to get coupon amount from cart
     * 
     * @package Category Discounts for WooCommerce
     * @since 1.0.2
     */
    public function wcd_get_coupon_amt_from_cart() {
        global $woocommerce;

        $coupon_amt_total = 0;
        $items = $woocommerce->cart->get_cart();

        if (empty($items))
            return;

        foreach ($items as $item) {

            $product_id = $item['product_id'];
            $variation_id = !empty($item['variation_id']) ? $item['variation_id'] : 0;

            $disc_data = $this->wcd_get_disc_details_from_productid($product_id, $variation_id);
            if (!empty($disc_data) && !empty($disc_data['disc_amt']) &&
                    ( $disc_data['disc_type'] != 'fix_price' ||
                    ( $disc_data['disc_type'] == 'fix_price' &&
                    $disc_data['disc_price'] < $disc_data['price'] ) )
            ) {

                $coupon_amt_total += $disc_data['disc_amt'];
            }
        }

        return $coupon_amt_total;
    }

}

?>