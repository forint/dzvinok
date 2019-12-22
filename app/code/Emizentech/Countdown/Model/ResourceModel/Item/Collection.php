<?php

namespace Emizentech\Countdown\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection

{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';


    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('Emizentech\Countdown\Model\Item', 'Emizentech\Countdown\Model\ResourceModel\Item');
    }



}