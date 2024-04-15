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

namespace Seoudi\RewardSystem\Plugin\Block\Widget;

use Seoudi\RewardSystem\Helper\Data as RewardSystemHelper;

class Dob
{
    /**
     * @var \Seoudi\RewardSystem\Helper\Data
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param RewardSystemHelper $helper
     */
    public function __construct(
        RewardSystemHelper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * After Is Enabled
     *
     * @param \Magento\Customer\Block\Widget\Dob $subject
     * @param array $result
     */
    public function afterIsEnabled(
        \Magento\Customer\Block\Widget\Dob $subject,
        $result
    ) {
        $helper = $this->helper;
        $enableRewardSystem = $helper->enableRewardSystem();
        if ($helper->getConfigData('reward_on_birthday') && $enableRewardSystem) {
            return true;
        }

        return $result;
    }

    /**
     * After Get Date Format
     */
    public function afterGetDateFormat()
    {
        $escapedDateFormat = 'M/dd/Y';

        return $escapedDateFormat;
    }
}
