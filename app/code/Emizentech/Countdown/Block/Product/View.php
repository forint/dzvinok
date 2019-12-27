<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Block\Product;

use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
/**
 * Class View
 * @package Emizentech\Countdown\Block\Product
 */
class View extends \Magento\Catalog\Block\Product\View
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var TimezoneInterface
     */
    private $datetime;

    /**
     * View constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param Registry $registry
     * @param \Psr\Log\LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        Registry $registry,
        \Psr\Log\LoggerInterface $logger,
        ObjectManagerInterface $objectManager,
        TimezoneInterface $datetime,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );

        $this->registry = $registry;
        $this->logger = $logger;
    }

    /**
     * @return mixed
     */
    function getTitle()
    {
        return $this->_scopeConfig->getValue('countdown/general/title');
    }
    /**
     * @return mixed
     */
    function getTimeUpMessage()
    {
        return $this->_scopeConfig->getValue('countdown/general/timeup');
    }
    /**
     * @return mixed
     */
    public function isCountdownEnabled()
    {
        return $this->getProduct()->getData('countdown_enabled');
    }

    /**
     * @return array
     */
    public function getConfigWeekTime(){
        return [
            'monday' => $this->_scopeConfig->getValue('countdown/general/monday'),
            'tuesday' => $this->_scopeConfig->getValue('countdown/general/tuesday'),
            'wednesday' => $this->_scopeConfig->getValue('countdown/general/wednesday'),
            'thursday' => $this->_scopeConfig->getValue('countdown/general/thursday'),
            'friday' => $this->_scopeConfig->getValue('countdown/general/friday'),
            'saturday' => $this->_scopeConfig->getValue('countdown/general/saturday'),
            'sunday' => $this->_scopeConfig->getValue('countdown/general/sunday')
        ];
    }

    /**
     * @return false|string
     * @throws \Exception
     */
    public function getPriceCountDown(){
        if($this->_scopeConfig->getValue('countdown/general/enabled')){

            /** @var Set default timezone $date */
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone(date_default_timezone_get()));

            $currentDayName =  strtolower(date('l'));
            if($this->_scopeConfig->getValue('countdown/general/enabled')){

                $configWeekTime = $this->getConfigWeekTime();
                $time = $configWeekTime[$currentDayName];

                $str_time = preg_replace("/^([\d]{1,2})\,([\d]{2})$/", "00:$1:$2", $time);
                sscanf($str_time, "%d,%d,%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

                /**
                 * Calculate diff between first visit and current times,
                 * use it when generate current countdown time
                 */
                if ($this->registry->registry('visit_per_day')){
                    $firstVisitPerDay = $this->registry->registry('visit_per_day');
                    $firstVisitPerDay = preg_replace("/^([\d]{1,2})\,([\d]{2})$/", "00:$1:$2", $firstVisitPerDay);

                    $startDate = date_create_from_format('Y-m-d H:i:s', $firstVisitPerDay);
                    $endDate = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s', $date->getTimestamp()));

                    $diff = date_diff($startDate, $endDate);
                    if ($diff->s > 0 || $diff->i > 0 || $diff->h > 0){
                        $diff_time_seconds = $diff->h * 3600 + $diff->i * 60 + $diff->s;
                        if ($diff_time_seconds < $time_seconds){

                            $date->setTimestamp($date->getTimestamp() + ($time_seconds - $diff_time_seconds) );
                            return $date->format('Y/m/d H:i:s' );
                        }else{
                            /** Return current time for display to customer that the time is over */
                            $date->setTimestamp($date->getTimestamp());
                            return $date->format('Y/m/d H:i:s' );
                        }
                    }
                }

                /**
                 * Otherwise use default preferences times
                 */
                if($configWeekTime[$currentDayName] != null) {
                    $date->setTimestamp($date->getTimestamp() + $time_seconds );
                    return $date->format('Y/m/d H:i:s' );
                }
            }
        }
    }
}