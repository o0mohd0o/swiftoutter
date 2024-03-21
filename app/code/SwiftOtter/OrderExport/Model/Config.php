<?php
/**
 * Config
 *
 * @copyright Copyright © 2023 Mohamed Tawfik. All rights reserved.
 * @author    mohd.itc4@gmail.com
 */

namespace SwiftOtter\OrderExport\Model;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{

    const CONFIG_PATH_ENABLED = 'sales/order_export/enabled';
    const CONFIG_PATH_API_TOKEN = 'sales/order_export/api_token';
    const CONFIG_PATH_API_URL = 'sales/order_export/api_url';
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $ScopeCode = null ): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED);
    }


    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return string
     */
    public function getApiToken(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_TOKEN, $scopeType, $scopeCode);
        return ($value !== null) ? (string) $value : '';
    }


    public function getApiUrl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_URL, $scopeType, $scopeCode);
        return ($value !== null) ? (string) $value : '';
    }
}
