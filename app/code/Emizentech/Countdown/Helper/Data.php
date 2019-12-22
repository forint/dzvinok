<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Helper;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package Emizentech\Countdown\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * Data constructor.
     * @param Context $context
     * @param Session $session
     */
    public function __construct(
        Context $context,
        Session $session
    )
    {
        parent::__construct($context);
        $this->_session = $session;
    }

    /**
     * Retrieve ip remote address
     * @return mixed
     */
    public function getRemoteIpAddress()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
