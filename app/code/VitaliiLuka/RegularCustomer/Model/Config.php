<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Model;

use Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_VITALII_LUKA_PERSONAL_DISCOUNT_GENERAL_ENABLED
        = 'vitalii_luka_personal_discount/general/enabled';

    public const XML_PATH_VITALII_LUKA_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS
        = 'vitalii_luka_personal_discount/general/allow_for_guests';

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_VITALII_LUKA_PERSONAL_DISCOUNT_GENERAL_ENABLED,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function allowForGuests(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_VITALII_LUKA_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
