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

namespace Seoudi\RewardSystem\Model\ResourceModel\Rewarddetail;

use Seoudi\RewardSystem\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Seoudi\RewardSystem\Model\Rewarddetail::class,
            \Seoudi\RewardSystem\Model\ResourceModel\Rewarddetail::class
        );
    }

    /**
     * Add Store Filter
     *
     * @param int  $store
     * @param bool $withAdmin
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }
}
