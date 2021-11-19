<?php

namespace Nyehandel\Omnipay\Nets\Message;

use Nyehandel\Omnipay\Nets\NetsWebhookBag;
use Omnipay\Common\ItemBag;

/**
 * Nets Easy Checkout Authorize Request
 */
class NetsEasyCreatePaymentRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('items', 'currency', 'termsUrl', 'supportedCustomerTypes', 'externalShippingAddress');

        $data = [
            'order' => $this->getOrderData(),
            'checkout' => [
                'url' => $this->getUrl(),
                'termsUrl' => $this->getTermsUrl(),
                'integrationType' => 'EmbeddedCheckout',
                'consumerType' => $this->getCustomerTypesData(),
                'shipping' => [
                    'enableBillingAddress' => $this->getExternalShippingAddress()
                ]
            ],
        ];

        if ($this->getWebhooks()) {
            $data['notifications'] = $this->getNotificationsData();
        }


        return $data;
    }

    public function setTermsUrl($value)
    {
        return $this->setParameter('termsUrl', $value);
    }

    public function getTermsUrl()
    {
        return $this->getParameter('termsUrl');
    }

    public function setUrl($value)
    {
        return $this->setParameter('url', $value);
    }

    public function getUrl()
    {
        return $this->getParameter('url');
    }

    public function setSupportedCustomerTypes($value)
    {
        return $this->setParameter('supportedCustomerTypes', $value);
    }

    public function getSupportedCustomerTypes()
    {
        return $this->getParameter('supportedCustomerTypes');
    }

    public function setDefaultCustomerType($value)
    {
        return $this->setParameter('defaultCustomerType', $value);
    }

    public function getDefaultCustomerType()
    {
        return $this->getParameter('defaultCustomerType');
    }

    public function setExternalShippingAddress($value)
    {
        return $this->setParameter('externalShippingAddress', $value);
    }

    public function getExternalShippingAddress()
    {
        return $this->getParameter('externalShippingAddress');
    }

    protected function getCustomerTypesData()
    {
        $data = [];
        $supportedCustomerTypes = $this->getSupportedCustomerTypes();

        $data['default'] = $this->getDefaultCustomerType() ?? $supportedCustomerTypes[0];

        foreach ($supportedCustomerTypes as $supportedCustomerType) {
            $data['supportedTypes'][] = $supportedCustomerType;
        }

        return $data;
    }

    protected function getNotificationsData()
    {
        $data = [];
        $webhooks = $this->getWebhooks();

        if ($webhooks) {
            foreach ($webhooks as $webhook) {
                $data['webhooks'][] = [
                    'eventName' => $webhook->getEventName(),
                    'url' => $webhook->getUrl(),
                    'authorization' => $webhook->getAuthorization(),
                ];
            }
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments';
    }


    /**
     * Set the webhooks in this order
     *
     * @param ItemBag|array $items An array of items in this order
     */
    public function setWebhooks($webhooks)
    {
        if ($webhooks && !$webhooks instanceof ItemBag) {
            $webhooks = new NetsWebhookBag($webhooks);
        }

        return $this->setParameter('webhooks', $webhooks);
    }

    public function getWebhooks()
    {
        return $this->getParameter('webhooks');
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            $this->getHeaders(),
            json_encode($data),
        );

        return new NetsEasyCreatePaymentResponse($this, $this->getResponseBody($httpResponse));
    }
}
