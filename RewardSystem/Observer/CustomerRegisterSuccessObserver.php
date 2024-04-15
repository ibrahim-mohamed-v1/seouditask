<?php
namespace Seoudi\RewardSystem\Observer;

use Magento\Framework\Event\ObserverInterface;
use Seoudi\RewardSystem\Helper\Data as RewardSystemHelper;
use Seoudi\RewardSystem\Api\Data\RewardrecordInterfaceFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Seoudi\RewardSystem\Api\RewardrecordRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerRegisterSuccessObserver implements ObserverInterface
{
    /**
     * @var RewardSystemHelper
     */
    protected $_rewardSystemHelper;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
     /**
      * @var DataObjectHelper
      */
    protected $_dataObjectHelper;

    /**
     * @var RewardrecordInterfaceFactory
     */
    protected $_rewardRecordInterface;

    /**
     * @var DateTime
     */
    protected $_date;

    /**
     * @var RewardrecordRepositoryInterface
     */
    protected $_rewardRecordRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $formdata;

    /**
     * @param RewardSystemHelper                      $rewardSystemHelper
     * @param DataObjectHelper                        $dataObjectHelper
     * @param RewardrecordInterfaceFactory            $rewardRecordInterface
     * @param ManagerInterface                        $messageManager
     * @param RewardrecordRepositoryInterface         $rewardRecordRepository
     * @param DateTime                                $datetime
     * @param \Magento\Framework\App\RequestInterface $request
     * @param LoggerInterface                         $logger
     * @param CustomerRepositoryInterface             $customerRepository
     * @param \Magento\Framework\App\Request\Http     $formdata
     */
    public function __construct(
        RewardSystemHelper $rewardSystemHelper,
        DataObjectHelper $dataObjectHelper,
        RewardrecordInterfaceFactory $rewardRecordInterface,
        ManagerInterface $messageManager,
        RewardrecordRepositoryInterface $rewardRecordRepository,
        DateTime $datetime,
        \Magento\Framework\App\RequestInterface $request,
        LoggerInterface $logger,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\Request\Http $formdata
    ) {
        $this->_rewardSystemHelper = $rewardSystemHelper;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_rewardRecordInterface = $rewardRecordInterface;
        $this->_messageManager = $messageManager;
        $this->_rewardRecordRepository = $rewardRecordRepository;
        $this->_date = $datetime;
        $this->_request = $request;
        $this->logger = $logger;
        $this->customerRepository = $customerRepository;
        $this->formdata = $formdata;
    }
    /**
     * Cart save after observer.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getCustomer();
        $dob = $this->formdata->getParam('dob');
        if ($dob != null) {
            $customer->setDob($dob);
            $this->customerRepository->save($customer);
        }
        $helper = $this->_rewardSystemHelper;
        $enableRewardSystem = $helper->enableRewardSystem();
        if ($helper->getAllowRegistration() && $enableRewardSystem && $helper->getRewardOnRegistration()) {
            $customerId = $customer->getId();
            $transactionNote = __("Reward point on registration");
            $rewardValue = $helper->getRewardValue();
            $rewardPoints = $helper->getRewardOnRegistration();
            $rewardData = [
                'customer_id' => $customerId,
                'points' => $rewardPoints,
                'type' => 'credit',
                'review_id' => 0,
                'order_id' => 0,
                'status' => 1,
                'note' => $transactionNote
            ];
            $msg = __(
                'You got %1 reward points on registration',
                $rewardPoints
            )->render();
            $adminMsg = __(
                ' have registered on your site, and got %1 reward points',
                $rewardPoints
            )->render();
            $helper->setDataFromAdmin(
                $msg,
                $adminMsg,
                $rewardData
            );
            $this->_messageManager->addSuccess(__(
                'You got %1 reward points on registration',
                $rewardPoints
            ));
        }
    }
}
