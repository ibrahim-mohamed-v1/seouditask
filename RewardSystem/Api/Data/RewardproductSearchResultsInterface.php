<?php

namespace Seoudi\RewardSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Rewardproduct search results.
 */
interface RewardproductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Rewardproduct list.
     *
     * @return \Seoudi\RewardSystem\Api\Data\RewardproductInterface[]
     */
    public function getItems();

    /**
     * Set Rewardproduct list.
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
