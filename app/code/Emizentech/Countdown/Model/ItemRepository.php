<?php


namespace Emizentech\Countdown\Model;

use Emizentech\Countdown\Model\ResourceModel\Item;
use Emizentech\Countdown\Api\ItemRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

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
       /* $item = $this->itemFactory->create();
        $this->item->load($item, $itemId);
        if (!$item->getId()) {
            //throw new NoSuchEntityException(__('Item with id "%1" does not exist.', $itemId));
        }
        return $item;*/
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
            //throw new NoSuchEntityException(__('Item with id "%1" does not exist.', $itemIp));
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