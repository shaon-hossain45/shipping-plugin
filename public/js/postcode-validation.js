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

    $(document).on('click', '#postal-code-confirm', function(e) {
        e.preventDefault();
        alert("hi ok");



        //console.log(itechsin_obj.ajax_url);

        var $thisbutton = $(this);
        var data = {
            value: $("#postal-code-popup").val(),
            action: itechsin_obj.action,
            security: itechsin_obj.security
        };


        $.ajax({
            type: "POST",
            dataType: "json",
            url: itechsin_obj.ajax_url,
            data: data,
            beforeSend: function(response) {
                //$thisbutton.removeClass('added').addClass('loading');
            },
            complete: function(response) {
                //$thisbutton.addClass('added').removeClass('loading');
            },
            success: function(response) {

                // if (response.error && response.product_url) {
                //     window.location = response.product_url;
                //     return;
                // } else {
                //     $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                // }

                if (response["data"]["exists"]["insert"] == 'done') {
                    alert("hi");
                    $("#post-code-modal").remove();
                } else {

                }
                console.log(response);
            },
        });

        return false;
    });

})(jQuery);