<?php
namespace Seoudi\RewardSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RewardrecordRepositoryInterface
{
    /**
     * Save
     *
     * @param \Seoudi\RewardSystem\Api\Data\RewardrecordInterface $items
     */
    public function save(\Seoudi\RewardSystem\Api\Data\RewardrecordInterface $items);

    /**
     * Get by id
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
     * @param \Seoudi\RewardSystem\Api\Data\RewardrecordInterface $item
     */
    public function delete(\Seoudi\RewardSystem\Api\Data\RewardrecordInterface $item);

    /**
     * Delete By Id
     *
     * @param int $id
     */
    public function deleteById($id);

    /**
     * Get Joined List
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     */
    public function getJoinedList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
