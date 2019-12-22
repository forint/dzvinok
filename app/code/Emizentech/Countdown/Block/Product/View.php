<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Block\Product;

use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;

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
    public function isCountdownEnabled()
    {
        return $this->getProduct()->getData('countdown_enabled');
    }

    /**
     * @return bool|false|string
     */
    public function getPriceCountDown(){
        if($this->_scopeConfig->getValue('countdown/general/enabled')){
            $currentDayName =  strtolower(date('l'));

            if($this->_scopeConfig->getValue('countdown/general/enabled')){

                $week = [
                    'monday' => $this->_scopeConfig->getValue('countdown/general/monday'),
                    'tuesday' => $this->_scopeConfig->getValue('countdown/general/tuesday'),
                    'wednesday' => $this->_scopeConfig->getValue('countdown/general/wednesday'),
                    'thursday' => $this->_scopeConfig->getValue('countdown/general/thursday'),
                    'friday' => $this->_scopeConfig->getValue('countdown/general/friday'),
                    'saturday' => $this->_scopeConfig->getValue('countdown/general/saturday'),
                    'sunday' => $this->_scopeConfig->getValue('countdown/general/sunday')
                ];

                $time = $week[$currentDayName];
                $str_time = preg_replace("/^([\d]{1,2})\,([\d]{2})$/", "00:$1:$2", $time);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

                /**
                 * Calculate diff between first visit and current times,
                 * use it when generate current countdown time
                 */
                if ($this->registry->registry('visit_per_day')){

                    $firstVisitPerDay = $this->registry->registry('visit_per_day');
                    $firstVisitPerDay = preg_replace("/^([\d]{1,2})\,([\d]{2})$/", "00:$1:$2", $firstVisitPerDay);

                    $startDate = date_create_from_format('Y-m-d H:i:s', $firstVisitPerDay);
                    $endDate = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s', time()));

                    $diff = date_diff($startDate, $endDate);
                    if ($diff->s > 0 || $diff->i > 0 || $diff->h > 0){
                        $diff_time_seconds = $diff->h * 3600 + $diff->i * 60 + $diff->s;
                        if ($diff_time_seconds < $time_seconds){
                            return gmdate("Y/m/d H:i:s", time() + ($time_seconds - $diff_time_seconds));
                        }
                    }
                }
                /**
                 * Otherwise use default preferences times
                 */
                if($week[$currentDayName] != null) {
                    return gmdate("Y/m/d H:i:s", time() + $time_seconds);
                }
            }
        }
    }
}