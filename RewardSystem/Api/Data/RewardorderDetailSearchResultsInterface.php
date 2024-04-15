<?php

namespace Seoudi\RewardSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for RewardorderDetail search results.
 */
interface RewardorderDetailSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get RewardorderDetail list.
     *
     * @return \Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface[]
     */
    public function getItems();

    /**
     * Set RewardorderDetail list.
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
