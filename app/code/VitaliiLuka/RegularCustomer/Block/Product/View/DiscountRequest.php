<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Block\Product\View;


class DiscountRequest extends \Magento\Catalog\Block\Product\View
{
    /**
     *
     */
    protected function _construct(): void
    {
        parent::_construct();

        $this->addData(
            [
                'cache_lifetime' => 86400,
                'cache_tags' => [
                    \Magento\Catalog\Model\Product::CACHE_TAG
                ]
            ]
        );
    }

    /**
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        return array_merge(parent::getCacheKeyInfo(), ['product_id' => $this->getProduct()->getId()]);
    }
}
