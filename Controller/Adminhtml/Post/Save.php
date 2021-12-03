<?php

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Biglidio\MiniBlog\Model\ImageUploader;
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

    /** @var ImageUploader */
    protected $imageUploader;

    /**
     * Save constructor.
     * @param Context $context
     * @param PostFactory $postFactory
     * @param PostResource $postResource
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        PostResource $postResource,
        ImageUploader $imageUploader
    ) {
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /** @return Redirect */
    public function execute(): Redirect
    {
        try {
            $data = $this->getRequest()->getPostValue();
            
            /** @var Post $post */
            $post = $this->postFactory->create();

            if ($data['id']) {
                $this->postResource->load($post, $data['id']);
            } else {
                unset($data['id']);
            }

            if (isset($data['cover'][0]['name']) && isset($data['cover'][0]['tmp_name'])) {
                $data['cover'] = $data['cover'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['cover']);
            } elseif (isset($data['cover'][0]['name']) && !isset($data['cover'][0]['tmp_name'])) {
                $data['cover'] = $data['cover'][0]['name'];
            } else {
                $data['cover'] = '';
            }

            $post->setData($data);
            
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
