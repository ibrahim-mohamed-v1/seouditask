<?php

namespace Seoudi\ProductRecommendations\Model;

class UserBrowsingHistory extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Seoudi\ProductRecommendations\Model\ResourceModel\UserBrowsingHistory::class);
    }

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * Set Customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * Get Product ID
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->getData('product_id');
    }

    /**
     * Set Product ID
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * Get Viewed At
     *
     * @return string
     */
    public function getViewedAt()
    {
        return $this->getData('viewed_at');
    }

    /**
     * Set Viewed At
     *
     * @param string $viewedAt
     * @return $this
     */
    public function setViewedAt($viewedAt)
    {
        return $this->setData('viewed_at', $viewedAt);
    }
}
