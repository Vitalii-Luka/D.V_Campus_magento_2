<?php
declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\CustomerData;

use VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    private \Magento\Customer\Model\Session $customerSession;

    private \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory;

    private \VitaliiLuka\RegularCustomer\Model\Config $config;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param \VitaliiLuka\RegularCustomer\Model\Config $config
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \VitaliiLuka\RegularCustomer\Model\Config $config,
        \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getSectionData(): array
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
        /** @var DiscountRequestCollection $discountRequestCollection */
            $discountRequestCollection = $this->discountRequestCollectionFactory->create();
            $discountRequestCollection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
            $productIds = $discountRequestCollection->getColumnValues('product_id');
            $productIds = array_unique($productIds);
            $productIds = array_values(array_map('intval', $productIds));
        } else {
            $productIds = (array) $this->customerSession->getDiscountRequestProductIds();
        }

        return [
            'name' => $name,
            'email' => $email,
            'productIds' => $productIds,
            'isLoggedIn' => $this->customerSession->isLoggedIn(),
            'allowForGuests' => $this->config->allowForGuests()
        ];
    }
}
