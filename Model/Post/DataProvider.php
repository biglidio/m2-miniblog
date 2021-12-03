<?php
 
namespace Biglidio\MiniBlog\Model\Post;
 
use Biglidio\MiniBlog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;

    /** @var StoreManagerInterface */
    protected $storeManager;
 
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
 
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            if (!empty($item['cover'])) {
                $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $this->loadedData[$item->getId()]['cover'] = array(
                    array(
                        'name'  =>  $item['cover'],
                        'url'   =>  $mediaUrl.'miniblog/post/cover/'.$item['cover']
                    )
                );
            }
        }
        
        return $this->loadedData;
    }
}
