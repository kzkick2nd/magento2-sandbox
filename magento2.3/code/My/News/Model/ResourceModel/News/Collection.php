<?php
namespace My\News\Model\ResourceModel\News;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'news_id';

    protected function _construct()
    {
        $this->_init(
            'My\News\Model\News',
            'My\News\Model\ResourceModel\News'
        );
    }
}