<?php

namespace Seoudi\RewardSystem\Block;

use Seoudi\RewardSystem\Model\ResourceModel\Rewarddetail;
use Seoudi\RewardSystem\Model\ResourceModel\Rewardrecord;
use Magento\Sales\Model\Order;
use Magento\Framework\Json\Helper\Data;
use Seoudi\RewardSystem\Block\_rewardDetailCollection;
use Seoudi\RewardSystem\Block\Magento;
use Seoudi\RewardSystem\Block\Seoudi;

class RewardPoints extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Seoudi\RewardSystem\Model\ResourceModel\RewardDetail
     */
    protected $_rewardDetailModel;
    /**
     * @var _rewardDetailCollection
     */
    protected $_rewardDetailCollection;
    /**
     * @var Seoudi\RewardSystem\Model\ResourceModel\Rewardrecord
     */
    protected $_rewardRecordModel;
    /**
     * @var Order
     */
    protected $_order;
    /**
     * @var Seoudi\RewardSystem\Helper\Data
     */
    protected $_rewardHelper;
    /**
     * @var Magento\Framework\Pricing\Helper\Data
     */
    protected $_pricingHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param Rewardrecord\CollectionFactory                   $rewardRecord
     * @param RewardDetail\CollectionFactory                   $rewardDetail
     * @param Order                                            $order
     * @param \Seoudi\RewardSystem\Helper\Data                 $rewardHelper
     * @param \Magento\Framework\Pricing\Helper\Data           $pricingHelper
     * @param Data                                             $jsonData
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Rewardrecord\CollectionFactory                   $rewardRecord,
        Rewarddetail\CollectionFactory                   $rewardDetail,
        Order                                            $order,
        \Seoudi\RewardSystem\Helper\Data                 $rewardHelper,
        \Magento\Framework\Pricing\Helper\Data           $pricingHelper,
        Data                                             $jsonData,
        array                                            $data = []
    ) {
        parent::__construct($context, $data);
        $this->_rewardRecordModel = $rewardRecord;
        $this->_rewardDetailModel = $rewardDetail;
        $this->_order = $order;
        $this->_rewardHelper = $rewardHelper;
        $this->_pricingHelper = $pricingHelper;
        $this->jsonData = $jsonData;
    }

    /**
     * Prepare Layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getRewardDetailCollection()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'rewardsystem.rewarddetail.pager'
            )
            ->setCollection(
                $this->getRewardDetailCollection()
            );
            $this->setChild('pager', $pager);
            $this->getRewardDetailCollection()->load();
        }

        return $this;
    }
    /**
     * Get Pager Html
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    // get remaining total of a customer

    /**
     * Get Remaining Reward Points
     *
     * @param int $customerId
     */
    public function getRemainingRewardPoints($customerId)
    {
        $remainingPoints = 0;
        $rewardRecordCollection = $this->_rewardRecordModel->create()
            ->addFieldToFilter('customer_id', ['eq' => $customerId]);
        if (count($rewardRecordCollection)) {
            foreach ($rewardRecordCollection as $record) {
                $remainingPoints = $record->getRemainingRewardPoint();
            }
        }
        return $remainingPoints;
    }

    /**
     * Get reward detail collection of a customer
     */
    public function getRewardDetailCollection()
    {
        $param = $this->getRequest()->getParams();
        if (!$this->_rewardDetailCollection) {
            $customerId = $this->_rewardHelper
                ->getCustomerId();
            $rewardDetailCollection = $this->_rewardDetailModel->create()
                ->addFieldToFilter('customer_id', $customerId);
            if (!isset($param['srt'])) {
                $rewardDetailCollection->setOrder('transaction_at', 'DESC');
            }

            if (isset($param['st']) && $param['st']) {
                $status;
                if ($param['st'] == 'Applied') {
                    $param['st'] = 'debit';
                    $status = 1;
                } elseif ($param['st'] == 'Approved') {
                    $param['st'] = 'credit';
                    $status = 1;
                } elseif ($param['st'] == 'Pending') {
                    $param['st'] = 'credit';
                    $status = 0;
                } elseif ($param['st'] == 'Expired') {
                    $param['st'] = 'expire';
                    $status = 1;
                } elseif ($param['st'] == 'Cancelled') {
                    $param['st'] = 'credit';
                    $status = 2;
                } else {
                    $param['st'] = $param['st'] ;
                    $status = 1;
                }
                $rewardDetailCollection->addFieldToFilter('status', $status)
                    ->addFieldToFilter('action', $param['st']);
            }
            if (isset($param['ty']) && $param['ty']) {
                $rewardDetailCollection->addFieldToFilter('action', $param['ty']);
            }
            if (isset($param['pt']) && $param['pt']) {
                $rewardDetailCollection->addFieldToFilter('reward_point', $param['pt']);
            }

            if (isset($param['srt']) && $param['srt']) {
                $rewardDetailCollection->setOrder('reward_point', $param['srt']);
            }
            $this->_rewardDetailCollection = $rewardDetailCollection;
        }
        return $this->_rewardDetailCollection;
    }

    /**
     * Get Order
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * Get Helper Class
     */
    public function getHelperClass()
    {
        return $this->_rewardHelper;
    }

    /**
     * Get JSON helper
     */
    public function getJsonHelper()
    {
        return $this->jsonData;
    }
}
