<?php

namespace Seoudi\GraphqlExtend\Model\Resolver;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;

class ConfigField implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ValueFactory $valueFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ValueFactory $valueFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->valueFactory = $valueFactory;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $customFieldValue = $this->scopeConfig->getValue('seoudi/graphql_extend/config_field', ScopeInterface::SCOPE_STORE);

        if ($customFieldValue === null || $customFieldValue === '') {
            $errorMessages = ['Config field is not set.'];
            $validationError = $this->valueFactory->create([
                'values' => $errorMessages,
                'fields' => [],
            ]);

            return $validationError;
        }

        return $customFieldValue;
    }
}
