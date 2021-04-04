<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\CustomerData;

use VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     */
    private $discountRequestCollectionFactory;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
    }

    /**
     * @return array|void
     */
    public function getSectionData(): ?array
    {
        $name = (string) $this->customerSession->getDiscountRequestCustomerName();
        $email = (string) $this->customerSession->getDiscountRequestCustomerEmail();

        if ($this->customerSession->isLoggedIn()) {
            if (!$name) {
                $name = $this->customerSession->getCustomer()->getName();
            }

            if (!$email) {
                $email = $this->customerSession->getCustomer()->getEmail();
            }

            $customerName = $this->customerSession->getCustomer()->getName();
            $customerEmail = $this->customerSession->getCustomer()->getEmail();

            /** @var DiscountRequestCollection $discountRequestCollection */
            $discountRequestCollection = $this->discountRequestCollectionFactory->create();
            $discountRequestCollection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
            $productIds = $discountRequestCollection->getColumnValues('product_id');
        } else {
            $productIds = $this->customerSession->getDiscountRequestProductIds();
        }

        return [
            'name' => $name,
            'email' => $email,
            'productIds' => $productIds
        ];
    }
}
