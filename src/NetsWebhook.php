<?php
/**
 * Nets Webhook
 */

namespace Nyehandel\Omnipay\Nets;

use Omnipay\Common\Item;

/**
 * Class NetsWebhook
 *
 * @package Omnipay\Nets
 */
class NetsWebhook extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getEventName()
    {
        return $this->getParameter('eventName');
    }

    /**
     * Set the webhook eventName
     */
    public function setEventName($value)
    {
        return $this->setParameter('eventName', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->getParameter('url');
    }

    /**
     * Set the webhook url
     */
    public function setUrl($value)
    {
        return $this->setParameter('url', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorization()
    {
        return $this->getParameter('authorization');
    }

    /**
     * Set the webhook authorization
     */
    public function setAuthorization($value)
    {
        return $this->setParameter('authorization', $value);
    }
}
