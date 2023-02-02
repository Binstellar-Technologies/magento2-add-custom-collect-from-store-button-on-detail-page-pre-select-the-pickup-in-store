define(
    ['jquery'], function ($) {
    "use strict";
    return function () {
        $(document).ready(function() {
            $('.product-item-actions .actions-primary').css({"display": "inline-block", "margin-bottom": "10px"});
        });
    }
});