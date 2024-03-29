<?php

namespace SendGrid\EmailDeliverySimplified\Model;

use \Psr\Log\LoggerInterface;
use \Magento\Framework\Module\Manager;
use SendGrid\EmailDeliverySimplified\Helper\API;
use SendGrid\EmailDeliverySimplified\Helper\Tools;
use SendGrid\EmailDeliverySimplified\Model\GeneralSettings;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;
use \Zend\Mail\Message;

class SendGrid
{

  /**
   * @var \Zend\Mail\Message
   */
    protected $_message;

  /**
   * @var \Psr\Log\LoggerInterface
   */
    protected $_logger;

  /**
   * @var SendGrid\EmailDeliverySimplified\Model\GeneralSettings
   */
    protected $_generalSettings;

  /**
   * @var \Magento\Framework\Module\Manager
   */
    protected $_moduleManager;

  /**
   * @param   Message           $message
   * @param   GeneralSettings   $generalSettings
   * @param   LoggerInterface   $loggerInterface
   * @throws  \InvalidArgumentException
   */
    public function __construct(
        Message          $message,
        GeneralSettings  $generalSettings,
        LoggerInterface  $loggerInterface,
        Manager          $moduleManager
    ) {
        $this->_message         = $message;
        $this->_generalSettings = $generalSettings;
        $this->_logger          = $loggerInterface;
        $this->_moduleManager   = $moduleManager;

        $apikey = $this->_generalSettings->getAPIKey();

        $this->_updateInternalMessage();
        $this->_sent = false;
    }

  /**
   * Updates the message with the settings configured in the model
   *
   * @return void
   */
    private function _updateInternalMessage()
    {
        $from         = trim($this->_generalSettings->getFrom());
        $from_name    = trim($this->_generalSettings->getFromName());
        $reply_to     = trim($this->_generalSettings->getReplyTo());
        $categories   = explode(',', $this->_generalSettings->getCategories());
        $template     = trim($this->_generalSettings->getTemplateID());
        $asm_group_id = trim($this->_generalSettings->getAsmGroupId());

        $xsmtpapi_header['category'] = [ 'magento2_sendgrid_plugin' ];
        foreach ($categories as $category) {
            $xsmtpapi_header['category'][] = trim($category);
        }

        if (! empty($template)) {
            $xsmtpapi_header['filters']['templates']['settings']['enable']      = 1;
            $xsmtpapi_header['filters']['templates']['settings']['template_id'] = $template;
        }

        // asm group id
        if ($asm_group_id != false and $asm_group_id != 0) {
            $xsmtpapi_header['asm_group_id'] = intval($asm_group_id);
        }

        if (! empty($from)) {
            $this->_message->setFrom($from);
        }

        if (! empty($from_name) and ! empty($from)) {
            $this->_message->setFrom($from, $from_name);
        }

        if (! empty($from_name) and empty($from)) {
            $initial_from = $this->_message->getFrom();
            $this->_message->setFrom($initial_from, $from_name);
        }

        if (! empty($reply_to)) {
            $this->_message->setReplyTo($reply_to);
        }
    }

  /**
   * Returns a string with the JSON request for the API from the current message
   *
   * @return string
   */
    private function _getAPIMessage()
    {
        // Model values
        $from         = trim($this->_generalSettings->getFrom());
        $from_name    = trim($this->_generalSettings->getFromName());
        $reply_to     = trim($this->_generalSettings->getReplyTo());
        $categories   = explode(',', $this->_generalSettings->getCategories());
        $template     = trim($this->_generalSettings->getTemplateID());
        $asm_group_id = trim($this->_generalSettings->getAsmGroupId());

        // Default category
        $categories[] = 'magento2_sendgrid_plugin';

        // Message values

        $this->_logger->debug(
            '[SendGrid] ZendMessage '.
            get_class($this->_message). ' : ' .
            print_r(get_class_methods($this->_message),true)
        );

        $recipients = $this->_message->getTo();
        $subject    = trim($this->_message->getSubject());
        $text       = $this->_message->getBody(false);
        $html       = $this->_message->getBody(false);

        if ($text instanceof \Zend_Mime_Part) {
            $text = $text->getRawContent();
        }

        if ($html instanceof \Zend_Mime_Part) {
            $html = $html->getRawContent();
        }

        // If no from field in model, get message from
        if (empty($from)) {
            $from = $this->_message->getFrom();
        }

        // If no reply to field in model, get message reply to
        if (empty($reply_to)) {
            $reply_to = $this->_message->getReplyTo();
        }

        // Initializations
        $mail = new API\Mail();
        $personalization = new API\Personalization();

        // Add To's
        foreach ($recipients as $to) {
            $this->_logger->debug(
                '[SendGrid] ZendMessage '.
                get_class($this->_message).
                $to->getEmail()
            );

            $email = new API\Email(null, $to->getEmail());
            $personalization->addTo($email);
        }

        // Add from with or without name
        if (! empty($from_name)) {
            $email = new API\Email($from_name, $from);
            $mail->setFrom($email);
        } else {
            $email = new API\Email(null, $from);
            $mail->setFrom($email);
        }

        // Plain content
        if (! empty($text)) {
            $content = new API\Content('text/plain', $text);
            $mail->addContent($content);
        }

        // HTML content
        if (! empty($html)) {
            $content = new API\Content('text/html', $html);
            $mail->addContent($content);
        }

        // Reply to
        if (! empty($reply_to)) {
            $email = new API\Email(null, $reply_to);
            $mail->setReplyTo($email);
        }

        // Categories
        foreach ($categories as $category) {
            if (! empty(trim($category))) {
                $mail->addCategory(trim($category));
            }
        }

        // Template ID
        if (! empty($template)) {
            $mail->setTemplateId($template);
        }

        $mail->setSubject($subject);
        $mail->addPersonalization($personalization);

        // asm group id
        if ($asm_group_id != false and $asm_group_id != 0) {
            $asm = new API\ASM();
            $asm->setGroupId(intval($asm_group_id));

            $mail->setASM($asm);
        }

        return $mail->jsonSerialize();
    }

  /**
   * Sets the message
   *
   * @param   Message $message
   * @return  void
   * @throws  \Magento\Framework\Exception\MailException
   */
    public function setInfo(Message $message)
    {

        $this->_message = $message;
        $this->_updateInternalMessage();
    }

  /**
   * Send a mail using this transport
   *
   * @return void
   * @throws \Magento\Framework\Exception\MailException
   */
    public function sendMessage()
    {
        try {
            $this->_logger->debug('[SendGrid] Sending email.');

            $apikey = $this->_generalSettings->getAPIKey();

            if (! $this->_moduleManager->isOutputEnabled('SendGrid_EmailDeliverySimplified')) {
                $this->_logger->debug('[SendGrid] Module is not enabled. Email is sent via vendor Zend Mail.');
                parent::send($this->_message);

                return;
            }

            // Compose JSON payload of email send request
            $payload = $this->_getAPIMessage();

            // Mail send URL
            $url = Tools::SG_API_URL . 'v3/mail/send';

            // Request headers
            $headers = [ 'Authorization' => 'Bearer ' . $apikey ];

            // Send request
            $client = new \Zend_Http_Client($url, [ 'strict' => true ]);

            $response = $client->setHeaders($headers)
                        ->setRawData(json_encode($payload), 'application/json')
                        ->request('POST');

            // Process response
            if (202 != $response->getStatus()) {
                $response = $response->getBody();
                throw new \Exception($response);
            }
        } catch (\Exception $e) {
            $this->_logger->debug('[SendGrid] Error sending email : ' . $e->getMessage());
            throw new MailException(new Phrase($e->getMessage()), $e);
        }
    }

  /**
   * Get message
   *
   * @return string
   */
    public function getMessage()
    {
        return $this->_message;
    }
}
