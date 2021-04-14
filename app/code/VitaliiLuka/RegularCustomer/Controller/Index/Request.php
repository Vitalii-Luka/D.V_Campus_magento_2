<?php

declare(strict_types=1);

namespace VitaliiLuka\RegularCustomer\Controller\Index;

use VitaliiLuka\RegularCustomer\Model\DiscountRequest;
use Magento\Framework\Controller\Result\Json as JsonResponse;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory;

    private \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \VitaliiLuka\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    private \Magento\Customer\Model\Session $customerSession;

    private \VitaliiLuka\RegularCustomer\Model\Config $config;

    private \Psr\Log\LoggerInterface $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \VitaliiLuka\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \VitaliiLuka\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \VitaliiLuka\RegularCustomer\Model\Config $config
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
        \VitaliiLuka\RegularCustomer\Model\Config $config,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->config = $config;
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
        // @TODO: add Google Recaptcha to the form
        $formSaved = false;

        try {
            if (!$this->config->enabled()) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->customerSession->isLoggedIn()
                && !$this->config->allowForGuests()
            ) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int) $this->customerSession->getCustomerId()
                : null;

            if ($this->customerSession->isLoggedIn()) {
                $name = $this->customerSession->getCustomer()->getName();
                $email = $this->customerSession->getCustomer()->getEmail();
            } else {
                $name = $this->request->getParam('name');
                $email = $this->request->getParam('email');
            }

            $productId = (int) $this->request->getParam('product_id');

            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $discountRequest->setProductId($productId)
                ->setName($name)
                ->setEmail($email)
                ->setCustomerId($customerId)
                ->setWebsiteId((int) $this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setDiscountRequestCustomerName($this->request->getParam('name'));
                $this->customerSession->setDiscountRequestCustomerEmail($this->request->getParam('email'));
                $productIds = $this->customerSession->getDiscountRequestProductIds() ?? [];
                $productIds[] = $productId;
                $this->customerSession->setDiscountRequestProductIds(array_unique($productIds));
            }

            $formSaved = true;
        } catch (\InvalidArgumentException $e) {
            // No need to log form key validation errors
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        $message = $formSaved
            ? __('You request for product %1 was accepted!', $this->request->getParam('productName'))
            : __('Your request can\'t be sent. Please, contact us if you see this message.');

        return $response->setData([
            'message' => $message
        ]);
    }
}
