<?php
declare(strict_types=1);

namespace VitaliiLuka\ControllerDemo\Block;

class Info extends \Magento\Framework\View\Element\Template
{
    /**
     * @return String
     */
    public function getName(): string
    {
        return (string)$this->getRequest()->getParam('name');
    }

    /**
     * @return String
     */
    public function getSurname(): string
    {
        return (string)$this->getRequest()->getParam('surname');
    }

    /**
     * @return String
     */
    public function getRepo(): string
    {
        return (string)$this->getRequest()->getParam('url');
    }
}
