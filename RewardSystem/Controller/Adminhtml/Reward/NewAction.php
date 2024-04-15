<?php

namespace Seoudi\RewardSystem\Controller\Adminhtml\Reward;

use Seoudi\RewardSystem\Controller\Adminhtml\Reward as RewardController;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends RewardController
{
    /**
     * Execute
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Seoudi_RewardSystem::rewardsystem');
        $resultPage->getConfig()->getTitle()->prepend(__('New Transaction'));
        $resultPage->addBreadcrumb(__('New Transaction'), __('New Transaction'));
        return $resultPage;
    }
}
