<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Api\Data;

/**
 * Interface ItemInterface
 * @package Emizentech\Countdown\Api\Data
 */
interface ItemInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getIp();

    /**
     * @param $ipAddress
     * @return $this
     */
    public function setIp($ipAddress);

    /**
     * @return string
     */
    public function getVisit();

    /**
     * @param $timeVisit
     * @return $this
     */
    public function setVisit($timeVisit);


}