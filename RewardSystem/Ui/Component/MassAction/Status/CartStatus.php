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

namespace Seoudi\RewardSystem\Ui\Component\MassAction\Status;

use Magento\Framework\UrlInterface;

/**
 * Class Options
 */
class CartStatus
{
    /**
     * @var array
     */
    protected $options;
    /**
     * Additional options params
     *
     * @var array
     */
    protected $data;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * Base URL for subactions
     *
     * @var string
     */
    protected $urlPath;
    /**
     * Param name for subactions
     *
     * @var string
     */
    protected $paramName;
    /**
     * Additional params for subactions
     *
     * @var array
     */
    protected $additionalData = [];

    /**
     * Constructor
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->data = $data;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get action options
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        if ($this->options === null) {
            $options = $this->getOptionArray();
            $this->prepareData();
            foreach ($options as $option) {
                $this->options[$option['value']] = [
                    'type' => $option['value'],
                    'label' => $option['label'],
                ];
                $this->options[$option['value']]['url'] = $this->urlBuilder->getUrl(
                    $this->urlPath,
                    [$this->paramName => $option['value']]
                );
                $this->options[$option['value']] = array_merge_recursive(
                    $this->options[$option['value']],
                    $this->additionalData
                );
            }
            $this->options = array_values($this->options);
        }
        return $this->options;
    }

    /**
     * Prepare addition data for subactions
     *
     * @return void
     */
    protected function prepareData()
    {
        foreach ($this->data as $key => $value) {
            switch ($key) {
                case 'urlPath':
                    $this->urlPath = $value;
                    break;
                case 'paramName':
                    $this->paramName = $value;
                    break;
                default:
                    $this->additionalData[$key] = $value;
                    break;
            }
        }
    }

    /**
     * Get Option Array
     */
    public function getOptionArray()
    {
        $options = [
            [
                'value' => 1,
                'label' => 'Enabled'
            ], [
                'value' => 0,
                'label' => 'Disabled'
            ]
        ];
        return $options;
    }
}
