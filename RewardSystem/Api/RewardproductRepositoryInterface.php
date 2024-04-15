<?php

namespace Seoudi\RewardSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RewardproductRepositoryInterface
{
    /**
     * Save
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductInterface $items
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewardproductInterface $items);

    /**
     * Get By Id
     *
     * @param int $id
     */
    public function getById($id);

    /**
     * Get List
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardproductInterface $item
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewardproductInterface $item);

    /**
     * Delete By Id
     *
     * @param int $id
     */
    public function deleteById($id);
}
