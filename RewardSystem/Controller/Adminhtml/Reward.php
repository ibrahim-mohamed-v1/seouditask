<?php
namespace Seoudi\RewardSystem\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Reward extends \Magento\Backend\App\Action
{

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Seoudi_RewardSystem::reward');
    }
}
