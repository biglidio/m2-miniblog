<?php
namespace Biglidio\MiniBlog\Block\Post;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Biglidio\MiniBlog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;

class View extends Template
{
    /** @var PostCollectionFactory */
    protected $postCollectionFactory;

    /** @var UserCollectionFactory */
    protected $userCollectionFactory;

	public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        UserCollectionFactory $userCollectionFactory
    )
    {
		parent::__construct($context);
        $this->postCollectionFactory = $postCollectionFactory;
        $this->userCollectionFactory = $userCollectionFactory;
	}

	public function getPosts()
	{
        $posts = $this->postCollectionFactory->create();
        $posts->addFieldToFilter('is_published', 1);
        return $posts;
	}

    public function getAuthorName($author_id)
    {
        $author = $this->userCollectionFactory->create()->addFieldToFilter('user_id', $author_id);
        $author = $author->getFirstItem();
        return $author->getFirstname() . ' ' . $author->getLastname();
    }
    
	public function getPost()
	{
        /** @var Request $request */
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $post = $this->postCollectionFactory->create()
            ->addFieldToFilter('is_published', 1)
            ->addFieldToFilter('id', $id)
            ->getFirstItem();
        return $post;
	}
}