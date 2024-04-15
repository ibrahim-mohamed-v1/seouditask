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

namespace Seoudi\RewardSystem\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RewardorderDetail extends AbstractDb
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('wk_rs_reward_order_details', 'entity_id');
    }
}
