<?php
/**
 * --------------------------------------------------------------------------------
 * Payment Plugin - Paymill
 * --------------------------------------------------------------------------------
 * @package     Joomla 2.5 -  3.x
 * @subpackage  J2Store
 * @author      Paymill
 * @copyright   Copyright (c) Paymill
 * @license     GNU/GPL license: http://www.gnu.org/licenses/gpl-2.0.html
 * --------------------------------------------------------------------------------
 *
 * */

namespace Paymill\Models\Response;
// No direct access
defined('_JEXEC') or die('Restricted access');
/**
 * Webhook Model
 * With webhooks we give you the possibility to react automatically to certain events which happen within our system.
 * A webhook is basically a URL where we send an HTTP POST request to, every time one of the events attached to that
 * webhook is triggered. Alternatively you can define an email address where we send the event’s information to
 * You can manage your webhooks via the API as explained below or you can use the web interface inside our cockpit.
 * @tutorial https://paymill.com/de-de/dokumentation/referenz/api-referenz/#document-webhooks
 */
class Webhook extends Base
{
    /**
     * @var string
     */
    private $_url = null;

    /**
     * @var string
     */
    private $_email = null;

    /**
     * @var boolean
     */
    private $_livemode;

    /**
     * @var array
     */
    private $_eventTypes;

    /**
     * Returns the webhook url
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets the webhook url
     * @param string $url
     * @return \Paymill\Models\Response\Webhook
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * Returns the livemode flag of the webhook
     * @return boolean
     */
    public function getLivemode()
    {
        return $this->_livemode;
    }

    /**
     * Sets the livemode flag of the webhook
     * @param boolean $livemode
     * @return \Paymill\Models\Response\Webhook
     */
    public function setLivemode($livemode)
    {
        $this->_livemode = $livemode;
        return $this;
    }

    /**
     * Returns the event types as an array
     * @return array
     */
    public function getEventTypes()
    {
        return $this->_eventTypes;
    }

    /**
     * Sets the event types for the webhook.
     * There are a number of events you can react to. Each webhook can be configured to catch any kind of event
     * individually, so you can create different webhooks for different events. Each Webhook needs to be attached
     * to at least one event. For example the event subscription.succeeded is triggered every time a successful
     * transaction has been made in our system that is based on a subscription. Shortly after that has been triggered,
     * we will call every webhook you defined for this event and send detailed information to it.
     * @tutorial https://paymill.com/de-de/dokumentation/referenz/api-referenz/#document-webhooks
     * @param array $eventTypes
     * @return \Paymill\Models\Response\Webhook
     */
    public function setEventTypes($eventTypes)
    {
        $this->_eventTypes = $eventTypes;
        return $this;
    }

    /**
     * Returns the email registered for this webhook
     * @return string||null
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the email for the webhook.
     * @param string $email Instead of setting the url parameter you can set the email parameter to create a webhook,
     *  where we send mails to in case of an event.
     * @return \Paymill\Models\Response\Webhook
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

}