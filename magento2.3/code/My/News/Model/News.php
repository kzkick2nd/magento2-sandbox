<?php
namespace My\News\Model;

use \Magento\Framework\Model\AbstractModel;

class News extends AbstractModel
{
    /**
     * cache tag
     */
    const CACHE_TAG = 'my_news';

    /**
     * @var string
     */
    protected $_cacheTag = 'my_news';

    /**
     * @var string
     */
    protected $_eventPrefix = 'my_news';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(
            'My\News\Model\ResourceModel\News'
        );
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @param $title
     * @return News
     */
    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->getData('content');
    }

    /**
     * @param $content
     * @return News
     */
    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @param $createAt
     * @return News
     */
    public function setCreatedAt($createAt)
    {
        return $this->setData('created_at', $createAt);
    }
}