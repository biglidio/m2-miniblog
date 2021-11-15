<?php

namespace Biglidio\MiniBlog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Biglidio\MiniBlog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

class Index extends Action
{
    /** @var PostCollectionFactory */
    protected $postCollectionFactory;

	public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory
    )
    {
        $this->postCollectionFactory = $postCollectionFactory;
		parent::__construct($context);
	}
    
    public function execute()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $id = $request->getParam('id');
        
        $post = $this->postCollectionFactory->create()
        ->addFieldToFilter('is_published', 1)
        ->addFieldToFilter('id', $id)
        ->getFirstItem();
        
        if (!$id || !$post->getId()) {

            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $redirect->setUrl('/miniblog');
        }

        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->getConfig()->getTitle()->set($post->getTitle());
        return $page;
    }
}
