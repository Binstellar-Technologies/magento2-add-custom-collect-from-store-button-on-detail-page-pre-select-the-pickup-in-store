<?php
namespace Binstellar\CollectfromStore\Helper;

/**
 * Class Data
 * @package Binstellar\CollectfromStore\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;
  
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata
    ) {
        $this->moduleManager = $moduleManager;
        $this->productMetadata = $productMetadata;
        parent::__construct($context);
    }
    
    /**
     * Retrieve config value
     *
     * @return string
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue($config, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Retrieve module status
     *
     * @return bool
     */
    public function isModuleEnable($module)
    {
        return $this->moduleManager->isEnabled($module);
    }
    /**
     * Retrieve magento version
     *
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }
}
