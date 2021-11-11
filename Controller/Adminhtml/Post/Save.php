<?php

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Biglidio\MiniBlog\Model\Post;
use Biglidio\MiniBlog\Model\PostFactory;
use Biglidio\MiniBlog\Model\ResourceModel\Post as PostResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Biglidio_MiniBlog::post_save';

    /** @var PostFactory */
    protected $postFactory;

    /** @var PostResource */
    protected $postResource;

    /**
     * Save constructor.
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

            if (!$id) {
                $this->postResource->load($post, $id);
            }

            $post->setData([
                'id'            => $id,
                'title'         => $this->getRequest()->getParam('title'),
                'content'       => $this->getRequest()->getParam('content'),
                'author_id'     => $this->getRequest()->getParam('author_id'),
                'is_published'  => $this->getRequest()->getParam('is_published'),
                'tags'          => $this->getRequest()->getParam('tags'),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);

            // echo '<pre>';
            // print_r($post->getData());
            // exit();

            if ($this->postResource->save($post)) {
                $this->messageManager->addSuccessMessage(__('The record has been saved.'));
            } else {
                $this->messageManager->addErrorMessage(__('The record was not saved.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
