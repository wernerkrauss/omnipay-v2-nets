<?php

namespace Nyehandel\Omnipay\Nets;

use Omnipay\Common\AbstractGateway;

/**
 * Nets Easy Checkout Class
 */
class NetsEasyCheckoutGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Nets Easy Checkout';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'signature' => '',
            'testMode' => false,
        );
    }

    public function getCheckoutKey()
    {
        return $this->getParameter('checkoutKey');
    }

    public function setCheckoutKey($value)
    {
        return $this->setParameter('checkoutKey', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function createPayment(array $parameters = array())
    {
        return $this->createRequest('\Nyehandel\Omnipay\Nets\Message\NetsEasyCreatePaymentRequest', $parameters);
    }

    public function updateOrder(array $parameters = array())
    {
        return $this->createRequest('\Nyehandel\Omnipay\Nets\Message\NetsEasyUpdateOrderRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nets\Message\NetsEasyPurchaseRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nets\Message\CaptureRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nets\Message\RefundRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nets\Message\FetchTransactionRequest', $parameters);
    }
}
