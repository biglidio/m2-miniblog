<?php

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Biglidio\MiniBlog\Model\Post;
use Biglidio\MiniBlog\Model\PostFactory;
use Biglidio\MiniBlog\Model\ResourceModel\Post as PostResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Biglidio_MiniBlog::post_delete';

    /** @var PostFactory */
    protected $postFactory;

    /** @var PostResource */
    protected $postResource;

    /**
     * Delete constructor.
     * @param Context $context
     * @param PostFactory $postFactory
     * @param PostResource $postResource
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        PostResource $postResource
    ) {
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Post $post */
            $post = $this->postFactory->create();
            $this->postResource->load($post, $id);
            if ($post->getId()) {
                $this->postResource->delete($post);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('The record does not exist.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
