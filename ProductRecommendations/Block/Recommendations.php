<?php

namespace Seoudi\ProductRecommendations\Block;


use Magento\Framework\View\Element\Template;
use  Magento\Catalog\Block\Product\Context;
use Vendor\Recommendations\Model\ResourceModel\UserBrowsingHistory\CollectionFactory as BrowsingHistoryCollectionFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Block\Product\ProductList\Related;
class Recommendations extends \Magento\Catalog\Block\Product\AbstractProduct
{
    protected $browsingHistoryCollectionFactory;
    protected $customerSession;
    protected $productRepository;
    private \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Seoudi\ProductRecommendations\Model\ResourceModel\UserBrowsingHistory\CollectionFactory $browsingHistoryCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->browsingHistoryCollectionFactory = $browsingHistoryCollectionFactory;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Retrieve the browsing history for the current customer
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getCustomerBrowsingHistory()
    {
        $products = [];
//        if ($this->customerSession->isLoggedIn()) {
        if (true) {
//            $customerId = $this->customerSession->getCustomerId();
            $customerId = 2;

            $collection = $this->browsingHistoryCollectionFactory->create()
                ->addFieldToFilter('customer_id', $customerId)
                ->setPageSize(6)
                ->setOrder('viewed_at', 'desc');

            foreach ($collection as $history) {
                try {
                    $products[] = $this->productRepository->getById($history->getProductId());
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                    // Handle the case where the product does not exist
                }
            }
        }
        return $products;
    }

    public function getLastPurchasedProducts()
    {
        $products = [];
        $productIds = [];
//        if ($this->customerSession->isLoggedIn()) {
        if (true) {
//            $customerId = $this->customerSession->getCustomerId();
            $customerId = 2;
            $orders = $this->orderCollectionFactory->create()
                ->addFieldToFilter('customer_id', $customerId)
                ->setOrder('created_at', 'DESC')
                ->setPageSize(5); // Adjust based on how many orders you want to consider

            foreach ($orders as $order) {
                foreach ($order->getAllVisibleItems() as $item) {
                    $productId = $item->getProductId();
                    if (!in_array($productId, $productIds)) {

                        $products[] = $item->getProduct();
                        $productIds[] = $productId; // Keep track of added product IDs

                        if (count($products) == 5) {
                            break 2; // Exit both loops if we have collected 5 unique products
                        }
                    }
                }
            }
        }
        return $products;
    }

}
