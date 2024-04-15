<?php
namespace Seoudi\RewardSystem\Observer;

use Magento\Framework\Event\Manager;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;
use Seoudi\RewardSystem\Helper\Data as RewardHelper;
use Seoudi\RewardSystem\Observer\CheckoutSession;
use Seoudi\RewardSystem\Observer\Session;

class QuoteItemRemoveAfterObserver implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var RewardHelper;
     */
    protected $helper;

    /**
     * @param SessionManager $session
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param RewardHelper $helper
     */
    public function __construct(
        SessionManager $session,
        \Magento\Checkout\Model\Session $checkoutSession,
        RewardHelper $helper
    ) {
        $this->_session = $session;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
    }

    /**
     * Execute method
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $this->checkoutSession->getQuote();

        if (empty($quote->getId())) {
            $quoteItem = $observer->getEvent()->getQuoteItem();
            $quote = $quoteItem->getQuote();
        }

        $this->helper->unsetRewardInfoInQuote($quote);
    }
}
