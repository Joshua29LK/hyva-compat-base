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

namespace Bss\HyvaCompatBase\ViewModel;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class Base implements ArgumentInterface
{
    protected Json $jsonSerializer;
    protected StoreManagerInterface $storeManager;

    /**
     * @param Json $jsonSerializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Json $jsonSerializer,
        StoreManagerInterface $storeManager
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->storeManager = $storeManager;
    }

    /**
     * Json serialization
     *
     * @param array $array
     * @return string
     */
    public function serialize(array $array): string
    {
        return $this->jsonSerializer->serialize($array);
    }

    /**
     * Get current store
     *
     * @return \Magento\Store\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}
