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

    $(document).on('keydown', 'input', function() {
        /*Your code*/

        var $inputkeyval = $('#postal-code-popup').val();

        var data = {
            value: $inputkeyval,
            action: itechk_obj.action,
            security: itechk_obj.security
        };

        $.ajax({
            type: "POST",
            dataType: "json",
            url: itechk_obj.ajax_url,
            data: data,
            success: function(response) {

                if (response["data"]["exists"]["insert"] != 'done') {
                    $("#post-code-modal span.error").removeClass("display-hidden");
                } else if (response["data"]["exists"] == '') {
                    $("#post-code-modal span.error").removeClass("display-hidden");
                } else {
                    $("#post-code-modal span.error").addClass("display-hidden");
                }
                //console.log(response);
            },
        });
    });

})(jQuery);