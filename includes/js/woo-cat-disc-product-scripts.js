// On document ready
jQuery(document).ready(function ($) {

    // Loop on discount category select box
    $('.wcd_disc_cat_id').each(function (index, el) {
        var id = $(this).val();
        // If discount category is already added than disable it from dropdown
        if (id) {
            $('select.wild-disc-cat option[value="' + id + '"]').attr('disabled', 'disabled');
        }
    });

    // Add datepicker for start faye and end date
    $("input[id^='disc_start_date_'], input[id^='disc_end_date_']").each(function () {
        $(this).datepicker({dateFormat: 'd-m-yy'});
    });

    // Add select2
    $('select.wcd-has-select2').select2();

    // On click of Remove button
    $('.product_disc_cats').on('click', '.remove_row', function () {

        // Confirm whether user wants to remove the category
        if (window.confirm(wcd_product.remove_discount_cat)) {

            $parent = $(this).parent().parent(); // Get main div
            $parent.hide(); // Hide it
            var i = $parent.attr('rel'); // Get rel attribute
            var remove_disc_cats = $('.product_disc_cats .wcd-disc-cat .wcd_data_remove_disc_cat').length; // Get length for added discounts
            var wcd_disc_cat_id = $parent.find('.wcd_disc_cat_id').val(); // Get cat id
            $('select.wild-disc-cat option[value="' + wcd_disc_cat_id + '"]').removeAttr('disabled'); // Enable it in select box, so as user can add it now
            remove_disc_cats = -remove_disc_cats - 1;
            $(this).parent().parent().find('.disc_cat_position').after('<input type="hidden" class="wcd_data_remove_disc_cat" name="wcd_data[' + i + '][disc_remove]" value="' + remove_disc_cats + '">');
        }

        // Return false
        return false;
    });

    // Attribute ordering. JS for moving blocks horizontally
    // Code from WC
    $('.product_disc_cats').sortable({
        items: '.wcd-disc-cat',
        cursor: 'move',
        axis: 'y',
        handle: 'h3',
        scrollSensitivity: 40,
        forcePlaceholderSize: true,
        helper: 'clone',
        opacity: 0.65,
        placeholder: 'wc-metabox-sortable-placeholder',
        start: function (event, ui) {
            ui.item.css('background-color', '#f6f6f6');
        },
        stop: function (event, ui) {
            ui.item.removeAttr('style');
            disc_cat_row_indexes();
        }
    });

    // Add rows.
    $('#wildprog_disc_cat button.add_disc_cat').on('click', function () {

        var attribute = $('select.wild-disc-cat').val(); // Get attribute value
        var size = $('.product_disc_cats .wcd-disc-cat').length; // Get size of added discounts
        var $wrapper = $(this).closest('#wildprog_disc_cat'); // Get wrapper

        // Prepare data for post request
        var data = {
            action: 'wcd_add_disc_cat',
            taxonomy: attribute,
            i: size,
        };

        // Add loader
        $wrapper.block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });

        // Create POST Request
        $.post(wcd_product.ajaxurl, data, function (response) {

            $('#wildprog_disc_cat .product_disc_cats').append(response); // Append response
            if (attribute) { // If attribute was selected
                $('select.wild-disc-cat :selected').attr('disabled', 'disabled'); // Disable it
            }
            $('select.wild-disc-cat').val(''); // Select initial value
            $('select.wcd-has-select2').select2(); // Add select2 for all dropdowns
            $('#disc_start_date_' + size).datepicker({dateFormat: 'd-m-yy'}); // Add datepicker
            $('#disc_end_date_' + size).datepicker({dateFormat: 'd-m-yy'}); // Add datepicker
            $wrapper.unblock(); // Remove loader
        });
    });

    // On enetring name for custom discount category
    $(document).on('focusout', "input[id^='disc_cat_names_']", function () {

        // Make that name appear on h3 tag
        $(this).parents('div.wcd-disc-cat').find('h3 .wcd_cat_name').html($(this).val());
    });

    // Function to assign position for discount categories
    function disc_cat_row_indexes() {
        $('.product_disc_cats .wcd-disc-cat').each(function (index, el) {
            $('.disc_cat_position', el).val(parseInt($(el).index('.product_disc_cats .wcd-disc-cat'), 10));
        });
    }

    $(document).on('click', '.wild-prog-select-all-roles', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var elId = '#disc_roles_'+id+' > option';
        $(elId).prop("selected","selected");
        $(elId).trigger("change");
    });

    $(document).on('click','.wild-prog-unselect-all-roles', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var elId = '#disc_roles_'+id+' > option';
        $(elId).removeAttr("selected");
        $(elId).trigger("change");
    });

    $(document).on('click','.wild-prog-select-all-days', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var elId = '#disc_days_'+id+' > option';
        $(elId).prop("selected","selected");
        $(elId).trigger("change");
    });

    $(document).on('click','.wild-prog-unselect-all-days', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var elId = '#disc_days_'+id+' > option';
        $(elId).removeAttr("selected");
        $(elId).trigger("change");
    });
});