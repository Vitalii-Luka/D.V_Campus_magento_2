<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Model;

/**
 * @method int|string|null getDiscountRequestId()
 * @method int|string|null getProductId()
 * @method $this setProductId(int $productId)
 * @method int|string|null getCustomerId()
 * @method $this setCustomerId(int $customerId)
 * @method string|null getName()
 * @method $this setName(string $name)
 * @method string|null getEmail()
 * @method $this setEmail(string $name)
 * @method int|string|null getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 * @method int|string|null getStatus()
 * @method $this setStatus(int $status)
 * @method int|string|null getCreatedAt()
 * @method int|string|null getUpdatedAt()
 */
class DiscountRequest extends \Magento\Framework\Model\AbstractModel
{
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_DECLINED = 3;

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest::class);
    }
}
