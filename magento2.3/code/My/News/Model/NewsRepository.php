<?php
namespace My\News\Model;

use \My\News\Api\Data;
use \My\News\Api\NewsRepositoryInterface;
use \My\News\Model\ResourceModel\News as ResourceNews;
use \My\News\Model\ResourceModel\News\CollectionFactory as ResourceCollectionFactory;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Api\Search\SearchResultInterface;
use \Magento\Framework\Api\Search\SearchResultInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;


class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @var NewsFactory
     */
    private $newsFactory;
    /**
     * @var ResourceNews
     */
    private $resource;
    /**
     * @var ResourceCollectionFactory
     */
    private $resourceCollectionFactory;
    /**
     * @var SearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * NewsRepository constructor.
     * @param NewsFactory $newsFactory
     * @param ResourceNews $resource
     * @param ResourceCollectionFactory $resourceCollectionFactory
     * @param SearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        NewsFactory $newsFactory,
        ResourceNews $resource,
        ResourceCollectionFactory $resourceCollectionFactory,
        SearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->newsFactory = $newsFactory;
        $this->resource = $resource;
        $this->resourceCollectionFactory = $resourceCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }


    /**
     * @param Data\NewsInterface $news
     * @return Data\NewsInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\NewsInterface $news)
    {
        try {
            $this->resource->save($news);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $news;
    }

    /**
     * @param $newsId
     * @return Data\NewsInterface
     * @throws NoSuchEntityException
     */
    public function getById($newsId)
    {
        $news = $this->newsFactory->create();
        $this->resource->load($news, $newsId);
        if (!$news->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $newsId));
        }
        return $news;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Magento\Cms\Model\ResourceModel\Block\Collection $collection */
        $collection = $this->resourceCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param Data\NewsInterface $news
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\NewsInterface $news)
    {
        try {
            $this->resource->delete($news);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $newsId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($newsId)
    {
        return $this->delete($this->getById($newsId));
    }

}