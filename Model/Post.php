<?php

namespace Biglidio\MiniBlog\Model;

use Magento\Framework\Model\AbstractModel;
use Biglidio\MiniBlog\Model\ResourceModel\Post as PostResourceModel;

class Post extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(PostResource::class);
    }
}