<?php
namespace Seoudi\RewardSystem\Block;

use Magento\Framework\Json\Helper\Data;

class RewardData extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Seoudi\RewardSystem\Helper\Data                 $rewardHelper
     * @param Data                                             $jsonData
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Seoudi\RewardSystem\Helper\Data                 $rewardHelper,
        Data                                             $jsonData,
        array                                            $data = []
    ) {
        $this->_rewardHelper = $rewardHelper;
        $this->jsonData = $jsonData;
        parent::__construct($context, $data);
    }

     /**
      * Get Helper Class
      */
    public function getHelperClass()
    {
        return $this->_rewardHelper;
    }

    /**
     * Get JSON helper
     */
    public function getJsonHelper()
    {
        return $this->jsonData;
    }
}
