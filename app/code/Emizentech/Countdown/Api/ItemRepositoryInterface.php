<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Api;

/**
 * Interface ItemRepositoryInterface
 * @package Emizentech\Countdown\Api
 */
interface ItemRepositoryInterface
{
    /**
     * Create or update a data
     */
    public function save(\Emizentech\Countdown\Api\Data\ItemInterface $test);

    /**
     * @param $itemId
     * @return mixed
     */
    public function getById($itemId);

    /**
     * @param $itemIpAddress
     * @return mixed
     */
    public function getByIp($itemIpAddress);

    /**
     * Delete item.
     */
    public function delete(\Emizentech\Countdown\Api\Data\ItemInterface $item);

    /**
     * Delete item by ID.
     */
    public function deleteById($itemId);
}