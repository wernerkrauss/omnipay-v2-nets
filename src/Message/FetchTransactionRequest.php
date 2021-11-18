<?php

namespace Nyehandel\Omnipay\Nets\Message;

/**
 * Nets Fetch Transaction Request
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        $data = $this->getBaseData();
        $data['METHOD'] = 'GetTransactionDetails';
        $data['TRANSACTIONID'] = $this->getTransactionReference();

        return $data;
    }
}
