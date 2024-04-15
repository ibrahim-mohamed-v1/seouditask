<?php

namespace Seoudi\RewardSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RewardproductSpecificRepositoryInterface
{
    /**
     * Save
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardcategoryInterface $items
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $items);

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
     * @param \Seoudi\RewardSystem\Api\Data\RewardcategoryInterface $item
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewardproductSpecificInterface $item);

    /**
     * Delete by id
     *
     * @param int $id
     */
    public function deleteById($id);
}
