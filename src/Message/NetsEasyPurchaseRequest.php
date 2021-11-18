<?php

namespace Nyehandel\Omnipay\Nets\Message;


/**
 * Nets Pro Purchase Request
 */
class NetsEasyPurchaseRequest extends NetsEasyCreatePaymentRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['PAYMENTACTION'] = 'Sale';

        return $data;
    }
}
