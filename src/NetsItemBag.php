<?php
/**
 * Nets Item bag
 */

namespace Nyehandel\Omnipay\Nets;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

/**
 * Class NetsItemBag
 *
 * @package Omnipay\Nets
 */
class NetsItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @see Item
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new NetsItem($item);
        }
    }
}
