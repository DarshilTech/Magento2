<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * It is available through the world-wide-web at this URL:
 * https://tldrlegal.com/license/mit-license
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to support@buckaroo.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact support@buckaroo.nl for more information.
 *
 * @copyright Copyright (c) Buckaroo B.V.
 * @license   https://tldrlegal.com/license/mit-license
 */

namespace Buckaroo\Magento2\Model\ConfigProvider\Method;

class Voucher extends AbstractConfigProvider
{
    const XPATH_VOUCHER_PAYMENT_FEE           = 'payment/buckaroo_magento2_voucher/payment_fee';
    const XPATH_VOUCHER_ACTIVE                = 'payment/buckaroo_magento2_voucher/active';
    const XPATH_VOUCHER_SUBTEXT               = 'payment/buckaroo_magento2_voucher/subtext';
    const XPATH_VOUCHER_SUBTEXT_STYLE         = 'payment/buckaroo_magento2_voucher/subtext_style';
    const XPATH_VOUCHER_SUBTEXT_COLOR         = 'payment/buckaroo_magento2_voucher/subtext_color';
    const XPATH_VOUCHER_ACTIVE_STATUS         = 'payment/buckaroo_magento2_voucher/active_status';
    const XPATH_VOUCHER_ORDER_STATUS_SUCCESS  = 'payment/buckaroo_magento2_voucher/order_status_success';
    const XPATH_VOUCHER_ORDER_STATUS_FAILED   = 'payment/buckaroo_magento2_voucher/order_status_failed';
    const XPATH_VOUCHER_ORDER_EMAIL           = 'payment/buckaroo_magento2_voucher/order_email';
    const XPATH_VOUCHER_AVAILABLE_IN_BACKEND  = 'payment/buckaroo_magento2_voucher/available_in_backend';

    const XPATH_ALLOWED_CURRENCIES = 'payment/buckaroo_magento2_voucher/allowed_currencies';

    const XPATH_ALLOW_SPECIFIC                  = 'payment/buckaroo_magento2_voucher/allowspecific';
    const XPATH_SPECIFIC_COUNTRY                = 'payment/buckaroo_magento2_voucher/specificcountry';
    const XPATH_SPECIFIC_CUSTOMER_GROUP         = 'payment/buckaroo_magento2_voucher/specificcustomergroup';

    /**
     * @var array
     */
    protected $allowedCurrencies = [
        'EUR'
    ];

    /**
     * @return array|void
     */
    public function getConfig()
    {
        if (!$this->scopeConfig->getValue(
            static::XPATH_VOUCHER_ACTIVE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return [];
        }

        $paymentFeeLabel = $this->getBuckarooPaymentFeeLabel();

        return [
            'payment' => [
                'buckaroo' => [
                    'voucher' => [
                        'paymentFeeLabel' => $paymentFeeLabel,
                        'subtext'   => $this->getSubtext(),
                        'subtext_style'   => $this->getSubtextStyle(),
                        'subtext_color'   => $this->getSubtextColor(),
                        'allowedCurrencies' => $this->getAllowedCurrencies(),
                    ],
                ],
            ],
        ];
    }

    /**
     * @param null|int $storeId
     *
     * @return float
     */
    public function getPaymentFee($storeId = null)
    {
        $paymentFee = $this->scopeConfig->getValue(
            self::XPATH_VOUCHER_PAYMENT_FEE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $paymentFee ? $paymentFee : false;
    }

    /**
     * @return array
     */
    public function getBaseAllowedCurrencies()
    {
        return [
            'EUR',
        ];
    }
}
