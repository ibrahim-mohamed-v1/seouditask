<?php
/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
namespace Seoudi\RewardSystem\Logger;

use Seoudi\RewardSystem\Logger\RewardLogger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * @var int
     */
    protected $loggerType = RewardLogger::INFO;

    /**
     * @var string
     */
    protected $fileName = '/var/log/reward-system.log';
}
