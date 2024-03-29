<?php
/**
 * This helper builds the request body for a /mail/send API call.
 *
 * PHP version 5.3
 *
 * @author    Elmer Thomas <dx@sendgrid.com>
 * @copyright 2016 SendGrid
 * @license   https://opensource.org/licenses/MIT The MIT License
 * @version   GIT: <git_id>
 * @link      http://packagist.org/packages/sendgrid/sendgrid
 */
namespace SendGrid\EmailDeliverySimplified\Helper\API;

class TrackingSettings implements \JsonSerializable
{
    private $click_tracking;
    private $open_tracking;
    private $subscription_tracking;
    private $ganalytics;

    public function setClickTracking($click_tracking)
    {
        $this->click_tracking = $click_tracking;
    }

    public function getClickTracking()
    {
        return $this->click_tracking;
    }

    public function setOpenTracking($open_tracking)
    {
        $this->open_tracking = $open_tracking;
    }

    public function getOpenTracking()
    {
        return $this->open_tracking;
    }

    public function setSubscriptionTracking($subscription_tracking)
    {
        $this->subscription_tracking = $subscription_tracking;
    }

    public function getSubscriptionTracking()
    {
        return $this->subscription_tracking;
    }

    public function setGanalytics($ganalytics)
    {
        $this->ganalytics = $ganalytics;
    }

    public function getGanalytics()
    {
        return $this->ganalytics;
    }

    public function jsonSerialize()
    {
        return array_filter(
            [
                'click_tracking'        => $this->getClickTracking(),
                'open_tracking'         => $this->getOpenTracking(),
                'subscription_tracking' => $this->getSubscriptionTracking(),
                'ganalytics'            => $this->getGanalytics()
            ],
            function ($value) {
                return $value !== null;
            }
        ) ?: null;
    }
}
