<?php

namespace Nyehandel\Omnipay\Nets\Message;

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

        if ($this->getConsumer()) {
            $data = $this->setConsumerData($data);
        }

        if ($this->getWebhooks()) {
            $data['notifications'] = $this->getNotificationsData();
        }

        return $data;
    }

    public function sendData($data)
    {
        $path = '/payments';
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint() . $path,
            $this->getHeaders(),
            json_encode($data),
        );

        return new NetsEasyCreatePaymentResponse($this, $this->getResponseBody($httpResponse));
    }
}
