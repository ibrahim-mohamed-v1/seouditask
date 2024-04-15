<?php
/**
 * Seoudi Software
 *
 * @category Seoudi
 * @package Seoudi_RewardSystem
 * @author Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license https://store.Seoudi.com/license.html
 */

namespace Seoudi\RewardSystem\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Seoudi\RewardSystem\Helper\Data as HelperData;

/**
 * View Model for Reward System
 */
class Reward implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var HelperData
     */
    protected $helperData;
    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param HelperData $helperData
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        HelperData $helperData
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->helperData = $helperData;
    }

    /**
     * Get Reward Data helper
     *
     * @return \Seoudi\RewardSystem\Helper\Data
     */
    public function getRewardDataHelper()
    {
        return $this->helperData;
    }
}
