<?php
namespace Seoudi\RewardSystem\Controller\Adminhtml\Reward;

use Seoudi\RewardSystem\Controller\Adminhtml\Reward as RewardController;
use Magento\Framework\Controller\ResultFactory;

class Index extends RewardController
{
    /**
     * Execute method
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Seoudi_RewardSystem::rewardsystem');
        $resultPage->getConfig()->getTitle()->prepend(__('Reward System Details'));
        $resultPage->addBreadcrumb(__('Reward System Details'), __('Reward System Details'));
        return $resultPage;
    }
}
