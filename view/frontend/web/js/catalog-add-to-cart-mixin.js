define([
    'jquery',
    'mage/translate',
    'underscore',
    'Magento_Catalog/js/product/view/product-ids-resolver'
], function ($, $t, _, idsResolver) {
    'use strict';

    return function (widget) {

    $.widget('mage.catalogAddToCart', widget, {

        /**
         * @param {jQuery} form
         */
        ajaxSubmit: function (form) {
            var self = this,
                productIds = idsResolver(form),
                formData;

            var formAction = form.attr('action');
            
            if(!formAction.includes("collectfromstore")){
                $(self.options.minicartSelector).trigger('contentLoading');
                self.disableAddToCartButton(form);
            }
            
            formData = new FormData(form[0]);

            $.ajax({
                url: formAction,
                data: formData,
                type: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                
                /** @inheritdoc */
                beforeSend: function () {
                    if(formAction.includes("collectfromstore")){
                        $("body").trigger('processStart');
                    }
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStart);
                    }
                },

                /** @inheritdoc */
                success: function (res) {
                    var eventData, parameters;

                    $(document).trigger('ajax:addToCart', {
                        'sku': form.data().productSku,
                        'productIds': productIds,
                        'form': form,
                        'response': res
                    });

                    if(formAction.includes("collectfromstore")){
                        $("body").trigger('processStop');
                    }

                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStop);
                    }

                    if (res.backUrl) {

                        if(!formAction.includes("collectfromstore")){
                            eventData = {
                                'form': form,
                                'redirectParameters': []
                            };
                            // trigger global event, so other modules will be able add parameters to redirect url
                            $('body').trigger('catalogCategoryAddToCartRedirect', eventData);

                            if (eventData.redirectParameters.length > 0) {
                                parameters = res.backUrl.split('#');
                                parameters.push(eventData.redirectParameters.join('&'));
                                res.backUrl = parameters.join('#');
                            }
                        }

                        self._redirect(res.backUrl);

                        return;
                    }

                    if (res.messages) {
                        $(self.options.messagesSelector).html(res.messages);
                    }

                    if (res.minicart) {
                        $(self.options.minicartSelector).replaceWith(res.minicart);
                        $(self.options.minicartSelector).trigger('contentUpdated');
                    }

                    if (res.product && res.product.statusText) {
                        $(self.options.productStatusSelector)
                            .removeClass('available')
                            .addClass('unavailable')
                            .find('span')
                            .html(res.product.statusText);
                    }

                    // Start - Custom code starts to remove Added when clicked on Collect from store
                    if(!formAction.includes("collectfromstore")){
                        $(self.options.minicartSelector).trigger('contentLoading');
                        self.enableAddToCartButton(form);
                    }
                    // Ends - Custom code starts to remove Added when clicked on Collect from store
                },

                /** @inheritdoc */
                error: function (res) {
                    $(document).trigger('ajax:addToCart:error', {
                        'sku': form.data().productSku,
                        'productIds': productIds,
                        'form': form,
                        'response': res
                    });
                },

                /** @inheritdoc */
                complete: function (res) {
                    if (res.state() === 'rejected') {
                        location.reload();
                    }
                }
            });
        }
    });

    return $.mage.catalogAddToCart;
  }
});