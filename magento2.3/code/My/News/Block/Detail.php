<?php
namespace My\News\Block;

use \Magento\Framework\View\Element\Template;
use \My\News\Model\News;

class Detail extends Template
{
    /**
     * @var News
     */
    private $news;


    /**
     * @param News $item
     * @return string
     */
    public function getDate(News $item)
    {
        return $this->formatDate($item->getCreatedAt(), \IntlDateFormatter::SHORT, true);
    }

    /**
     * @param News $news
     */
    public function setNews(News $news)
    {
        $this->news = $news;
    }

    /**
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }
}
