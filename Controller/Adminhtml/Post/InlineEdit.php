<?php 

namespace Biglidio\MiniBlog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Biglidio\MiniBlog\Model\Post;
use Biglidio\MiniBlog\Model\PostFactory;
use Biglidio\MiniBlog\Model\ResourceModel\Post as PostResource;

class InlineEdit extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Biglidio_MiniBlog::post_save';

    /** @var JsonFactory */
    protected $jsonFactory;

    /** @var PostFactory */
    protected $postFactory;

    /** @var PostResource */
    protected $postResource;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param PostFactory $postFactory
     * @param PostResource $postResource
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PostFactory $postFactory,
        PostResource $postResource
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
    }

    public function execute()
    {
        $json = $this->jsonFactory->create();
        $messages = [];
        $error = false;
        $isAjax = $this->getRequest()->getParam('isAjax', false);
        $items = $this->getRequest()->getParam('items', []);

        if (!$isAjax || !count($items)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
        }

        if (!$error) {
            foreach ($items as $item) {
                $id = $item['id'];
                try {
                    /** @var Post $post */
                    $post = $this->postFactory->create();
                    $this->postResource->load($post, $id);
                    $post->setData(array_merge($post->getData(), $item));
                    $this->postResource->save($post);
                } catch (\Exception $e) {
                    $messages[] = __("Something went wrong while saving item $id");
                    $error = true;
                }
            }
        }

        return $json->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
