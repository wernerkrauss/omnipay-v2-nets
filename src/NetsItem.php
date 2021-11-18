<?php
/**
 * Nets Item
 */

namespace Nyehandel\Omnipay\Nets;

use Omnipay\Common\Item;

/**
 * Class NetsItem
 *
 * @package Omnipay\Nets
 */
class NetsItem extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getSku()
    {
        return $this->getParameter('sku');
    }

    /**
     * Set the item sku
     */
    public function setSku($value)
    {
        return $this->setParameter('sku', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getUnit()
    {
        return $this->getParameter('unit');
    }

    /**
     * Set the item unit
     */
    public function setUnit($value)
    {
        return $this->setParameter('unit', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getTaxRate()
    {
        return $this->getParameter('taxRate');
    }

    /**
     * Set the item unit
     */
    public function setTaxRate($value)
    {
        return $this->setParameter('taxRate', $value);
    }


    public function getTaxAmount(): int
    {
        return (int) $this->getPrice() * $this->getTaxRate() * $this->getQuantity() / (100 * 100);
    }

    public function getNetTotalAmount(): int
    {
        return (int) $this->getPrice() * $this->getQuantity();
    }

    public function getGrossTotalAmount(): int
    {
        return $this->getNetTotalAmount() + $this->getTaxAmount();
    }
}
