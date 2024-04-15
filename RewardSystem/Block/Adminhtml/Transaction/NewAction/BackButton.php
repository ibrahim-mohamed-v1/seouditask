<?php
namespace Seoudi\RewardSystem\Block\Adminhtml\Transaction\NewAction;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Seoudi\RewardSystem\Block\Adminhtml\Transaction\NewAction\GenericButton;

/**
 * Class Seoudi\RewardSystem\Block\Adminhtml\Transaction\NewAction\BackButton
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf('location.href = \'%s\';', $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
