<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Block\Product\View;

class DiscountRequest extends \Magento\Catalog\Block\Product\View
{
    /**
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        return array_merge(parent::getCacheKeyInfo(), ['product_id' => $this->getProduct()->getId()]);
    }
}
