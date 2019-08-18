<?php
namespace My\Example\Block;

use \Magento\Framework\View\Element\Template;

class Message extends Template
{
    /**
     * config value path for custom message
     */
    const XML_CONFIG_MESSAGE_PATH = 'myextension/message/message';
    /**
     * config value path for custom message enabling flag
     */
    const XML_CONFIG_MESSAGE_ENABLE_PATH = 'myextension/message/enable';

    /**
     * retrieve custom message from config data
     *
     * @return mixed
     */
    public function getCustomMessage()
    {
        return $this->_scopeConfig->getValue(self::XML_CONFIG_MESSAGE_PATH);
    }

    /**
     * retrieve custom message is enabled or not
     *
     * @return mixed
     */
    public function isEnable()
    {
        return $this->_scopeConfig->getValue(self::XML_CONFIG_MESSAGE_ENABLE_PATH);
    }
}