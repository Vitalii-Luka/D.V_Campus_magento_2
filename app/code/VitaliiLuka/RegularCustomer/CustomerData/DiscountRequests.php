<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\CustomerData;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @return array|void
     */
    public function getSectionData(): ?array
    {
        return [];
    }
}
