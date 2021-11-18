<?php
/**
 * Nets Abstract Request
 */

namespace Nyehandel\Omnipay\Nets\Message;

use Omnipay\Common\ItemBag;
use Nyehandel\Omnipay\Nets\NetsItem;
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

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function getSubject()
    {
        return $this->getParameter('subject');
    }

    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }

    public function getSolutionType()
    {
        return $this->getParameter('solutionType');
    }

    public function setSolutionType($value)
    {
        return $this->setParameter('solutionType', $value);
    }

    public function getLandingPage()
    {
        return $this->getParameter('landingPage');
    }

    public function setLandingPage($value)
    {
        return $this->setParameter('landingPage', $value);
    }

    public function getBorderColor()
    {
        return $this->getParameter('borderColor');
    }

    public function setBorderColor($value)
    {
        return $this->setParameter('borderColor', $value);
    }

    public function getBrandName()
    {
        return $this->getParameter('brandName');
    }

    public function setBrandName($value)
    {
        return $this->setParameter('brandName', $value);
    }

    public function setNoShipping($value)
    {
        return $this->setParameter('noShipping', $value);
    }

    public function getAllowNote()
    {
        return $this->getParameter('allowNote');
    }

    public function setAllowNote($value)
    {
        return $this->setParameter('allowNote', $value);
    }

    public function getAddressOverride()
    {
        return $this->getParameter('addressOverride');
    }

    public function getMaxAmount()
    {
        return $this->getParameter('maxAmount');
    }

    public function setMaxAmount($value)
    {
        return $this->setParameter('maxAmount', $value);
    }

    public function getTaxAmount()
    {
        return $this->getParameter('taxAmount');
    }

    public function setTaxAmount($value)
    {
        return $this->setParameter('taxAmount', $value);
    }

    public function getShippingAmount()
    {
        return $this->getParameter('shippingAmount');
    }

    public function setShippingAmount($value)
    {
        return $this->setParameter('shippingAmount', $value);
    }

    public function getHandlingAmount()
    {
        return $this->getParameter('handlingAmount');
    }

    public function setHandlingAmount($value)
    {
        return $this->setParameter('handlingAmount', $value);
    }

    public function getShippingDiscount()
    {
        return $this->getParameter('shippingDiscount');
    }

    public function setShippingDiscount($value)
    {
        return $this->setParameter('shippingDiscount', $value);
    }

    public function setUrl($value)
    {
        return $this->setParameter('url', $value);
    }

    public function getUrl()
    {
        return $this->getParameter('url');
    }

    public function setTermsUrl($value)
    {
        return $this->setParameter('termsUrl', $value);
    }

    public function getTermsUrl()
    {
        return $this->getParameter('termsUrl');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
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

    public function setWebhooks($value)
    {
        return $this->setParameter('webhooks', $value);
    }

    public function getWebhooks()
    {
        return $this->getParameter('webhooks');
    }

    public function setExternalShippingAddress($value)
    {
        return $this->setParameter('externalShippingAddress', $value);
    }

    public function getExternalShippingAddress()
    {
        return $this->getParameter('externalShippingAddress');
    }

    public function setConsumer($value)
    {
        return $this->setParameter('consumer', $value);
    }

    public function getConsumer()
    {
        return $this->getParameter('consumer');
    }

    public function setPaymentId($value)
    {
        return $this->setParameter('paymentId', $value);
    }

    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
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
                    'eventName' => $webhook['eventName'],
                    'url' => $webhook['url'],
                    'authorization' => $webhook['authorization'],
                ];
            }
        }

        return $data;
    }

    protected function setConsumerData($data)
    {
        // TODO: complete this
        $data['checkout']['consumer'] = [
        ];

        $data['checkout']['merchantHandlesConsumerData'] = true;

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
