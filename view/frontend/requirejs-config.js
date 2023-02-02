var config = {
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Binstellar_CollectfromStore/js/catalog-add-to-cart-mixin': true
            },
        }
    },
    map: {
     '*': {
      'Magento_Checkout/js/model/checkout-data-resolver': 'Binstellar_CollectfromStore/js/model/checkout-data-resolver'
    }
    }
};