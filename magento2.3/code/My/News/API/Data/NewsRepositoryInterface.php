<?php
namespace My\News\Api;

use Magento\Framework\Api\SearchCriteriaInterface;


interface NewsRepositoryInterface
{
    /**
     * Save news.
     *
     * @param \My\News\Api\Data\NewsInterface $news
     * @return \My\News\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\NewsInterface $news);

    /**
     * Retrieve news.
     *
     * @param int $blockId
     * @return \My\News\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($newsId);

    /**
     * Retrieve news matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\Search\SearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete news.
     *
     * @param \My\News\Api\Data\NewsInterface $news
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\NewsInterface $news);

    /**
     * Delete news by ID.
     *
     * @param int $newsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($newsId);
}