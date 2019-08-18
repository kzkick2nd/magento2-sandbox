<?php
namespace My\News\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class News extends AbstractDb
{
    protected $_idFieldName = 'news_id';

    protected function _construct()
    {
        $this->_init('my_news', $this->_idFieldName);
    }
}
