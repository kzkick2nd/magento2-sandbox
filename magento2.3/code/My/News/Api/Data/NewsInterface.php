<?php
namespace My\News\Api\Data;

interface NewsInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const NEWS_ID = 'news_id';

    /**
     * @return mixed
     */
    public function getNewsId();

    /**
     * @param $newsId
     * @return mixed
     */
    public function setNewsId($newsId);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param $content
     * @return mixed
     */
    public function setContent($content);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt);
}