<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Controller\View;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    private \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory;

    private \VitaliiLuka\RegularCustomer\Model\Config $config;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory
     * @param \VitaliiLuka\RegularCustomer\Model\Config $config
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory,
        \VitaliiLuka\RegularCustomer\Model\Config $config,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->pageResponseFactory = $pageResponseFactory;
        $this->forwardFactory = $forwardFactory;
        $this->config = $config;
        $this->customerSession = $customerSession;
    }

    /**
     * Check customer authentication for some actions
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->config->enabled()) {
            $resultForward = $this->forwardFactory->create();

            return $resultForward->forward('noroute');
        }

        return $this->pageResponseFactory->create();
    }
}
