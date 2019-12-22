<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Model;

use Emizentech\Countdown\Model\ResourceModel\Item;
use Emizentech\Countdown\Api\ItemRepositoryInterface;

/**
 * Class ItemRepository
 * @package Emizentech\Countdown\Model
 */
class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var Item $item
     */
    protected $item;

    /**
     * @var ItemFactory $itemFactory
     */
    protected $itemFactory;

    /**
     * ItemRepository constructor.
     */
    public function __construct(
        \Emizentech\Countdown\Model\Item $item,
        ItemFactory $itemFactory
    ) {
        $this->item = $item;
        $this->itemFactory = $itemFactory;
    }
    /**
     * Save item data.
     */
    public function save(\Emizentech\Countdown\Api\Data\ItemInterface $item)
    {
        //your code
    }

    /**
     * Retrieve item data.
     */
    public function getById($itemId)
    {
        //your code
    }
    /**
     * Retrieve item data.
     */
    public function getByIp($itemIp)
    {
        $item = $this->itemFactory->create();
        $item->load($itemIp, 'ip');
        if (!$item->getId()) {
            return false;
        }
        return $item;
    }

    /**
     * Delete item.
     */
    public function delete(\Emizentech\Countdown\Api\Data\ItemInterface $item)
    {
        //your code
    }

    /**
     * Delete test by item ID.
     */
    public function deleteById($itemId)
    {
        //your code
    }
}