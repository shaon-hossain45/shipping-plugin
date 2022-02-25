(function($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(document).on('click', '.single_add_to_cart_button', function(e) {
        e.preventDefault();

        var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            $pid = $thisbutton.val() || 0;

        var dataForm = $form.serializeArray();
        dataForm.push({ name: 'pid', value: $pid });

        var data = {
            values: JSON.stringify() dataForm,
            action: itechaddc_obj.action,
        };

        /**
         * Ajax start of add to cart
         */
        $.ajax({
            type: "POST",
            dataType: "json",
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function(response) {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function(response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function(response) {

                // if (response.error && response.product_url) {
                //     window.location = response.product_url;
                //     return;
                // } else {
                //     $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                // }

                if (response["success"] == true) {
                    alert("hi");
                    //$(".woocommerce-product-details__short-description").html(response['data']['outputHtml']);
                }
                //console.log(response);
            },
        });

        return false;
    });

})(jQuery);