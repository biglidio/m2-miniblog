<?php 

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Biglidio_MiniBlog::post';

    /** @var PageFctory */
    protected $pageFactory;

    /**
     * Index constructor
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        /** @var Page */
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Biglidio_MiniBlog::post');
        $page->getConfig()->getTitle()->prepend(__('Posts'));
        return $page;
    }
}