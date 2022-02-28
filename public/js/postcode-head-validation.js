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

    $(document).on('click', 'button.postal-submit', function() {
        /*Your code*/
        //alert("ok");
        var $inputkeyval = $(this).parent().find("input").val();
        //console.log($inputkeyval);

        var data = {
            value: $inputkeyval,
            action: itechka_obj.action,
            security: itechka_obj.security
        };

        $.ajax({
            type: "POST",
            dataType: "json",
            url: itechka_obj.ajax_url,
            data: data,
            success: function(response) {
                //alert("Hi");
                if (response["data"]["exists"]["insert"] == 'windsor') {
                    //alert("hi");
                    //$("#post-code-modal").remove();
                    location.reload();
                    //$(".modal-content").html('<div><div class="success-info"><h3>We deliver to your area and your expected delivery time is between 24 to 48 hours.</h3></div><div class="close-cartback"><a class="btn bg-green proceed" href="' + pageURL + '">Proceed to Cart<span class="fa fa-chevron-right" aria-hidden="true"></span></a></div></div>');
                } else if (response["data"]["exists"]["insert"] == 'ontario') {
                    location.reload();
                    //$(".modal-content").html('<div><div class="success-info"><h3>Due to the high demand on our products, this item is expected to be delivered after (' + getDay + ' ' + getMonth + ', ' + getFullYear + ')</h3></div><div class="close-cartback"><a class="btn bg-green proceed" href="' + pageURL + '">Proceed to Cart<span class="fa fa-chevron-right" aria-hidden="true"></span></a></div></div>');
                } else {
                    //$("#post-code-modal").remove();
                    $("#header-zip-code-form span.error").removeClass("display-hidden");
                }
                //console.log(response);
            },
        });
    });

})(jQuery);