<?php

namespace Seoudi\RewardSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Rewardrecord search results.
 */
interface RewardrecordSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Rewardrecord list.
     *
     * @return \Seoudi\RewardSystem\Api\Data\RewardrecordInterface[]
     */
    public function getItems();

    /**
     * Set Rewardrecord list.
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardrecordInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
