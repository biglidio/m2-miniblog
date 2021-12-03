<?php
namespace Biglidio\MiniBlog\Block\Post;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Biglidio\MiniBlog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class View extends Template
{
    /** @var PostCollectionFactory */
    protected $postCollectionFactory;

    /** @var UserCollectionFactory */
    protected $userCollectionFactory;

    /** @var StoreManagerInterface */
    protected $storeManager;
 
	public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        UserCollectionFactory $userCollectionFactory,
        StoreManagerInterface $storeManager
    )
    {
		parent::__construct($context);
        $this->postCollectionFactory = $postCollectionFactory;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->storeManager = $storeManager;
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
    
    public function getCoverUrl($coverName)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $coverUrl = $mediaUrl . 'miniblog/post/cover/' . $coverName;
        return $coverUrl;
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