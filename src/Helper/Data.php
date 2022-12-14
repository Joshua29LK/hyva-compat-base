<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_
 * @author     Extension Team
 * @copyright  Copyright (c) 2022 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */

namespace Bss\HyvaCompatBase\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 *
 * @package Bss\CustomerAttributes\Helper
 */
class Data extends AbstractHelper
{
    /**
     * Configuration paths rewrite template product list item
     */
    const XML_PATH_PRODUCT_LIST_ITEM_ENABLED = 'hyva_compat_base/rewrite_template/product_list_item';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check rewrite template product list item is enabled
     *
     * @return string
     */
    public function getTemplate()
    {
        $enabledModule = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_LIST_ITEM_ENABLED,ScopeInterface::SCOPE_STORE);

        if ($enabledModule) {
            $template =  'Bss_HyvaCompatBase::product/list/item.phtml';
        } else {
            $template = 'Magento_Catalog::product/list/item.phtml';
        }
        return $template;
    }
}
