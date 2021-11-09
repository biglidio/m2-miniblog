<?php

namespace Biglidio\MiniBlog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Biglidio\MiniBlog\Model\Post as PostModel;
use Biglidio\MiniBlog\Model\ResourceModel\Post as PostResource;

class Collection extends AbstractCollection
{
    
    public function _construct()
    {
        $this->_init(PostModel::class, PostResource::class);
    }
}