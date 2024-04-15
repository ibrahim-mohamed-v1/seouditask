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

namespace Seoudi\RewardSystem\Model\ResourceModel\RewardorderDetail;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Seoudi\RewardSystem\Model\RewardorderDetail::class,
            \Seoudi\RewardSystem\Model\ResourceModel\RewardorderDetail::class
        );
    }
}
