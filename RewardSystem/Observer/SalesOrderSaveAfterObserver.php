<?php
/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
namespace Seoudi\RewardSystem\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;

class SalesOrderSaveAfterObserver implements ObserverInterface
{


    /**
     * Execute method
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $rewardAmount = $observer->getQuote()->getRewardAmount();
        $baseRewardAmount = $observer->getQuote()->getBaseRewardAmount();
        $order->setRewardAmount($rewardAmount);
        $order->setBaseRewardAmount($baseRewardAmount);
    }
}
