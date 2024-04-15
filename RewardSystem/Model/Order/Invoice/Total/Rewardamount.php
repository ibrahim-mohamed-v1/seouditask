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
namespace Seoudi\RewardSystem\Model\Order\Invoice\Total;

class Rewardamount extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * Collect method
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $order=$invoice->getOrder();
        $orderRewardamountTotal = $order->getRewardAmount();
        if ($orderRewardamountTotal && count($order->getInvoiceCollection())==0) {
            $invoice->setGrandTotal($invoice->getGrandTotal()+$orderRewardamountTotal);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal()+$orderRewardamountTotal);
        }
        return $this;
    }
}
