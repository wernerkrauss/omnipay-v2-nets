<?php

namespace Nyehandel\Omnipay\Nets\Message;

/**
 * Nets Easy Checkout Authorize Request
 */
class NetsEasyRetrievePaymentRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('paymentId');

        return [];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getPaymentId();
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            'GET',
            $this->getEndpoint(),
            $this->getHeaders(),
        );

        return new NetsEasyRetrievePaymentResponse(
            $this,
            $this->getResponseBody($httpResponse),
            $httpResponse->getStatusCode()
        );
    }
}
