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

namespace Seoudi\RewardSystem\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface;

class RewardorderDetail extends AbstractModel implements IdentityInterface, RewardorderDetailInterface
{
    /**
     * @var string
     */
    public const CACHE_TAG = 'rewardsystem_rewardorderdetail';
    /**
     * @var string
     */
    protected $_cacheTag = 'rewardsystem_rewardorderdetail';
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'rewardsystem_rewardorderdetail';
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Seoudi\RewardSystem\Model\ResourceModel\RewardorderDetail::class);
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
    }
    /**
     * Get Entity ID
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    /**
     * Set Entity Id
     *
     * @param int $id
     */
    public function setEntityId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
    /**
     * Get Order Id
     *
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }
    /**
     * Set Order Id
     *
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }
    /**
     * Get Item Id
     *
     * @return int|null
     */
    public function getItemId()
    {
        return $this->getData(self::ITEM_ID);
    }
    /**
     * Set Item Id
     *
     * @param int $itemId
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }
    /**
     * Get Points
     *
     * @return float|null
     */
    public function getPoints()
    {
        return $this->getPoints(self::POINTS);
    }
    /**
     * Set Points
     *
     * @param float $points
     */
    public function setPoints($points)
    {
        return $this->setData(self::POINTS, $points);
    }
    /**
     * Get Quantity
     *
     * @return int|null
     */
    public function getQty()
    {
        return $this->getQty(self::QTY);
    }
    /**
     * Set Quantity
     *
     * @param int $qty
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }
    /**
     * Get quantity wise reward points is enable
     *
     * @return int|null
     */
    public function getIsQtyWise()
    {
        return $this->getQty(self::IS_QTY_WISE);
    }
    /**
     * Set quantity wise reward points is enable
     *
     * @param int $isQtyWise
     */
    public function setIsQtyWise($isQtyWise)
    {
        return $this->setData(self::IS_QTY_WISE, $isQtyWise);
    }
}
