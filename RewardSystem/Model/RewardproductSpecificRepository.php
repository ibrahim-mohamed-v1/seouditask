<?php

namespace Seoudi\RewardSystem\Model;

use Seoudi\RewardSystem\Api\Data;
use Seoudi\RewardSystem\Api\RewardproductSpecificRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Seoudi\RewardSystem\Model\ResourceModel\RewardproductSpecific as RewardProductResource;
use Seoudi\RewardSystem\Model\BlockCollectionFactory;
use Seoudi\RewardSystem\Model\BlockFactory;
use Seoudi\RewardSystem\Model\PreorderComplete;
use Seoudi\RewardSystem\Model\ResourceBlock;
use Seoudi\RewardSystem\Model\ResourceModel\RewardproductSpecific\CollectionFactory as RewardproductSpecificCollection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Seoudi\RewardSystem\Api\Data\RewardproductSpecificSearchResultsInterface;
use Seoudi\RewardSystem\Model\RewardproductSpecificFactory;

/**
 * Class RewardproductSpecificRepository is used for the reward product for specific time
 */
class RewardproductSpecificRepository implements RewardproductSpecificRepositoryInterface
{
    /**
     * @var ResourceBlock
     */
    protected $resource;

    /**
     * @var BlockFactory
     */
    protected $rewardproductSpecificFactory;

    /**
     * @var BlockCollectionFactory
     */
    protected $rewardproductSpecificCollectionFactory;

    /**
     * @var Data\RewardproductSpecificSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param RewardProductResource $resource
     * @param RewardproductSpecificFactory $rewardproductSpecificFactory
     * @param RewardproductSpecificCollection $rewardproductSpecificCollectionFactory
     * @param Data\RewardproductSpecificSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        RewardProductResource $resource,
        RewardproductSpecificFactory $rewardproductSpecificFactory,
        RewardproductSpecificCollection $rewardproductSpecificCollectionFactory,
        Data\RewardproductSpecificSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->rewardproductSpecificFactory = $rewardproductSpecificFactory;
        $this->rewardproductSpecificCollectionFactory = $rewardproductSpecificCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Preorder Complete data
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $rewardProduct
     * @return PreorderComplete
     * @throws CouldNotSaveException
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $rewardProduct)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $rewardProduct->setStoreId($storeId);
        try {
            $this->resource->save($rewardProduct);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $rewardProduct;
    }

    /**
     * Load Preorder Complete data by given Block Identity
     *
     * @param string $id
     * @return PreorderComplete
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $rewardProduct = $this->rewardproductSpecificFactory->create();
        $this->resource->load($rewardProduct, $id);
        if (!$rewardProduct->getEntityId()) {
            throw new NoSuchEntityException(__('Reward Product with id "%1" does not exist.', $id));
        }
        return $rewardProduct;
    }

    /**
     * Load RewardproductSpecific data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return RewardproductSpecificSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->rewardproductSpecificCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete PreorderComplete
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $rewardProduct
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $rewardProduct)
    {
        try {
            $this->resource->delete($rewardProduct);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete PreorderComplete by given Block Identity
     *
     * @param string $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
