<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use VitaliiLuka\RegularCustomer\Model\DiscountRequest;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;

    /**
     * @var \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private $discountRequestResource;

    /**
     * @var \VitaliiLuka\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     */
    private $discountRequestFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \VitaliiLuka\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \VitaliiLuka\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Customer\Model\Session $customerSession,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
    }

    /**
     * https://vitalii-luka.local/discount-request/index/request
     *
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        // @TODO: pass message via notifications, not alert
        // @TODO: add form key validation and hideIt validation
        // @TODO: add Google Recaptcha to the form

        try {
            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId() ? (int) $this->customerSession->getCustomerId() : null;
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $discountRequest->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                ->setCustomerId($customerId)
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for product %1 was accepted!', $this->request->getParam('productName'));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
