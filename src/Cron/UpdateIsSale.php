<?php
declare(strict_types=1);

namespace IntegerNet\ProductSaleAttribute\Cron;

use IntegerNet\ProductSaleAttribute\Service\ProductsUpdateService;

class UpdateIsSale
{
    private ProductsUpdateService $productUpdateService;

    public function __construct(
        ProductsUpdateService $productUpdateService
    ) {
        $this->productUpdateService = $productUpdateService;
    }

    public function execute(): void
    {
        $this->productUpdateService->updateIsSaleValues();
    }
}
