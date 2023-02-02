<?php

namespace Binstellar\CollectfromStore\Controller\Cart;

/**
 * Class Add
 * @package Binstellar\CollectfromStore\Controller\Cart
 */
class Add extends \Magento\Checkout\Controller\Cart\Add
{
    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    { 
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $params = $this->getRequest()->getParams();
        try {

            if (isset($params['qty'])) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_objectManager
                        ->get(\Magento\Framework\Locale\ResolverInterface::class)->getLocale()]
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                return $this->goBack();
            }

            $cartProducts = $this->_objectManager->create(\Binstellar\CollectfromStore\Helper\Data::class)
                             ->getConfig('collectfromstore/advance/keep_cart_products');
            

            $this->cart->addProduct($product, $params);
            if (!empty($related)) {
                $this->cart->addProductsByIds(explode(',', $related));
            }

            $this->cart->save();

            $this->_eventManager->dispatch(
                'checkout_cart_add_product_complete',
                ['product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse()]
            );

            if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                $baseUrl = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)
                            ->getStore()->getBaseUrl();
                            
                $shoppingCartUrl = $baseUrl.'checkout/cart';


                $this->messageManager->addSuccess(__('You added %1 to your <a href="%2">Shopping cart.</a>',$product->getName(),$shoppingCartUrl));

                return $this->goBack();

            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            if ($this->_checkoutSession->getUseNotice(true)) {
                $this->messageManager->addNotice(
                    $this->_objectManager->get(\Magento\Framework\Escaper::class)->escapeHtml($e->getMessage())
                );
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->messageManager->addError(
                        $this->_objectManager->get(Magento\Framework\Escaper::class)->escapeHtml($message)
                    );
                }
            }
            $url = $this->_checkoutSession->getRedirectUrl(true);
            if (!$url) {
                $cartUrl = $this->_objectManager->get(\Magento\Checkout\Helper\Cart::class)->getCartUrl();
                $url = $this->_redirect->getRedirectUrl($cartUrl);
            }
            return $this->goBack($url);
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
            return $this->goBack();
        }
    }
}
