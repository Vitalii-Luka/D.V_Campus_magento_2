<?php
declare(strict_types=1);

namespace VitaliiLuka\ControllerDemo\Controller\Demo;

use Magento\Framework\Controller\Result\Forward as ForwardResponse;

class Forward implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    private $forwardResponseFactory;

    /**
     * Forward constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
    ) {
        $this->request = $request;
        $this->forwardResponseFactory = $forwardResponseFactory;
    }

    /**
     * @return ForwardResponse
     */
    public function execute(): ForwardResponse
    {
        $forwardResponseFactory = $this->forwardResponseFactory->create();
        return $forwardResponseFactory->setParams(
            [
                    'name' => 'Vitalii',
                    'surname' => 'Luka',
                    'url' => 'https://github.com/Vitalii-Luka/D.V_Campus_magento_2'
                ]
        )->forward('data');
    }
}
