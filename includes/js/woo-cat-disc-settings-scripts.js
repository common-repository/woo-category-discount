jQuery(document).ready(function ($) {

    // Function to toggle all dependent options depending on selected Discount Method
    function wcd_toggle_prefix_suffix_option() {

        var discount_method = $('#wcd_discount_method').val();
        if (discount_method == 'after_purchase') {
            $("#wcd_coupon_prefix").parents('tr').fadeIn();
            $("#wcd_coupon_suffix").parents('tr').fadeIn();
            $("#wcd_coupon_seperator").parents('tr').fadeIn();
            $('#wcd_discount_method').parents('table.form-table').nextUntil('p.submit').fadeIn();
        } else {
            $("#wcd_coupon_prefix").parents('tr').fadeOut();
            $("#wcd_coupon_suffix").parents('tr').fadeOut();
            $("#wcd_coupon_seperator").parents('tr').fadeOut();
            $('#wcd_discount_method').parents('table.form-table').nextUntil('p.submit').fadeOut();
        }
    }

    // Function to toggle product page message option depending on enable product page option
    function wcd_toggle_pro_page_msg() {

        if ($('#wcd_enable_product_page_msg').is(':checked')) {
            $('#wcd_product_page_msg').parents('tr').fadeIn();
        } else {
            $('#wcd_product_page_msg').parents('tr').fadeOut();
        }
    }

    // Function to toggle cart page message option depending on enable cart page option
    function wcd_toggle_cart_page_msg() {

        if ($('#wcd_enable_cart_page_msg').is(':checked')) {
            $('#wcd_cart_page_msg').parents('tr').fadeIn();
        } else {
            $('#wcd_cart_page_msg').parents('tr').fadeOut();
        }
    }

    // Function to toggle checkout page message option depending on enable checkout page option
    function wcd_toggle_checkout_page_msg() {

        if ($('#wcd_enable_checkout_page_msg').is(':checked')) {
            $('#wcd_checkout_page_msg').parents('tr').fadeIn();
        } else {
            $('#wcd_checkout_page_msg').parents('tr').fadeOut();
        }
    }

    // Setting page onload show/hide remove voucher download link option
    wcd_toggle_prefix_suffix_option();

    // Setting page toggle remove voucher download link on click multiple voucher checkbox
    $(document).on('change', "#wcd_discount_method", function () {
        wcd_toggle_prefix_suffix_option();
    });

    wcd_toggle_pro_page_msg();

    // on click of checkbox for showing message on product page
    $("#wcd_enable_product_page_msg").on('click', function () {
        wcd_toggle_pro_page_msg();
    });

    wcd_toggle_cart_page_msg();

    // on click of checkbox for showing message on cart page
    $("#wcd_enable_cart_page_msg").on('click', function () {
        wcd_toggle_cart_page_msg();
    });

    wcd_toggle_checkout_page_msg();

    // on click of checkbox for showing message on checkout page
    $("#wcd_enable_checkout_page_msg").on('click', function () {
        wcd_toggle_checkout_page_msg();
    });
});