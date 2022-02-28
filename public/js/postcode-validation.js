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
        //alert("hi ok");



        //console.log(itechsin_obj.ajax_url);

        var $thisbutton = $(this);
        var data = {
            value: $("#postal-code-popup").val(),
            action: itechsin_obj.action,
            security: itechsin_obj.security
        };

        var pageURL = $(location).attr("href");
        //alert(pageURL);
        var today = new Date();
        today.setDate(today.getDate() + 15);
        var getDay = today.getDate();
        var getFullYear = today.getFullYear();
        //alert(getFullYear);
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var getMonth = today.getMonth();
        getMonth = monthNames[getMonth];

        $.ajax({
            type: "POST",
            dataType: "json",
            url: itechsin_obj.ajax_url,
            data: data,
            beforeSend: function(response) {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function(response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function(response) {
                if (response["data"]["exists"]["insert"] == 'windsor') {
                    //alert("hi");
                    //$("#post-code-modal").remove();
                    $(".modal-content").html('<div><div class="success-info"><h3>We deliver to your area and your expected delivery time is between 24 to 48 hours.</h3></div><div class="close-cartback"><a class="btn bg-green proceed" href="' + pageURL + '">Proceed to Cart<span class="fa fa-chevron-right" aria-hidden="true"></span></a></div></div>');
                } else if (response["data"]["exists"]["insert"] == 'ontario') {
                    $(".modal-content").html('<div><div class="success-info"><h3>Due to the high demand on our products, this item is expected to be delivered after (' + getDay + ' ' + getMonth + ', ' + getFullYear + ')</h3></div><div class="close-cartback"><a class="btn bg-green proceed" href="' + pageURL + '">Proceed to Cart<span class="fa fa-chevron-right" aria-hidden="true"></span></a></div></div>');
                } else {
                    //$("#post-code-modal").remove();
                    $("#post-code-modal span.error").removeClass("display-hidden");
                }
                //console.log(response);
            },
        });

        return false;
    });

})(jQuery);