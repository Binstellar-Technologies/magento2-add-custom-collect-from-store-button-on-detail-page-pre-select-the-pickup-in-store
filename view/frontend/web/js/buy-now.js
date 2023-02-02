define([
    'jquery'
], function ($) {
    "use strict";
    return function (config, element) {
        $(element).click(function () {
            var form = $(config.form);
            var baseUrl = form.attr('action');
            var collectfromstoreUrl='';
            if(baseUrl.includes('checkout')){
                collectfromstoreUrl = baseUrl.replace('checkout/cart/add', 'collectfromstore/cart/add');
            }
            if(baseUrl.includes('wishlist')){
                collectfromstoreUrl = baseUrl.replace('wishlist/index/cart', 'collectfromstore/index/cart');
            }
            if(collectfromstoreUrl){
                form.attr('action', collectfromstoreUrl);
            }
            form.trigger('submit');
            form.attr('action', baseUrl);
            return false;
        });
    }
});
