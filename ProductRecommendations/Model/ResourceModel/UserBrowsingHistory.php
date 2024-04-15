<?php

namespace Seoudi\ProductRecommendations\Model\ResourceModel;

class UserBrowsingHistory  extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
{
    $this->_init('user_browsing_history', 'id'); // Table name and primary key column
}
}
