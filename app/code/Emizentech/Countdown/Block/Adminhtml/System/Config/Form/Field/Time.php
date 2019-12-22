<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Yotpo\Yotpo\Model\Config as YotpoConfig;

/**
 * Class Time
 * @package Emizentech\Countdown\Block\Adminhtml\System\Config\Form\Field
 */
class Time extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var YotpoConfig
     */
    private $yotpoConfig;

    /**
     * Time constructor.
     * @param Context $context
     * @param YotpoConfig $yotpoConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        YotpoConfig $yotpoConfig,
        array $data = []
    ) {
        $this->yotpoConfig = $yotpoConfig;
        parent::__construct($context, $data);
    }

    /**
     * Render element
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return parent::render($element);
    }
}
