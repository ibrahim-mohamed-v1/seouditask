<?php

namespace Seoudi\ProductRecommendations\Model\ResourceModel\UserBrowsingHistory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Seoudi\ProductRecommendations\Model\UserBrowsingHistory::class,
            \Seoudi\ProductRecommendations\Model\ResourceModel\UserBrowsingHistory::class
        );
    }
}
