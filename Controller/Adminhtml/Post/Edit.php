<?php

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Biglidio_MiniBlog::post_save';
    
    /** @var PageFactory */
    protected $pageFactory;

    /**
     * Edit constructor
     *
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
    
    /** @return Page */
    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Biglidio_MiniBlog::post');
        $page->getConfig()->getTitle()->prepend(__('Edit Post'));
        return $page;
    }
}
