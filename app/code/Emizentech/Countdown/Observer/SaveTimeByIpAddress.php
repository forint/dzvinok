<?php
declare(strict_types=1);

namespace Emizentech\Countdown\Observer;

use Emizentech\Countdown\Helper\Data;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Registry;
use Emizentech\Countdown\Model\ItemFactory;
use Emizentech\Countdown\Api\ItemRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Response\RedirectInterface;

/**
 * Class SaveTimeByIpAddress
 * @package Emizentech\Countdown\Observer
 */
class SaveTimeByIpAddress implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var
     */
    protected $helper;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var DataObjectFactory
     */
    protected $objectFactory;

    /**
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * @var ItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * @var DateTimeFactory
     */
    protected $dateFactory;
    /**
     * @var ResultFactory
     */
    protected $resultFactory;
    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * SaveTimeByIpAddress constructor.
     * @param Data $helper
     * @param Registry $registry
     * @param DataObjectFactory $objectFactory
     * @param DateTimeFactory $dateFactory
     * @param ItemRepositoryInterface $itemRepository
     * @param ItemFactory $itemFactory
     * @param ResultFactory $resultFactory
     * @param RedirectInterface $redirect
     */
    public function __construct(
        Data $helper,
        Registry $registry,
        DataObjectFactory $objectFactory,
        DateTimeFactory $dateFactory,
        ItemRepositoryInterface $itemRepository,
        ItemFactory $itemFactory,
        ResultFactory $resultFactory,
        RedirectInterface $redirect
    ){
        $this->helper = $helper;
        $this->registry = $registry;
        $this->dateFactory = $dateFactory;
        $this->objectFactory = $objectFactory;
        $this->itemRepository = $itemRepository;
        $this->itemFactory = $itemFactory;
        $this->resultFactory = $resultFactory;
        $this->redirect = $redirect;
    }

    /**
     * Set first visit time to registry,
     * otherwise save time to db and redirect
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     * @throws \Exception
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $existItem = $this->itemRepository->getByIp($this->helper->getRemoteIpAddress());
        if ($existItem && $existItem->getVisit()){
            $visitDateArray = explode(' ', $existItem->getVisit());
            $visitDate = $visitDateArray['0'];
        }

        if ($existItem && isset($visitDate) && $visitDate == date('Y-m-d')){
            if (!$this->registry->registry('visit_per_day')){
                $this->registry->register('visit_per_day', $existItem->getVisit());
            }
        }else{
            $timestamp = $this->dateFactory->create()->gmtDate();
            $dataObject = $this->objectFactory->create();
            $dataObject->setData([
                'ip' => $this->helper->getRemoteIpAddress(),
                'visit' => $timestamp
            ]);

            $item = $this->itemFactory->create();
            $item->addData([
                'ip' => $this->helper->getRemoteIpAddress(),
                'visit' => $timestamp
            ]);
            $item->save();

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->redirect->getRefererUrl());

            return $resultRedirect;
        }

        return $this;
    }
}