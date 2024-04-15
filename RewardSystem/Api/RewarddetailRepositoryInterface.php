<?php

namespace Seoudi\RewardSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RewarddetailRepositoryInterface
{
    /**
     * Save
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewarddetailInterface $items
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewarddetailInterface $items);

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
     * @param \Seoudi\RewardSystem\Api\Data\RewarddetailInterface $item
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewarddetailInterface $item);

    /**
     * Delete By Id
     *
     * @param int $id
     */
    public function deleteById($id);
}
