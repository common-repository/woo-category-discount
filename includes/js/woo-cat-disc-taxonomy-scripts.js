// On document ready
jQuery(document).ready(function ($) {

    // When category added, than unset all fields, as default WP does
    // Code from WC
    $(document).ajaxComplete(function (event, request, options) {

        // If response is success
        if (request && 4 === request.readyState && 200 === request.status
                && options.data && 0 <= options.data.indexOf('action=add-tag')) {

            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
            if (!res || res.errors) {
                return;
            }
            $('#wcd_disc_amt').val(''); // Unset Amount
            $('#wcd_sel_disc_type option:eq(0)').attr('selected', 'selected'); // Select first option
            $('#wcd_sel_disc_type').trigger('change');
            $('#wcd_sel_disc_role > option').prop("selected", false); // Unselect all option
            $('#wcd_sel_disc_role').trigger('change'); // Trigger change for select2
            $('#wcd_sel_disc_day > option').prop("selected", false); // Unselect all option
            $('#wcd_sel_disc_day').trigger('change'); // Trigger change for select2
            return;
        }
    });

    // Add datepicker
    $('.wcd-has-datepicker').each(function () {
        $(this).datepicker({
            dateFormat: 'd-m-yy',
        });
    });

    // Add select2
    $('.wcd-has-select2').each(function () {
        $(this).select2();
    });
});