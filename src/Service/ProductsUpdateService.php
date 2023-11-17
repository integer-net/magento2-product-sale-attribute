<?php
declare(strict_types=1);

namespace IntegerNet\ProductSaleAttribute\Service;

use IntegerNet\ProductSaleAttribute\Model\Config;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class ProductsUpdateService
{
    public const ATTRIBUTE_CODE_IS_SALE        = 'is_sale';

    private ProductCollectionFactory $productCollectionFactory;
    private StoreManagerInterface    $storeManager;
    private ProductResource          $productResource;
    private Config                   $config;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        ProductResource $productResource,
        Config $config
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productResource = $productResource;
        $this->config = $config;
    }

    public function updateIsSaleValues(): void
    {
        foreach ($this->storeManager->getStores(true) as $store) {
            if (!$this->config->isAutoGenerationEnabled((int)$store->getId())) {
                continue;
            }

            foreach ($this->getProductsToCheck($store) as $product) {
                $hasProductSaleAttributeValue = $product->hasData(self::ATTRIBUTE_CODE_IS_SALE);
                $isProductSale = $this->isProductSale($product);
                $wasProductSale = (bool)$product->getData(self::ATTRIBUTE_CODE_IS_SALE);
                if (!$hasProductSaleAttributeValue || ($isProductSale !== $wasProductSale)) {
                    $product->setData(self::ATTRIBUTE_CODE_IS_SALE, $isProductSale);
                    $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_IS_SALE);
                }
            }
        }
    }

    /**
     * @param StoreInterface $store
     * @return array|ProductInterface[]
     */
    private function getProductsToCheck(StoreInterface $store): array
    {
        /** @var ProductCollection $productCollection */
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->setStore($store);
        $productCollection->addWebsiteFilter($store->getWebsiteId());
        $productCollection->addFinalPrice();
        $productCollection->addAttributeToSelect(self::ATTRIBUTE_CODE_IS_SALE);
        return $productCollection->getItems();
    }

    private function isProductSale(ProductInterface $product): bool
    {
        $finalPrice = (float)$product->getFinalPrice();
        $originalPrice = (float)$product->getPrice();
        if (!$finalPrice || !$originalPrice) {
            return false;
        }
        return $finalPrice < $originalPrice;
    }
}
