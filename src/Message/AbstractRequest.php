<?php
/**
 * Nets Abstract Request
 */

namespace Nyehandel\Omnipay\Nets\Message;

use Omnipay\Common\ItemBag;
use Nyehandel\Omnipay\Nets\NetsItemBag;
use Psr\Http\Message\ResponseInterface;

/**
 * Nets Abstract Request
 *
 * This class forms the base class for Nets Easy Checkout requests.
 *
 * @link https://nets-devs.isotop.se/nets-easy/en-EU/docs/
 * @link http://paypal.github.io/sdk/
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v1';

    protected $liveEndpoint = 'https://api.dibspayment.eu/' . self::API_VERSION;
    protected $testEndpoint = 'https://test.api.dibspayment.eu/' . self::API_VERSION;

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

    public function setPaymentId($value)
    {
        return $this->setParameter('paymentId', $value);
    }

    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    protected function getBaseData()
    {
        return [];
    }

    protected function getOrderData()
    {
        $data = [];
        $items = $this->getItems();

        $data['amount'] = 0;
        $data['currency'] = $this->getCurrency();
        $data['reference'] = $this->getReference();

        if ($items) {
            foreach ($items as $item) {
                $grossTotalAmount = $item->getGrossTotalAmount();
                $data['items'][] = [
                    'reference' => $item->getSku(),
                    'name' => $item->getName(),
                    'quantity' => $item->getQuantity(),
                    'unit' => $item->getUnit(),
                    'unitPrice' => $item->getPrice(),
                    'taxRate' => $item->getTaxRate(),
                    'taxAmount' => $item->getTaxAmount(),
                    'netTotalAmount' => $item->getNetTotalAmount(),
                    'grossTotalAmount' => $grossTotalAmount,
                ];

                $data['amount'] += $grossTotalAmount;
            }
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), [], http_build_query($data));

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function getResponseBody(ResponseInterface $response): array
    {
        try {
            return \json_decode($response->getBody()->getContents(), true);
        } catch (\TypeError $exception) {
            return [];
        }
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function getHeaders()
    {
        return [
            'content-type' => 'application/json',
            'Authorization' => $this->getSecretKey(),
        ];
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    /**
     * Set the items in this order
     *
     * @param ItemBag|array $items An array of items in this order
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new NetsItemBag($items);
        }

        return $this->setParameter('items', $items);
    }
}
