<?php

namespace Seoudi\RewardSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for RewardproductSpecific search results.
 */
interface RewardproductSpecificSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get RewardproductSpecific list.
     *
     * @return \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface[]
     */
    public function getItems();

    /**
     * Set RewardproductSpecific list.
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
