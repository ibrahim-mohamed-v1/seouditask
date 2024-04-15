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

namespace Seoudi\RewardSystem\Model\Config\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;

class Ordermode extends \Magento\Framework\DataObject implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_appConfigScopeConfigInterface;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $appConfigScopeConfigInterface
     */
    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface
    ) {
        $this->_appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
    }

    /**
     * Array of options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $retrunArray = [
            'invoice' => __('Invoice Created'),
            'order_state' => __('Order Complete'),
            'shipment' => __('Shipment Generate')
        ];
        return $retrunArray;
    }
}
