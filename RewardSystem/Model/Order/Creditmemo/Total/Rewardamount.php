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
namespace Seoudi\RewardSystem\Model\Order\Creditmemo\Total;

class Rewardamount extends \Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal
{
    /**
     * Collect method
     *
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
          $order = $creditmemo->getOrder();
        $orderRewardamountTotal = $order->getRewardAmount();

        if ($orderRewardamountTotal && $order->getTotalRefunded() == 0) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal()+$orderRewardamountTotal);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal()+$orderRewardamountTotal);
        }
        return $this;
    }
}
