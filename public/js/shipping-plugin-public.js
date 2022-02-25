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

    $(document).ready(function() {
        // Close modal on button click
        $(document).on("click", '#close-add-to-cart', function() {
            alert("hide");
            $("#add-to-cart-modal").remove();
        });
    });

    $(document).on("input keypress", "input[maxlength]", function(e) {
        var $input = $(e.currentTarget);
        if ($input.val().length <= ($input.attr("maxlength") - 1)) {
            $("#postal-code-confirm").attr("disabled", "disabled");
        } else {
            $("#postal-code-confirm").removeAttr("disabled");
        }
    });


})(jQuery);