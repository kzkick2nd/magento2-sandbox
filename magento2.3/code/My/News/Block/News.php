<?php
namespace My\News\Block;

use \Magento\Framework\View\Element\Template;
use \My\News\Model\ResourceModel\News\Collection;
use \My\News\Model\ResourceModel\News\CollectionFactory;
use \My\News\Model\News as Model;

class News extends Template
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;


    /**
     * News constructor.
     * @param CollectionFactory $collectionFactory
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        $collection = $this->collectionFactory->create();

        return $collection;
    }

    /**
     * @param Model $item
     * @return string
     */
    public function getDate(Model $item)
    {
        return $this->formatDate($item->getCreatedAt(), \IntlDateFormatter::SHORT, true);
    }
}
