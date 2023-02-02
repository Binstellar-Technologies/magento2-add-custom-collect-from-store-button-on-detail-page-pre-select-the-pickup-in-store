<?php
namespace Binstellar\CollectfromStore\Model;

use Magento\Store\Model\ScopeInterface;


class CollectfromStore implements \Binstellar\CollectfromStore\Api\CustomInterface
{

   
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @param  \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getAddress()
    {   
        $storeAddress[] = [
            'storename' => $this->scopeConfig->getValue('carriers/customshipping/storename',ScopeInterface::SCOPE_STORE),
            'storeaddr' => $this->scopeConfig->getValue('carriers/customshipping/storeaddr',ScopeInterface::SCOPE_STORE),
            'storehours' => explode("\r\n", $this->scopeConfig->getValue('carriers/customshipping/storehours',ScopeInterface::SCOPE_STORE))
        ]; 
       return $storeAddress;
        
    }
}
?>
