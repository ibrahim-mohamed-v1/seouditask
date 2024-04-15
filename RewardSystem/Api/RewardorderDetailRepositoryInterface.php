<?php

namespace Seoudi\RewardSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RewardorderDetailRepositoryInterface
{
    /**
     * Save
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface $items
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface $items);

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
     * @param \Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface $item
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewardorderDetailInterface $item);

    /**
     * Delete By Id
     *
     * @param int $id
     */
    public function deleteById($id);
}
