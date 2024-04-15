<?php
namespace Seoudi\RewardSystem\Controller\Checkout;

use Magento\Framework\Session\SessionManager;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Seoudi\RewardSystem\Helper\Data as RewardHelper;
use Seoudi\RewardSystem\Controller\Checkout\CheckoutSession;

class CancelRewards extends Action
{
    /**
     * @var SessionManager
     */
    protected $session;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var RewardHelper;
     */
    protected $helper;

    /**
     * @param Context $context
     * @param SessionManager $session
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param RewardHelper $helper
     */
    public function __construct(
        Context $context,
        SessionManager $session,
        \Magento\Checkout\Model\Session $checkoutSession,
        RewardHelper $helper
    ) {
        $this->session = $session;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
        parent::__construct($context);
    }
    /**
     * Unset the credit data from session.
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $quote = $this->checkoutSession->getQuote();

        $this->helper->unsetRewardInfoInQuote($quote);
        $this->messageManager->addSuccess('Your Reward was successfully cancelled.');
        return $this->resultRedirectFactory
                ->create()
                ->setPath('checkout/cart', ['_secure' => $this->getRequest()->isSecure()]);
    }
}
