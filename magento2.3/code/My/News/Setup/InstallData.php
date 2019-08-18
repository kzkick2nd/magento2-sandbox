<?php
namespace My\News\Setup;

use \Magento\Framework\Setup\InstallDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * Install Data
     *
     * @param ModuleDataSetupInterface $setup Module Data Setup
     * @param ModuleContextInterface $context Module Context
     *
     * @return void
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $data = [
            ['記事1', 'これは記事1'],
            ['記事2', 'これは記事2'],
            ['記事3', 'これは記事3'],
            ['記事4', 'これは記事4'],
            ['記事5', 'これは記事5'],
            ['記事6', 'これは記事6'],
            ['記事7', 'これは記事7'],
            ['記事8', 'これは記事8'],
            ['記事9', 'これは記事9'],
            ['記事10', 'これは記事10']

        ];


        $connection = $setup->getConnection();
        $table = $setup->getTable('my_news');

        foreach ($data as $row) {
            $bind = [
                'title' => $row[0],
                'content' => $row[1]
            ];
            $connection->insertOnDuplicate($table, $bind);
        }
    }
}
