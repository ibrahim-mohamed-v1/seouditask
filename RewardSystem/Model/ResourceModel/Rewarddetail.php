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

class Rewarddetail extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Magento\Framework\Model\ResourceModel\Db\Context
     */
    protected $context;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var string
     */
    protected $resourcePrefix;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\DateTime        $date
     * @param \Magento\Framework\Model\ResourceModel\Db\Context  $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param string                                             $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        $resourcePrefix = null
    ) {
        $this->date = $date;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $resourcePrefix);
    }
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('rs_reward_details', 'entity_id');
    }

    /**
     * Before Save method
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var  \Seoudi\RewardSystem\Model\Rewarddetail $object */
        if (!$object->getId()) {
            if ($object->getAction() == 'credit' && $object->getStatus()) {
                $expiresDays = (int)$this->scopeConfig->getValue(
                    'rewardsystem/general_settings/expires_after_days',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
                if ($expiresDays) {
                    if (!$object->getExpiresAt()) {
                        $date = $this->date->gmtDate(
                            'Y-m-d',
                            $this->date->gmtTimestamp() + $expiresDays * 24 * 60 * 60
                        );
                        $object->setExpiresAt($date);
                    }
                }
            }
        }
        return parent::_beforeSave($object);
    }
}
