<?php
namespace Seoudi\RewardSystem\Controller\Adminhtml\Product;

use Seoudi\RewardSystem\Controller\Adminhtml\Product as ProductController;
use Magento\Framework\Controller\ResultFactory;

class Index extends ProductController
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
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Reward Points on Product'));
        $resultPage->addBreadcrumb(__('Manage Reward Points on Product'), __('Manage Reward Points on Product'));
        $resultPage->addContent(
            $resultPage->getLayout()->createBlock(
                \Seoudi\RewardSystem\Block\Adminhtml\Product\Edit::class
            )
        );
        $resultPage->addLeft(
            $resultPage->getLayout()->createBlock(
                \Seoudi\RewardSystem\Block\Adminhtml\Product\Edit\Tabs::class
            )
        );
        return $resultPage;
    }
}
