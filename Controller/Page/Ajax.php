<?php
namespace Hunters\SearchShopMap\Controller\Page;

use Magento\Framework\Controller\ResultFactory;
use Hunters\SearchShopMap\Service\SearchZip;

class Ajax extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\Page $resultPage */
    /** @var \Magento\Framework\Controller\Result\Raw $response */
    private $searchZip;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\View\Result\PageFactory $resultFactory,
        SearchZip $searchZip
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->resultFactory = $resultFactory;
        $this->searchZip = $searchZip;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $response->setHeader('Content-type', 'text/plain');
        if ($this->getRequest()->isAjax()) {
            $post = $this->getRequest()->getPost();
            $addres = $this->searchZip->getApiGoogle($post['zip']);
            $response->setContents(
                $this->jsonHelper->jsonEncode(
                    [
                        'loc' => $addres,
                    ]
                )
            );
        }
        return $response;
    }
}