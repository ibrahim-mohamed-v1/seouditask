<?php
namespace Seoudi\RewardSystem\Block\Adminhtml\Transaction\NewAction;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Seoudi\RewardSystem\Block\Adminhtml\Transaction\NewAction\SaveButton
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Transaction'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
