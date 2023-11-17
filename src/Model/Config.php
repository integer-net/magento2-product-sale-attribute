<?php
declare(strict_types=1);

namespace IntegerNet\ProductSaleAttribute\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isAutoGenerationEnabled(int $storeId = 0): bool
    {
        return $this->scopeConfig->isSetFlag(
            'catalog/product_is_sale_attribute/is_autogeneration_enabled',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
