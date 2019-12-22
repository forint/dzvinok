<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Model\ResourceModel;

/**
 * Class Item
 * @package Emizentech\Countdown\Model\ResourceModel
 */
class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init
     */
    protected function _construct()
    {
        $this->_init('emizentech_countdown', 'id');
    }
}