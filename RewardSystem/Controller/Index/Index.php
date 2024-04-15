<?php
namespace Seoudi\RewardSystem\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Seoudi\RewardSystem\Helper\Data
     */
    protected $_rewardHelper;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Seoudi\RewardSystem\Helper\Data $rewardHelper
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    public function __construct(
        Context                                           $context,
        PageFactory                                       $resultPageFactory,
        \Seoudi\RewardSystem\Helper\Data                  $rewardHelper,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_rewardHelper = $rewardHelper;
        $this->redirect = $redirect;
        parent::__construct($context);
    }
    /**
     * Execute
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        if ($this->_rewardHelper->enableRewardSystem()) {
            $resultPage = $this->_resultPageFactory->create();
            $block = $resultPage->getLayout()->getBlock('customer.account.link.back');
            if ($block) {
                $block->setRefererUrl($this->redirect->getRefererUrl());
            }
            $resultPage->getConfig()->getTitle()->set(
                __('My Reward')
            );
            return $resultPage;
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('customer/account/');
        }
    }
}
