<?php
/**
 * Seoudi Software
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
namespace Seoudi\RewardSystem\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Add AddRewardAmountItem item to Payment Cart amount.
 */
class AddRewardAmountItem implements ObserverInterface
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;
    /**
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Add Reward amount as custom item to payment cart totals.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Payment\Model\Cart $cart */
        $cart = $observer->getEvent()->getCart();
        $quote = $this->checkoutSession->getQuote();
        $rewardAmount = $quote->getRewardAmount();
        $cart->addCustomItem(__('Reward Amount'), 1, 1.00 * $rewardAmount, 'rewardamount');
    }
}
