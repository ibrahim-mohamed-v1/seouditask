<?php

namespace Seoudi\RewardSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Rewarddetail search results.
 */
interface RewarddetailSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Rewarddetail list.
     *
     * @return \Seoudi\RewardSystem\Api\Data\RewarddetailInterface[]
     */
    public function getItems();

    /**
     * Set Rewarddetail list.
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewarddetailInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
