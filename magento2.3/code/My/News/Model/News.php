<?php
namespace My\News\Model;

use \Magento\Framework\Model\AbstractModel;
use \My\News\Api\Data\NewsInterface;

class News extends AbstractModel implements NewsInterface
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
    public function getNewsId()
    {
        return $this->getData('news_id');
    }

    /**
     * @param $newsId
     * @return $this|mixed
     */
    public function setNewsId($newsId)
    {
        $this->setData('news_id', $newsId);
        return $this;
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
    public function setCreatedAt($createdAt)
    {
        return $this->setData('created_at', $createdAt);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    /**
     * @param $updatedAt
     * @return mixed|News
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData('updated_at', $updatedAt);
    }
}