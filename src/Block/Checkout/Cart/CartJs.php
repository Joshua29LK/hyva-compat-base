<?php
declare(strict_types=1);
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
 * @package    Bss_HyvaCompatBase
 * @author     Extension Team
 * @copyright  Copyright (c) 2022 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */

namespace Bss\HyvaCompatBase\Block\Checkout\Cart;

use Magento\Framework\View\Element\Template;
use Bss\HyvaCompatBase\Model\ExtendJsModifierInterface;

class CartJs extends Template
{
    protected array $extendedJsPool;

    /**
     * @param Template\Context $context
     * @param ExtendJsModifierInterface[] $extendedJsPool
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $extendedJsPool = [],
        array $data = []
    ) {
        $this->extendedJsPool = $extendedJsPool;
        parent::__construct($context, $data);
    }

    /**
     * Get Extended JS
     *
     * @return string
     */
    public function getExtendedJs(): string
    {
        $jsInArray = $this->getExtendedJsInArray();
        return $this->parseToJs($jsInArray);
    }

    /**
     * Get Extended Js Array
     * @return array
     */
    public function getExtendedJsInArray(): array
    {
        $jsInArray = [];
        foreach ($this->extendedJsPool as $modifier) {
            $modifier->modify($jsInArray);
        }

        return $jsInArray;
    }

    /**
     * Convert php array to js object
     *
     * @param array $jsInArray
     * @return string
     */
    public function parseToJs(array $jsInArray): string
    {
        $jsPattern = '{%s}';
        $js = '';
        $tmpJs = '';

        $jsInArrayLength = count($jsInArray);
        $jsInArrayRunningIndex = 0;

        foreach ($jsInArray as $key => $vl) {
            if (is_array($vl)) {
                if ($this->isAssociative($vl)) {
                    if (is_numeric($key)) {
                        $key .= ":";
                    }
                    $tmpJs .= $key . $this->parseToJs($vl);
                } else {
                    $tmpJs .= $key . "[" . $this->renderSequentialArrayToJs($vl) . "]";
                }
            } else {
                $tmpJs .= $this->renderKeyVlToJs($key, $vl);
            }

            $jsInArrayRunningIndex++;

            if ($jsInArrayRunningIndex < $jsInArrayLength && !empty($tmpJs)) {
                $tmpJs .= ",";
            }
        }
        $js .= sprintf($jsPattern, $tmpJs ?? '');

        return $js;
    }

    /**
     * Check if the input array is associative array
     *
     * @param array $array
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function isAssociative(array $array): bool
    {
        if ([] === $array) {
            return true;
        }

        $i = 0;
        foreach ($array as $value) {
            if(!array_key_exists($i, $array)) {
                return true;
            }
            $i++;
        }

        return false;
    }

    /**
     * Render key, value of php array to js object prop and value
     *
     * @param mixed $key
     * @param mixed $vl
     * @return string
     */
    protected function renderKeyVlToJs($key, $vl): string
    {
        $isKeyPattern = "/(^[a-z\d_]+:$)|(^\.\d+:$)/";
        // If key is Sequential => convert to string
        if (is_numeric($key)) {
            $key .= ':';
        }

        // if is property => add sing quote to string
        if (preg_match($isKeyPattern, $key)) {
            if (is_string($vl)) {
                $vl = "'" . trim($vl) . "'";
            }
        }

        if (is_bool($vl)) {
            $vl = $vl ? 'true' : 'false';
        }

        if (is_string($vl)) {
            $vl = trim($vl);
        }

        if ($vl == '') {
            $vl = "''";
        }
        return "$key$vl";
    }

    /**
     * Render sequential php array to js object array
     *
     * @param array $arrayIn
     * @return string
     */
    protected function renderSequentialArrayToJs(array $arrayIn): string
    {
        $tmpJs = '';
        $vlLength = count($arrayIn);
        $vlRunningIndex = 0;

        foreach ($arrayIn as $index => $item) {
            $vlTmpJs = '';
            if (is_array($item)) {
                $vlTmpJs .= $index . ": " . $this->parseToJs($item);
            } else {
                if (is_string($item)) {
                    $vlTmpJs .= "'" . $item . "'" ;
                } else if (is_bool($item)) {
                    $vlTmpJs .= $item ? 'true' : 'false';
                } else if (is_numeric($item)) {
                    $vlTmpJs .= $item;
                }
            }
            $vlRunningIndex++;

            $tmpJs .= $vlTmpJs;
            if ($vlRunningIndex < $vlLength && !empty($vlTmpJs)) {
                $tmpJs .= ",";
            }
        }

        return $tmpJs;
    }
}
