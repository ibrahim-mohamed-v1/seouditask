<?php
namespace Seoudi\RewardSystem\Helper;

use Magento\Sales\Model\OrderFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Seoudi\RewardSystem\Api\RewardrecordRepositoryInterface;
use Seoudi\RewardSystem\Api\RewarddetailRepositoryInterface;
use Seoudi\RewardSystem\Api\RewardproductRepositoryInterface;
use Seoudi\RewardSystem\Api\RewardproductSpecificRepositoryInterface;
use Seoudi\RewardSystem\Api\Data\RewardrecordInterfaceFactory;
use Seoudi\RewardSystem\Api\Data\RewarddetailInterfaceFactory;
use Seoudi\RewardSystem\Api\Data\RewardproductInterfaceFactory;
use Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Seoudi\RewardSystem\Helper\Magento;
use Seoudi\RewardSystem\Helper\RewardcartCollection;
use Seoudi\RewardSystem\Helper\RewardcategoryCollection;
use Seoudi\RewardSystem\Helper\RewardcategorySpecificCollection;
use Seoudi\RewardSystem\Helper\RewardcategorySpecificRepositoryInterface;
use Seoudi\RewardSystem\Helper\Session;
use Seoudi\RewardSystem\Model\ResourceModel\Rewardrecord\CollectionFactory as RewardRecordCollection;
use Seoudi\RewardSystem\Model\ResourceModel\Rewardproduct\CollectionFactory as RewardProductCollection;
use Seoudi\RewardSystem\Model\ResourceModel\RewardproductSpecific\CollectionFactory as RewardproductSpecificCollection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

/**
 * @property \Magento\Framework\Message\ManagerInterface $messageManager
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Locale\CurrencyInterface
     */
    protected $_localeCurrency;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var Magento\Framework\Pricing\Helper\Data
     */
    protected $_pricingHelper;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var Magento\Sales\Model\OrderFactory;
     */
    protected $_orderModel;

    /**
     * @var Magento\Customer\Model\CustomerFactory
     */
    protected $_customerModel;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cartModel;

    /**
     * @var \Seoudi\RewardSystem\Api\RewardrecordRepositoryInterface;
     */
    protected $_rewardRecordRepository;

    /**
     * @var \Seoudi\RewardSystem\Api\RewarddetailRepositoryInterface;
     */
    protected $_rewardDetailRepository;

    /**
     * @var \Seoudi\RewardSystem\Api\RewardproductRepositoryInterface;
     */
    protected $_rewardProductRepository;

    /**
     * @var \Seoudi\RewardSystem\Api\RewardproductSpecificRepositoryInterface;
     */
    protected $_rewardproductSpecificRepository;

    /**
     * @var \Seoudi\RewardSystem\Api\RewardcategoryRepositoryInterface;
     */
    protected $_rewardCategoryRepository;

    /**
     * @var \Seoudi\RewardSystem\Api\Data\RewardrecordInterfaceFactory;
     */
    protected $_rewardRecordInterface;

    /**
     * @var \Seoudi\RewardSystem\Api\RewardrecordRepositoryInterface;
     */
    protected $_rewardDetailInterface;

    /**
     * @var \Seoudi\RewardSystem\Api\Data\RewardproductInterfaceFactory;
     */
    protected $_rewardProductInterface;

    /**
     * @var \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterfaceFactory;
     */
    protected $_rewardproductSpecificInterface;

    /**
     * @var \Seoudi\RewardSystem\Api\Data\RewardcategoryInterfaceFactory;
     */
    protected $_rewardCategoryInterface;

    /**
     * @var \Seoudi\RewardSystem\Api\Data\RewardcategorySpecificInterfaceFactory;
     */
    protected $_rewardcategorySpecificInterface;

    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    /**
     * @var RewardProductCollection;
     */
    protected $_rewardProductCollection;

    /**
     * @var RewardRecordCollection;
     */
    protected $_rewardRecordCollection;

    /**
     * @var RewardcartCollection;
     */
    protected $_rewardcartCollection;



    /**
     * @var RewardcategoryCollection;
     */
    protected $_rewardcategoryCollection;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
     */
    protected $timezone;

    /**
     * @var \Magento\Framework\App\Http\Context;
     */
    protected $httpContext;

    /**
     * @var \Magento\Framework\App\Cache\ManagerFactory
     */
    protected $cacheManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \Seoudi\RewardSystem\Model\RewardorderDetailFactory
     */
    protected $_RewardorderDetailFactory;

    /**
     * @var \Seoudi\RewardSystem\Model\RewardproductFactory $RewardproductFactory
     */
    protected $_RewardproductFactory;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $json;
    private \Magento\Framework\Message\ManagerInterface $messageManager;
    private \Magento\Directory\Model\Currency $_currency;
    private RewardcategorySpecificRepositoryInterface $_rewardcategorySpecificRepository;
    private RewardproductSpecificCollection $_rewardproductSpecificCollection;
    private \Magento\Sales\Api\OrderRepositoryInterface $orderRepository;
    private \Magento\Eav\Model\Config $eavConfig;
    private \Magento\Catalog\Model\ProductFactory $productModel;
    private RewardcategorySpecificCollection $_rewardcategorySpecificCollection;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        CustomerSession $customerSession,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        OrderFactory $orderModel,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Checkout\Model\Cart $cartModel,
        RewardrecordRepositoryInterface $rewardRecordRepository,
        RewarddetailRepositoryInterface $rewardDetailRepository,
        RewardproductRepositoryInterface $rewardProductRepository,
        RewardproductSpecificRepositoryInterface $rewardproductSpecificRepository,
        RewardrecordInterfaceFactory $rewardRecordInterface,
        RewarddetailInterfaceFactory $rewardDetailInterface,
        RewardproductInterfaceFactory $rewardProductInterface,
        RewardproductSpecificInterfaceFactory $rewardproductSpecificInterface,
        DataObjectHelper $dataObjectHelper,
        RewardRecordCollection $rewardRecordCollection,
        RewardProductCollection $rewardProductCollection,
        RewardproductSpecificCollection $rewardproductSpecificCollection,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ProductFactory $productModel,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\App\Cache\ManagerFactory $cacheManagerFactory,
        LoggerInterface $logger,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Seoudi\RewardSystem\Model\RewardorderDetailFactory $RewardorderDetailFactory,
        \Seoudi\RewardSystem\Model\RewardproductFactory $RewardproductFactory,
        \Magento\Framework\Serialize\Serializer\Json $json
    ) {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->_customerSession = $customerSession;
        $this->_localeCurrency = $localeCurrency;
        $this->_currency = $currency;
        $this->_storeManager = $storeManager;
        $this->_priceCurrency = $priceCurrency;
        $this->_pricingHelper = $pricingHelper;
        $this->_date = $date;
        $this->_orderModel = $orderModel;
        $this->cartModel = $cartModel;
        $this->_customerModel = $customerFactory;
        $this->_rewardRecordRepository = $rewardRecordRepository;
        $this->_rewardDetailRepository = $rewardDetailRepository;
        $this->_rewardProductRepository = $rewardProductRepository;
        $this->_rewardproductSpecificRepository = $rewardproductSpecificRepository;
        $this->_rewardRecordInterface = $rewardRecordInterface;
        $this->_rewardDetailInterface = $rewardDetailInterface;
        $this->_rewardProductInterface = $rewardProductInterface;
        $this->_rewardproductSpecificInterface = $rewardproductSpecificInterface;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_rewardRecordCollection = $rewardRecordCollection;
        $this->_rewardProductCollection = $rewardProductCollection;
        $this->_rewardproductSpecificCollection = $rewardproductSpecificCollection;
        $this->eavConfig = $eavConfig;
        $this->productModel = $productModel;
        $this->httpContext = $httpContext;
        $this->timezone = $timezone;
        $this->cacheManager = $cacheManagerFactory;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->_RewardorderDetailFactory = $RewardorderDetailFactory;
        $this->_RewardproductFactory = $RewardproductFactory;
        $this->json = $json;
    }

    /**
     * Return customer id from customer session
     */
    public function getCustomerId()
    {
        return $this->httpContext->getValue('customer_id');
    }

    /**
     * Get Reward configurations value
     *
     * @param string $field
     */
    public function getConfigData($field)
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/'.$field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Enable Reward System
     */
    public function enableRewardSystem()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return reward points value
     */
    public function getRewardValue()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/reward_value',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return maximum reward points can assign
     */
    public function getRewardCanAssign()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/max_reward_assign',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return maximum reward points can use
     */
    public function getRewardCanUsed()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/max_reward_used',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get reward priority set in system config
     */
    public function getrewardPriority()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/priority',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get status of product quantity wise reward
     */
    public function getrewardQuantityWise()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/activeproduct',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }



    /**
     * Get Reward Approved On
     */
    public function getRewardApprovedOn()
    {
        return $this->scopeConfig->getValue(
            'rewardsystem/general_settings/order_reward_approved_on',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Format Date
     *
     * @param  string $date
     * @return string Formatted Date
     */
    public function formatDate($date)
    {
        if ($date) {
            return $this->timezone->formatDate(
                $date,
                \IntlDateFormatter::FULL,
                false
            );
        } else {
            return __("-");
        }
    }

    /**
     * Get Time According To TimeZone Magento Locale Timezone
     *
     * @param string $dateTime
     */
    public function getTimeAccordingToTimeZone($dateTime)
    {
        // for get current time according to time zone
        $today = $this->timezone->date()->format('h:i A');

        // for convert date time according to magento time zone
        $dateTimeAsTimeZone = $this->timezone
                                        ->date(new \DateTime($dateTime))
                                       ->format('h:i A');
        return $dateTimeAsTimeZone;
    }

    /**
     * Save Data Reward Record
     *
     * @param object $completeDataObject
     */
    public function saveDataRewardRecord($completeDataObject)
    {
        try {
            $this->_rewardRecordRepository->save($completeDataObject);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Save Data Reward Detail
     *
     * @param object $completeDataObject
     */
    public function saveDataRewardDetail($completeDataObject)
    {
        try {
            $this->_rewardDetailRepository->save($completeDataObject);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Return currency currency code
     */
    public function getCurrentCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    /**
     * Get base currency code
     */
    public function getBaseCurrencyCode()
    {
        return $this->_storeManager->getStore()->getBaseCurrencyCode();
    }

    /**
     * Get all allowed currency in system config
     */
    public function getConfigAllowCurrencies()
    {
        return $this->_currency->getConfigAllowCurrencies();
    }

    /**
     * Get currency rates
     *
     * @param string $currency
     * @param string $toCurrencies
     */
    public function getCurrencyRates($currency, $toCurrencies = null)
    {
        return $this->_currency->getCurrencyRates($currency, $toCurrencies); // give the currency rate
    }

    /**
     * Get currency symbol of an currency code
     *
     * @param string $currencycode
     */
    public function getCurrencySymbol($currencycode)
    {
        $currency = $this->_localeCurrency->getCurrency($currencycode);

        return $currency->getSymbol() ? $currency->getSymbol() : $currency->getShortName();
    }

    /**
     * Get formatted Price
     *
     * @param int $price
     */
    public function getformattedPrice($price)
    {
        return $this->_pricingHelper
            ->currency($price, true, false);
    }

    /**
     * Get Store
     */
    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    /**
     * Get currenct currency amount from base
     *
     * @param int $amount
     * @param string $store
     */
    public function currentCurrencyAmount($amount, $store = null)
    {
        if ($store == null) {
            $store = $this->_storeManager->getStore()->getStoreId();
        }
        $returnAmount = $this->_priceCurrency->convert($amount, $store);

        return round($returnAmount, 4);
    }

    /**
     * Get amount in base currency amount from current currency
     *
     * @param int $amount
     * @param string $store
     */
    public function baseCurrencyAmount($amount, $store = null)
    {
        if ($store == null) {
            $store = $this->_storeManager->getStore()->getStoreId();
        }
        if ($amount == 0) {
            return $amount;
        }
        $rate = $this->_priceCurrency->convert($amount, $store) / $amount;
        $amount = $amount / $rate;

        return round($amount, 4);
    }

    /**
     * Get customer's Remaining Reward Points
     *
     * @param int $customerId
     */
    public function getCurrentRewardOfCustomer($customerId)
    {
        $reward = 0;
        $rewardRecordCollection = $this->_rewardRecordCollection->create()
          ->addFieldToFilter('customer_id', $customerId);
        if ($rewardRecordCollection->getSize()) {
            foreach ($rewardRecordCollection as $recordData) {
                $reward = $recordData->getRemainingRewardPoint();
            }
        }
        return $reward;
    }

    /**
     * Send Points Expire Email
     *
     * @param  \Seoudi\RewardSystem\Model\Rewarddetail $transaction
     * @return
     */


    /**
     * Set Data From Admin
     *
     * @param string $msg
     * @param string $adminMsg
     * @param array  $rewardData
     */
    public function setDataFromAdmin(
        $msg,
        $adminMsg,
        $rewardData
    ) {
        $assignStatus = true;
        $maxRewardCanAssign = $this->getRewardCanAssign();
        $customerReward = $this->getCurrentRewardOfCustomer($rewardData['customer_id']);
        if ($rewardData['type'] == "credit" && $maxRewardCanAssign < ($customerReward + $rewardData['points'])) {
            $assignStatus = false;
        }
        if ($assignStatus) {
            $status = $rewardData['status'];
            $rewardValue = $this->getRewardValue();
            $baseCurrencyCode = $this->getBaseCurrencyCode();
            $amount = $rewardValue * $rewardData['points'];
            $isRevert = isset($rewardData['is_revert']) ? $rewardData['is_revert']: 0;
            $isExpired = 0;
            if (isset($rewardData['is_expired'])) {
                $isExpired = $rewardData['is_expired'];
            }
            $recordDetail = [
            'customer_id' => $rewardData['customer_id'],
            'reward_point' => $rewardData['points'],
            'amount' => $amount,
            'status' => $status,
            'action' => $rewardData['type'],
            'order_id' => $rewardData['order_id'],
            'transaction_at' => $this->_date->gmtDate(),
            'currency_code' => $baseCurrencyCode,
            'curr_amount' => $amount,
            'review_id' => $rewardData['review_id'],
            'transaction_note' => $rewardData['note'],
            'is_expired' => $isExpired,
            'is_revert' => $isRevert
            ];
            $dataObjectRecordDetail = $this->_rewardDetailInterface->create();

            $this->_dataObjectHelper->populateWithArray(
                $dataObjectRecordDetail,
                $recordDetail,
                \Seoudi\RewardSystem\Api\Data\RewarddetailInterface::class
            );
            if ($status==1) {
                $this->updateRewardRecordData($msg, $adminMsg, $rewardData);
                if ($rewardData['type'] == 'debit') {
                    $this->updateExpiryRecordData($rewardData);
                }
            }
            $this->saveDataRewardDetail($dataObjectRecordDetail);
            return [true, 'Successful'];
        } else {
            return [false, 'Total amount exceeds max for some customers.'];
        }
    }

    /**
     * Update Expiry Record Data
     *
     * @param array $rewardData
     */
    public function updateExpiryRecordData($rewardData)
    {
        try {
            $points = $rewardData['points'];
            $customerId = $rewardData['customer_id'];
            $transactions = $this->_rewardDetailInterface->create()
                          ->getCollection()
                          ->addFieldToFilter('customer_id', $customerId)
                          ->addFieldToFilter('is_expired', 0)
                          ->addFieldToFilter('action', 'credit')
                          ->setOrder('expires_at', 'ASC');
            $transactions->getSelect()->where('reward_point > reward_used OR reward_used IS NULL');
            if ($transactions->getSize()) {
                foreach ($transactions as $transaction) {
                    $remainingPoints = $transaction->getRewardPoint() - $transaction->getRewardUsed();
                    if ($points) {
                        if ($points <= $remainingPoints) {
                            $updatedPoints = $transaction->getRewardUsed() + $points;
                            $points = 0;
                        } else {
                            $updatedPoints = $transaction->getRewardUsed() + $remainingPoints;
                            $points -= $remainingPoints;
                        }
                        $transaction->setRewardUsed($updatedPoints)->save();
                    } else {
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Update Reward Record Data
     *
     * @param string $msg
     * @param string $adminMsg
     * @param array  $rewardData
     * @param int    $storeId
     */
    public function updateRewardRecordData($msg, $adminMsg, $rewardData, $storeId = 0)
    {
        try {
            $points = $rewardData['points'];
            $customerId = $rewardData['customer_id'];
            $entityId = $this->checkAlreadyExists($customerId);
            $remainingPoints = 0;
            $usedPoints = 0;
            $totalPoints = 0;
            $id = '';
            if ($entityId) {
                $rewardRecord = $this->_rewardRecordRepository->getById($entityId);
                $remainingPoints = $rewardRecord->getRemainingRewardPoint();
                $usedPoints = $rewardRecord->getUsedRewardPoint();
                $totalPoints = $rewardRecord->getTotalRewardPoint();
                $id = $entityId;
            }
            if ($rewardData['type']=='credit') {
                $remainingPoints += $points;
                $totalPoints += $points;
            } else {
                $usedPoints += $points;
                $remainingPoints -= $points;
            }
            if ($remainingPoints<0) {
                throw new LocalizedException(
                    __('Remaining Reward Point can not be less than zero.')
                );
            }
            $recordData = [
                'customer_id' => $customerId,
                'total_reward_point' => $totalPoints,
                'remaining_reward_point' => $remainingPoints,
                'used_reward_point' => $usedPoints,
                'updated_at' => $this->_date->gmtDate()
            ];
            if ($id) {
                $recordData['entity_id'] = $id;
            }

            $dataObjectRewardRecord = $this->_rewardRecordInterface->create();

            $customer = $this->_customerModel
                ->create()
                ->load($customerId);

            $this->_dataObjectHelper->populateWithArray(
                $dataObjectRewardRecord,
                $recordData,
                \Seoudi\RewardSystem\Api\Data\RewardrecordInterface::class
            );
            $this->saveDataRewardRecord($dataObjectRewardRecord);
            $expiresDays = (int)$this->getconfigData('expires_after_days');
            if (isset($rewardData['reward_id']) && $expiresDays) {
                $date = $this->_date->gmtDate(
                    'Y-m-d',
                    $this->_date->gmtTimestamp() + $expiresDays * 24 * 60 * 60
                );
                $transaction = $this->_rewardDetailInterface->create()
                            ->load($rewardData['reward_id']);
                $transaction->setExpiresAt($date)->save();
            }


        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Update Reward Order Detail Data
     *
     * @param object $order
     */
    public function updateRewardOrderDetailData($order)
    {
        foreach ($order->getAllVisibleItems() as $_item) {
            $rewardOrderDetail = $this->_RewardorderDetailFactory->create();
            $orderItem = $this->_RewardproductFactory->create()->getCollection()->
            addFieldToFilter('product_id', $_item->getProductId());
            $itemRewardData = $orderItem->getData();
            $itemRewardPoint = $itemRewardData[0]["points"];
            if ($this->getrewardQuantityWise()) {
                $itemRewardPoint *= $_item->getQtyOrdered();
            }
            if ($itemRewardData[0]["status"] == 1) {
                $rewardOrderDetail->addData([
                    "order_id" => $order->getId(),
                    "item_id" => $_item->getProductId(),
                    "points" => $itemRewardPoint,
                    "qty" => $_item->getQtyOrdered(),
                    "is_qty_wise" => $this->getrewardQuantityWise()
                ]);
                $rewardOrderDetail->save();
            }
        }
    }

    /**
     * Get Reward Order Detail Data
     *
     * @param array $order
     * @param array $itemId
     * @param int   $qty
     */
    public function getRewardOrderDetailData($order, $itemId, $qty)
    {
        $reward = $this->_RewardorderDetailFactory->create()->getCollection()->
        addFieldToFilter('order_id', $order->getId());
        $data = $reward->addFieldToFilter('item_id', $itemId)->getData();
        if ($data) {
            if ($data[0]["is_qty_wise"]) {
                $rewardPointPerItem = $data[0]["points"] / $data[0]["qty"];
                $rewardPoint = $rewardPointPerItem * $qty;
                return $rewardPoint;
            } else {
                $rewardPoint = $data[0]["points"];
                return $rewardPoint;
            }
        }
    }

    /**
     * Check Already Exists
     *
     * @param int $customerId
     */
    public function checkAlreadyExists($customerId)
    {
        $rowId = 0;
        $rewardRecordCollection = $this->_rewardRecordCollection->create()
            ->addFieldToFilter('customer_id', $customerId);
        if ($rewardRecordCollection->getSize()) {
            foreach ($rewardRecordCollection as $rewardRecord) {
                $rowId = $rewardRecord->getEntityId();
            }
        }
        return $rowId;
    }

    /**
     * Set Product Reward Data
     *
     * @param array $rewardProductData
     */
    public function setProductRewardData($rewardProductData)
    {
        $dataObjectProductDetail = $this->_rewardProductInterface->create();
        $this->_dataObjectHelper->populateWithArray(
            $dataObjectProductDetail,
            $rewardProductData,
            \Seoudi\RewardSystem\Api\Data\RewardproductInterface::class
        );
        try {
            $this->_rewardProductRepository->save($dataObjectProductDetail);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Set Category Reward Data
     *
     * @param array $rewardCategoryData
     */
    public function setCategoryRewardData($rewardCategoryData)
    {
        $dataObjectCategoryDetail = $this->_rewardCategoryInterface->create();
        $this->_dataObjectHelper->populateWithArray(
            $dataObjectCategoryDetail,
            $rewardCategoryData,
            \Seoudi\RewardSystem\Api\Data\RewardcategoryInterface::class
        );
        try {
            $this->_rewardCategoryRepository->save($dataObjectCategoryDetail);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Set Product Specific Reward Data
     *
     * @param array $rewardProductData
     */
    public function setProductSpecificRewardData($rewardProductData)
    {
        $dataObjectProductDetail = $this->_rewardproductSpecificInterface->create();
        $this->_dataObjectHelper->populateWithArray(
            $dataObjectProductDetail,
            $rewardProductData,
            \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface::class
        );
        try {
            $this->_rewardproductSpecificRepository->save($dataObjectProductDetail);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Set Category Specific Reward Data
     *
     * @param array $rewardCategoryData
     */
    public function setCategorySpecificRewardData($rewardCategoryData)
    {
        $dataObjectCategoryDetail = $this->_rewardcategorySpecificInterface->create();
        $this->_dataObjectHelper->populateWithArray(
            $dataObjectCategoryDetail,
            $rewardCategoryData,
            \Seoudi\RewardSystem\Api\Data\RewardcategorySpecificInterface::class
        );
        try {
            $this->_rewardcategorySpecificRepository->save($dataObjectCategoryDetail);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Calculate Credit Amount for order for Priority Based
     *
     * @param int    $orderId
     * @param string $order
     */
    public function calculateCreditAmountforOrder($orderId = 0, $order = null)
    {
        $rewardPoint = 0;
        $priority = $this->getrewardPriority();
        if ($priority==0) {
            //product based
            $quantityWise = $this->getrewardQuantityWise();
            if ($order) {
                $cartData = $order->getAllVisibleItems();
            } elseif ($orderId!=0) {
                $order = $this->_orderModel->create()->load($orderId);
                $cartData = $order->getAllVisibleItems();
            } else {
                $cartData = $this->cartModel->getQuote()->getAllVisibleItems();
            }

            foreach ($cartData as $item) {
                if ($item['product_type'] == 'configurable' || $item['product_type'] == 'bundle') {
                    foreach ($item->getChildrenItems() as $singleItem) {
                        $rewardPoint += $this->getProductData($singleItem, $quantityWise);
                    }
                }
                $rewardPoint += $this->getProductData($item, $quantityWise);
            }
        } elseif ($priority==1) {
            //cart based
            $amount = $this->getGrandTotal($orderId);
            $rewardPoint = $this->getRewardBasedOnRules($amount);
        } elseif ($priority==2) {
          //category based
            if ($order) {
                $cartData = $order->getAllVisibleItems();
            } elseif ($orderId!=0) {
                $order = $this->_orderModel->create()->load($orderId);
                $cartData = $order->getAllVisibleItems();
            } else {
                $cartData = $this->cartModel->getQuote()->getAllVisibleItems();
            }
            foreach ($cartData as $item) {
                $rewardPoint += $this->getCategoryData($item);
            }
        } else {
            if ($order) {
                $cartData = $order->getAllVisibleItems();
            } elseif ($orderId!=0) {
                $order = $this->_orderModel->create()->load($orderId);
                $cartData = $order->getAllItems();
            } else {
                $cartData = $this->cartModel->getQuote()->getAllItems();
            }
            foreach ($cartData as $item) {
                $rewardPoint += $this->getAttributeData($item);
            }
        }
        if (!$rewardPoint) {
            return 0;
        }
        return $rewardPoint;
    }

    /**
     * Get Attribute Data
     *
     * @param object $item
     */
    public function getAttributeData($item)
    {
        $productId = $item->getProduct()->getId();
        $rewardpoint = 0;
        $product = $this->loadProduct($productId);
        $optionId = $product->getData($this->getAttributeCode());
        $attributeCode = $this->getAttributeCode();
        $collection = $this->_rewardattributeCollection->create()
                    ->addFieldToFilter('option_id', ['eq'=>$optionId])
                    ->addFieldToFilter('attribute_code', ['eq'=>$attributeCode])
                    ->addFieldToFilter('status', ['eq'=>1]);
        if ($collection->getSize()) {
            foreach ($collection as $attributeData) {
                $rewardpoint = $attributeData->getPoints();
            }
        }
        return $rewardpoint;
    }

    /**
     * Get Category Data
     *
     * @param object $item
     */
    public function getCategoryData($item)
    {
        $rewardpoint = $this->getCategorySpecificData($item);
        $categoryIds = $item->getProduct()->getCategoryIds();
        $categoryReward = [];
        if (is_array($categoryIds) && !$rewardpoint) {
            $categoryRewardCollection = $this->_rewardcategoryCollection
                                    ->create()
                                    ->addFieldToFilter('status', ['eq'=>1])
                                    ->addFieldToFilter('category_id', ['in'=>$categoryIds]);
            if ($categoryRewardCollection->getSize()) {
                foreach ($categoryRewardCollection as $categoryRule) {
                    $categoryReward[] = $categoryRule->getPoints();
                }
                if (!empty($categoryReward)) {
                    $rewardpoint = max($categoryReward);
                }
            }
        }
        return $rewardpoint;
    }



    /**
     * Get SubTotal
     *
     * @param int $orderId
     */
    public function getSubTotal($orderId)
    {
        $subTotal = 0;
        $order = $this->_orderModel->create()->load($orderId);
        $subTotal = $order->getSubtotal();
        return $subTotal;
    }

    /**
     * Get Grand Total
     *
     * @param int $orderId
     */
    public function getGrandTotal($orderId)
    {
        $grandTotal = 0;
        $order = $this->_orderModel->create()->load($orderId);
        $grandTotal = $order->getGrandtotal();
        return $grandTotal;
    }

    /**
     * Get Reward Based On Rules
     *
     * @param int $amount
     */
    public function getRewardBasedOnRules($amount)
    {
        $today = $this->_date->gmtDate('Y-m-d');
        $reward = 0;
        $rewardCartruleCollection = $this->_rewardcartCollection
            ->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('start_date', ['lteq' => $today])
            ->addFieldToFilter('end_date', ['gteq' => $today])
            ->addFieldToFilter('amount_from', ['lteq'=>$amount])
            ->addFieldToFilter('amount_to', ['gteq'=>$amount]);
        if ($rewardCartruleCollection->getSize()) {
            foreach ($rewardCartruleCollection as $cartRule) {
                $reward = $cartRule->getPoints();
            }
        }
        return $reward;
    }

    /**
     * Get Product Data
     *
     * @param object $item
     * @param bool   $quantityWise
     */
    public function getProductData($item, $quantityWise)
    {
        $productId = $item->getProduct()->getId();
        $rewardpoint = 0;
        $qty = 0;
        $reward = $this->getProductReward($item->getProductId());
        if ($item->getOrderId() && $item->getOrderId()!=0) {
            $qty = $item->getQtyOrdered();
        } else {
            $qty = $item->getQty();
        }
        if ($quantityWise) {
            $rewardpoint = $reward * $qty;
        } else {
            $rewardpoint = $reward;
        }
        return $rewardpoint;
    }

    /**
     * Get Product Reward
     *
     * @param int $productId
     */
    public function getProductReward($productId)
    {
        $reward = $this->getProductSpecificData($productId);
        if (!$reward) {
            $productCollection = $this->_rewardProductCollection->create()
                               ->addFieldToFilter('product_id', ['eq'=>$productId])
                               ->addFieldToFilter('status', ['eq'=>1]);
            if ($productCollection->getSize()) {
                foreach ($productCollection as $productData) {
                    if ($productData->getPoints()) {
                        $reward = $productData->getPoints();
                    }
                }
            }
        }
        return $reward;
    }





    /**
     * Get Product Reward To Show
     *
     * @param int $productId
     */
    public function getProductRewardToShow($productId)
    {
        list($reward, $status, $message) = $this->getProductSpecificDataToShow($productId);
        if (!$status) {
            $productCollection = $this->_rewardProductCollection->create()
                             ->addFieldToFilter('product_id', ['eq'=>$productId])
                             ->addFieldToFilter('status', ['eq'=>1]);
            if ($productCollection->getSize()) {
                foreach ($productCollection as $productData) {
                    if ($productData->getPoints()) {
                        $reward = $productData->getPoints();
                        $status = false;
                        $message = '';
                    }
                }
            }
        }
        return [$reward, $status, $message];
    }

    /**
     * Get Product Specific Data To Show
     *
     * @param int $productId
     */
    public function getProductSpecificDataToShow($productId)
    {
        $reward = 0;
        $status = false;
        $message = '';
        $productCollection = $this->_rewardproductSpecificCollection->create()
                           ->addFieldToFilter('product_id', ['eq'=>$productId])
                           ->addFieldToFilter('status', ['eq'=>1]);
        $curTime = $this->_date->gmtDate('H:i');
        $currentTime = $this->getTimeAccordingToTimeZone($curTime);
        if ($productCollection->getSize()) {
            foreach ($productCollection as $productData) {
                if ($productData->getPoints()) {
                    $startTime = $this->getTimeAccordingToTimeZone($productData->getStartTime());
                    $endTime = $this->getTimeAccordingToTimeZone($productData->getEndTime());
                    if ((strtotime($currentTime) >= strtotime($startTime)) &&
                     (strtotime($currentTime) <= strtotime($endTime))) {
                        $reward = $productData->getPoints();
                        $status = true;
                        $message = $this->_date->gmtDate(
                            'h:i A',
                            strtotime($startTime)
                        ).' - '.$this->_date->gmtDate('h:i A', strtotime($endTime));
                    }
                }
            }
        }
        return [$reward, $status, $message];
    }

    /**
     * Get Product Specific Data
     *
     * @param int $productId
     */
    public function getProductSpecificData($productId)
    {
        $reward = 0;
        $productCollection = $this->_rewardproductSpecificCollection->create()
                           ->addFieldToFilter('product_id', ['eq'=>$productId])
                           ->addFieldToFilter('status', ['eq'=>1]);
        if ($productCollection->getSize()) {
            $cur_time = $this->_date->gmtDate('H:i');
            $currentTime = $this->getTimeAccordingToTimeZone($cur_time);
            foreach ($productCollection as $productData) {
                $startTime = $this->getTimeAccordingToTimeZone($productData->getStartTime());
                $endTime = $this->getTimeAccordingToTimeZone($productData->getEndTime());
                if ((strtotime($currentTime) >= strtotime($startTime)) &&
                 (strtotime($currentTime) <= strtotime($endTime)) &&
                $productData->getPoints()) {
                    $reward = $productData->getPoints();
                }
            }
        }
        return $reward;
    }

    /**
     * Get Attribute Options List
     *
     * @return array
     */
    public function getOptionsList()
    {
        $optionsList = ['' => 'Please Select'];
        $attribute = $this->eavConfig->getAttribute('catalog_product', $this->getAttributeCode());
        $options = $attribute->getSource()->getAllOptions();
        foreach ($options as $option) {
            if (isset($option['value']) && $option['value']) {
                $optionsList[$option['value']] = $option['label'];
            }
        }
        return $optionsList;
    }

    /**
     * Get Attribute Options Values
     *
     * @return array
     */
    public function getOptionsValues()
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', $this->getAttributeCode());
        $options = $attribute->getSource()->getAllOptions();
        return $options;
    }

    /**
     * Get Status List
     *
     * @return array
     */
    public function getStatusValues()
    {
        $statusList = [
            [
                'label' => __('Enabled'),
                'value' => 1
            ],
            [
                'label' => __('Disabled'),
                'value' => 0
            ]
        ];
        return $statusList;
    }

    /**
     * Get Status List
     *
     * @return array
     */
    public function getRewardPointStatusValues()
    {
        $statusList = [
            [
                'label' => __('Enable'),
                'value' => 1
            ],
            [
                'label' => __('Disable'),
                'value' => 0
            ]
        ];
        return $statusList;
    }

    /**
     * Get Attribute Code for Attribute Rule
     *
     * @return string
     */
    public function getAttributeCode()
    {
        return  $this->scopeConfig->getValue(
            'rewardsystem/general_settings/attribute_reward',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get reward points for the cart
     *
     * @return mixed
     */
    public function getCartReward()
    {
        $today = $this->_date->gmtDate('Y-m-d');
        $amountFrom = 0;
        $amonutTo = 0;
        $reward = 0;
        $cartAmount = $this->getCartTotal();
        $rewardCartruleCollection = $this->_rewardcartCollection
          ->create()
          ->addFieldToFilter('status', 1)
          ->addFieldToFilter('start_date', ['lteq' => $today])
          ->addFieldToFilter('end_date', ['gteq' => $today])
          ->addFieldToFilter('amount_from', ['lteq' => $cartAmount])
          ->addFieldToFilter('amount_to', ['gteq' => $cartAmount]);
        if ($rewardCartruleCollection->getSize()) {
            foreach ($rewardCartruleCollection as $cartRule) {
                $reward = $cartRule->getPoints();
                $amountFrom = $cartRule->getAmountFrom();
                $amonutTo = $cartRule->getAmountTo();
            }
        }
        return [
        'reward' => $reward,
        'amount_from' => $amountFrom,
        'amount_to' => $amonutTo
        ];
    }

    /**
     * Get Cart Data cart Quantity for show Message on Cart Page
     *
     * @return int
     */
    public function getCartData()
    {
        return $this->cartModel->getQuote()->getItemsCount();
    }

    /**
     * Get Cart All Data cart Complete Data for show Message on Cart Page
     *
     * @return array
     */
    public function getCartAllData()
    {
        return $this->cartModel->getQuote()->getItemsCollection();
    }

    /**
     * Get Cart Total Cart Grand Total For Show Reward Ponit on Cart Page
     *
     * @return float
     */
    public function getCartTotal()
    {
        return $this->cartModel->getQuote()->getGrandTotal();
    }

    /**
     * Get Order Url by Order Id
     *
     * @param  integer $orderId
     * @return string Order view Url
     */
    public function getOrderUrl($orderId = 0)
    {
        return $this->_getUrl(
            'sales/order/view',
            ['order_id'=> $orderId]
        );
    }

    /**
     * Clean Cache
     */
    public function clearCache()
    {
        $cacheManager = $this->cacheManager->create();
        $availableTypes = $cacheManager->getAvailableTypes();
        $cacheManager->clean($availableTypes);
    }

    /**
     * Prepare transaction note on priority wise
     *
     * @param int $incrementId
     */
    public function getTransactionNotePriorityWise($incrementId)
    {
        $priority = $this->getrewardPriority();
        $transactionNote = __('Order id : %1 credited amount', $incrementId);
        if ($priority == 3) {
            $transactionNote = __('Order id : %1 credited amount in way', $incrementId);
        }
        return $transactionNote;
    }

    /**
     * Load Customer Data
     *
     * @param string $customerId
     *
     * @return object
     */
    public function loadCustomer($customerId = '')
    {
        if ($customerId == '') {
            $customerId = $this->_customerSession->getCustomer()->getId();
        }
        $customer = $this->_customerModel->create()->load($customerId);
        return $customer;
    }

    /**
     * Load Product Data
     *
     * @param string $productId
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function loadProduct($productId)
    {
        $product = $this->productModel->create()->load($productId);
        return $product;
    }

    /**
     * Get Product Reward Info
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return mixed
     */
    public function getProductRewardInfo($product)
    {
        $productPrice = $product->getFinalPrice();
        $rewardValue = $this->getRewardValue();
        $pointsRequired = $productPrice/$rewardValue;
        $productId = $product->getId();
        list($productRewardPoints, $status, $message) = $this->getProductRewardToShow($productId);

        $minPrice = $maxPrice = $sumOfRewardPoints = $minRewardPoint = $maxRewardPoint = 0;

        if ($product->getTypeId() == 'bundle') {
            $minimalPrice = $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
            $maximalprice = $product->getPriceInfo()->getPrice('final_price')->getMaximalPrice()->getValue();

            $bundledProduct = $product->getTypeInstance(true)->getOptions($product);
            $bundledProductIds = $product->getTypeInstance(true)->getChildrenIds($product->getId(), true);

            list($parentRewardPoint, $parentStatus, $parentMessage) =  $this->getProductRewardToShow($product->getId());
            $minPrice = $minimalPrice;
            $maxPrice = $maximalprice;
            $maxRewardPoint = 0;

            $minRewardPoint = 0;
            $sumOfRewardPoints = 0;
            $message = '';
            $status = false;
            if ($parentMessage != null) {
                $message = $parentMessage;
            }
            if ($parentStatus == true) {
                $status = true;
            }

            foreach ($bundledProduct as $child) {
                $bundleChildPro = $bundledProductIds[$child['option_id']];
                $childType = $child['type'];
                $childMaxRPForRadio = 0;
                $childMaxRPForSelect = 0;
                $childMaxRPForMulti = 0;
                $childMaxRPForCheckBox = 0;

                $childMinRPForRadio = 0;
                $childMinRPForSelect = 0;
                $childMinRPForMulti = 0;
                $childMinRPForCheckBox = 0;

                foreach ($bundleChildPro as $subchild) {
                    list($rewardPoint, $childStatus, $childMessage) =  $this->getProductRewardToShow($subchild);
                    if ($childMessage != null) {
                        $message = $childMessage;
                    }
                    if ($childStatus == true) {
                        $status = true;
                    }
                    if ($childType == 'radio') {
                        $childMinRPForRadio = 9999999;
                        if ($rewardPoint > $childMaxRPForRadio) {
                            $childMaxRPForRadio = $rewardPoint;
                        }
                        if ($rewardPoint < $childMinRPForRadio) {
                            $childMinRPForRadio = $rewardPoint;
                        }
                    }
                    if ($childType == 'select') {
                        $childMinRPForSelect = 99999999;
                        if ($rewardPoint > $childMaxRPForSelect) {
                            $childMaxRPForSelect = $rewardPoint;
                        }
                        if ($rewardPoint < $childMinRPForSelect) {
                            $childMinRPForSelect = $rewardPoint;
                        }
                    }
                    if ($childType == 'checkbox') {
                        $childMinRPForCheckBox = 9999999999999;
                            $childMaxRPForCheckBox += $rewardPoint;
                        if ($rewardPoint < $childMinRPForCheckBox) {
                            $childMinRPForCheckBox = $rewardPoint;
                        }
                    }
                    if ($childType == 'multi') {
                        $childMinRPForMulti = 99999999999;
                            $childMaxRPForMulti += $rewardPoint;
                        if ($rewardPoint < $childMinRPForMulti) {
                            $childMinRPForMulti = $rewardPoint;
                        }
                    }
                }
                $childMaxRewardPoints = $childMaxRPForRadio + $childMaxRPForSelect + $childMaxRPForMulti +
                $childMaxRPForCheckBox;
                $childMinRewardPoints = $childMinRPForRadio + $childMinRPForSelect + $childMinRPForMulti +
                $childMinRPForCheckBox;

                $maxRewardPoint += $childMaxRewardPoints;
                $minRewardPoint += $childMinRewardPoints;
            }
            $maxRewardPoint += $parentRewardPoint;
            $minRewardPoint += $parentRewardPoint;
            $pointsRequired = round($maxRewardPoint, 0);
            $productRewardPoints = round($maxRewardPoint, 0);
        }

        if ($product->getTypeId() == 'grouped') {
            $usedProds = $product->getTypeInstance(true)->getAssociatedProducts($product);
            $maxPrice = 0;
            $minPrice = 999999999;
            $minRewardPoint = 99999999999;
            $maxRewardPoint = 0;
            $message = '';
            $status = false;

            foreach ($usedProds as $child) {
                if ($child->getId() != $product->getId()) {
                    list($rewardPoint, $childStatus, $childMessage) =  $this->getProductRewardToShow($child->getId());
                    if ($childMessage != null) {
                        $message = $childMessage;
                    }
                    if ($childStatus == true) {
                        $status = true;
                    }
                    $maxPrice += $child->getFinalPrice();

                    if ($child->getFinalPrice() < $minPrice) {
                        $minPrice = $child->getFinalPrice();
                    }
                    if ($rewardPoint < $minRewardPoint) {
                        $minRewardPoint = $rewardPoint;
                    }
                    $maxRewardPoint += $rewardPoint;
                }
            }
            if ($minRewardPoint == $maxRewardPoint) {
                $minRewardPoint = 0;
            }
                $minRewardPoint = round($minRewardPoint, 0);
                $maxRewardPoint = round($maxRewardPoint, 0);
                $pointsRequired = $maxRewardPoint;
                $productRewardPoints = $maxRewardPoint;
                $minPrice = $minPrice/$rewardValue;
                $maxPrice = $maxPrice/$rewardValue;
        }

        if ($product->getTypeId() == 'configurable') {
            $usedProds = $product->getTypeInstance(true)->getUsedProducts($product);
            list($parentRewardPoint, $parentStatus, $parentMessage) =  $this->getProductRewardToShow($product->getId());
            $maxPrice = 0;
            $minPrice = 999999999;
            $maxRewardPoint = 0;

            $minRewardPoint = 999999999;
            $sumOfRewardPoints = 0;
            $message = '';
            $status = false;
            if ($parentMessage != null) {
                $message = $parentMessage;
            }
            if ($parentStatus == true) {
                $status = true;
            }

            foreach ($usedProds as $child) {
                if ($child->getId() != $product->getId()) {
                    list($rewardPoint, $childStatus, $childMessage) =  $this->getProductRewardToShow($child->getId());
                    $sumOfRewardPoints += $rewardPoint;
                    if ($childMessage != null) {
                        $message = $childMessage;
                    }
                    if ($childStatus == true) {
                        $status = true;
                    }
                    if ($maxPrice < $child->getFinalPrice()) {
                        $maxPrice = $child->getFinalPrice();
                    }
                    if ($child->getFinalPrice() < $minPrice) {
                        $minPrice = $child->getFinalPrice();
                    }
                    if ($rewardPoint < $minRewardPoint) {
                        $minRewardPoint = $rewardPoint;
                    }
                    if ($rewardPoint > $maxRewardPoint) {
                        $maxRewardPoint = $rewardPoint;
                    }
                }
            }
                $minRewardPoint = round(($minRewardPoint + $parentRewardPoint), 0);
                $maxRewardPoint = round(($maxRewardPoint + $parentRewardPoint), 0);
                $minPrice = $minPrice/$rewardValue;
                $maxPrice = $maxPrice/$rewardValue;
                $pointsRequired = $maxPrice;
                $productRewardPoints = $maxRewardPoint;
            if ($sumOfRewardPoints == 0) {
                $productRewardPoints = round($parentRewardPoint, 0);
            }
        }

        return [
            $productRewardPoints,
            $minPrice,
            $maxPrice,
            $pointsRequired,
            $sumOfRewardPoints,
            $minRewardPoint,
            $maxRewardPoint,
            $status,
            $message
        ];
    }

    /**
     * Function get Json Serializer
     *
     * @return \Magento\Framework\Serialize\Serializer\Json
     */
    public function getJsonSerializer()
    {
        return $this->json;
    }

    /**
     * Function get reward info from quote
     *
     * @param object $quote
     * @return array|string
     */
    public function getRewardInfoFromQuote($quote)
    {
        if ($quote->getRewardInfo()) {
            return $this->json->unserialize($quote->getRewardInfo());
        }
        return '';
    }

    /**
     * Function set reward info in quote
     *
     * @param object $quote
     * @param array|string $rewardInfo
     * @return void
     */
    public function setRewardInfoInQuote($quote, $rewardInfo)
    {
        if (is_array($rewardInfo)) {
            $rewardInfo = $this->json->serialize($rewardInfo);
        }
        $quote->setRewardInfo($rewardInfo)->save();
    }

    /**
     * Function unset reward info in quote
     *
     * @param object $quote
     * @return void
     */
    public function unsetRewardInfoInQuote($quote)
    {
        $this->setRewardInfoInQuote($quote, '');
    }
}
