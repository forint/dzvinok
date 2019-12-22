<?php
namespace Emizentech\Countdown\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Emizentech\Countdown\Model\ResourceModel\Item');
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getDataByKey('id');
    }
    /**
     * @return string
     */
    public function getIp()
    {
        return $this->getDataByKey('ip');
    }

    /**
     * @return string
     */
    public function getVisit()
    {
        return $this->getDataByKey('visit');
    }

    /**
     * @param $ipAddress
     * @return $this
     */
    public function setIp($ipAddress)
    {
        return $this->setData('ip', $ipAddress);
    }

    /**
     * @param $visit
     * @return $this
     */
    public function setVisit($visit)
    {
        return $this->setData('visit', $visit);
    }

}