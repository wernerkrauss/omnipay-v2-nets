<?php

namespace Nyehandel\Omnipay\Nets\Message;

/**
 * Nets Easy Checkout Authorize Request
 */
class NetsEasyFullChargePaymentRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('paymentId', 'amount');

        return [
            'amount' => $this->getAmount()
        ];
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getPaymentId() . '/charges';
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            $this->getHeaders(),
            json_encode($data),
        );

        return new NetsEasyFullChargePaymentResponse(
            $this,
            $this->getResponseBody($httpResponse),
            $httpResponse->getStatusCode()
        );
    }
}
