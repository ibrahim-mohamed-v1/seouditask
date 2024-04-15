<?php
/**
 * Seoudi Software
 *
 * @category Seoudi
 * @package Seoudi_RewardSystem
 * @author Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license https://store.Seoudi.com/license.html
 */
declare(strict_types=1);

namespace Seoudi\RewardSystem\Model;

use Seoudi\RewardSystem\Api\Data\RewardrecordSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Rewardrecord search results.
 */
class RewardrecordSearchResults extends SearchResults implements RewardrecordSearchResultsInterface
{
}
