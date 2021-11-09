<?php

namespace Biglidio\MiniBlog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    /** @var string Main table name */
    const MAIN_TABLE = 'biglidio_miniblog_post';

    /** @var string Main table primary key field name */
    const ID_FIELD_NAME = 'id';
    
    protected $_isPkAutoIncrement = true;

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}