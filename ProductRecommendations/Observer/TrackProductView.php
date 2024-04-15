<?php

namespace Seoudi\ProductRecommendations\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Seoudi\ProductRecommendations\Model\UserBrowsingHistoryFactory;
use Seoudi\ProductRecommendations\Model\ResourceModel\UserBrowsingHistory\CollectionFactory as UserBrowsingHistoryCollectionFactory;

class TrackProductView implements ObserverInterface
{
    protected $customerSession;
    protected $date;
    protected $userBrowsingHistoryFactory;
    private UserBrowsingHistoryCollectionFactory $userBrowsingHistoryCollectionFactory;

    public function __construct(
        CustomerSession $customerSession,
        DateTime $date,
        UserBrowsingHistoryFactory $userBrowsingHistoryFactory,
        UserBrowsingHistoryCollectionFactory $userBrowsingHistoryCollectionFactory // Inject the collection factory
    ) {
        $this->customerSession = $customerSession;
        $this->date = $date;
        $this->userBrowsingHistoryFactory = $userBrowsingHistoryFactory;
        $this->userBrowsingHistoryCollectionFactory = $userBrowsingHistoryCollectionFactory; // Initialize the property

    }

    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        // Check if customer is logged in
        if ($this->customerSession->isLoggedIn()) {
            $customerId = $this->customerSession->getCustomerId(); // Correct way to get customer ID
        } else {
            $customerId = null; // Customer is not logged in
        }
        $productId = $product->getId();
        $viewedAt = $this->date->gmtDate();

        $existingRecord = $this->userBrowsingHistoryCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('product_id', $productId)
            ->setPageSize(1) // We're only interested if at least one record exists
            ->getFirstItem();

        if (!$existingRecord->getId()) {
            // Instantiate the model to save the data
            $history = $this->userBrowsingHistoryFactory->create();
            $history->setData([
                'customer_id' => $customerId,
                'product_id' => $productId,
                'viewed_at' => $viewedAt
            ]);
            $history->save();
        }
    }

}
