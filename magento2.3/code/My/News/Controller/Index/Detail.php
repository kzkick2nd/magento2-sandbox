<?php
namespace My\News\Controller\Index;

use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use \My\News\Model\News;
use \My\News\Model\NewsFactory;

class Detail extends Action
{

    /**
     * @var NewsFactory
     */
    private $newsFactory;

    /**
     * Detail constructor.
     * @param NewsFactory $newsFactory
     * @param Context $context
     */
    public function __construct(
        NewsFactory $newsFactory,
        Context $context
    ) {
        $this->newsFactory = $newsFactory;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $id = trim($this->getRequest()->getParam('id', null));

        if(!$this->validateId($id)) {
            $this->messageManager->addErrorMessage(__('Invalid news id was given.'));
            $this->_redirect('mynews/index');
        } else {
            /** @var News $news */
            $news = $this->loadNews($id);

            if(!$news->getId()) {
                $this->messageManager->addErrorMessage(__('No such news data.'));
                $this->_redirect('mynews/index');
            } else {
                $this->_view->loadLayout();

                /** @var \My\News\Block\Detail $block */
                $block = $this->_view->getLayout()->getBlock('mynews');
                $block->setNews($news);

                $this->_view->renderLayout();
            }
        }


    }

    /**
     * @param $id
     * @return bool
     */
    private function validateId($id)
    {
        if(!preg_match('/(\d)*/', $id)) {
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function loadNews($id)
    {
        $news = $this->newsFactory->create();
        $news->load($id);

        return $news;
    }
}