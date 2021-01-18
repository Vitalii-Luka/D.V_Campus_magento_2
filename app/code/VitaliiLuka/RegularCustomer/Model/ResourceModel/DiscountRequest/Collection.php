<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \VitaliiLuka\RegularCustomer\Model\DiscountRequest::class,
            \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest::class
        );
    }
}
