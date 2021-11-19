<?php

namespace Nyehandel\Omnipay\Nets\Message;

/**
 * Nets Easy Checkout Authorize Request
 */
class NetsEasyUpdateOrderRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('paymentId', 'items');

        $data = $this->getOrderData();
        unset($data['currency']);
        unset($data['reference']);

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getPaymentId() . '/orderitems';
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            'PUT',
            $this->getEndpoint(),
            $this->getHeaders(),
            json_encode($data),
        );

        return new NetsEasyUpdateOrderResponse($this, $this->getResponseBody($httpResponse));
    }
}
