<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Model\ResourceModel;

class DiscountRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('vitalii_luka_regular_customer_request', 'discount_request_id');
    }
}
