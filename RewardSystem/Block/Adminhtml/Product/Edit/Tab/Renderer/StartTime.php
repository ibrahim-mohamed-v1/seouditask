<?php
namespace Seoudi\RewardSystem\Block\Adminhtml\Product\Edit\Tab\Renderer;

use Magento\Framework\DataObject;
use Seoudi\RewardSystem\Helper\Data;

class StartTime extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
        $stTime = $row->getStartTime();
        if ($stTime != "") {
            $startTime = $this->dataHelper->getTimeAccordingToTimeZone($stTime);
            $stTime = $startTime;
        }
            return $stTime;
    }
}
