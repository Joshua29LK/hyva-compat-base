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
 * @package    Bss_
 * @author     Extension Team
 * @copyright  Copyright (c) 2022 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\HyvaCompatBase\Model;

interface ExtendJsModifierInterface
{
    /**
     * Get extended js
     *
     * Input: [
     *          'custom_data:' => $customData,
     *          'sequential_data:' => ['Ltc', 'deptrai', 'bodoiqua'],
     *          'deep_array_data:' => ['Vadu', [ 'aaa:' => $bbb, 'ccc:' => $ddd ] ],
     *          'another_data:' => ['data1:' => $data1, 'data2:' => $data2]
     *          'anotherHandler()' => <<<JS
     *              {
     *                  console.log('anotherHandler log')
     *                  // some logic code here ...
     *              }
     *          JS,
     *          'anotherArrowHandler: () =>' => <<<JS
     *              {
     *                  console.log('anotherHandler log')
     *                  // some logic code here ...
     *              }
     *          JS,
     * ];
     *
     * @param array $jsArray
     * @return void
     */
    public function modify(array &$jsArray);
}
