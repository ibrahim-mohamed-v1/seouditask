<?php

namespace Seoudi\RewardSystem\Block\Adminhtml\Product\Edit\Tab\Renderer;

use Magento\Framework\DataObject;
use Seoudi\RewardSystem\Helper\Data;

class EndTime extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @param Data $dataHelper
     */
    public function __construct(
        Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
    }

    /**
     * Get category name
     *
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $edTime = $row->getEndTime();
        if ($edTime != "") {
            $endTime = $this->dataHelper->getTimeAccordingToTimeZone($edTime);
            $edTime = $endTime;
        }
            return $edTime;
    }
}
