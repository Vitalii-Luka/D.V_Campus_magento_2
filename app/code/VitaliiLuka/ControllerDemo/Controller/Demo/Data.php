<?php
declare(strict_types=1);

namespace VitaliiLuka\ControllerDemo\Controller\Demo;

use Magento\Framework\View\Result\Page as PageResponse;

class Data implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private $pageResponseFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
    }

    /**
     * https://vitalii-luka.local/dv-campus-2020-2021/demo/data
     * Page file name: vitaliiluka_controller_demo_demo_data.xml
     * @return PageResponse
     */
    public function execute(): PageResponse
    {
        return $this->pageResponseFactory->create();
    }
}
