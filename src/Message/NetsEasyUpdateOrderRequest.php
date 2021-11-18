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

    public function sendData($data)
    {
        $path = '/payments/' . $this->getPaymentId() . '/orderitems';

        $httpResponse = $this->httpClient->request(
            'PUT',
            $this->getEndpoint() . $path,
            $this->getHeaders(),
            json_encode($data),
        );

        return new NetsEasyUpdateOrderResponse($this, $this->getResponseBody($httpResponse));
    }
}
