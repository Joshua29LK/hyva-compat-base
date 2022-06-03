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

namespace Bss\HyvaCompatBase\Observer;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Event\Observer;

class AddModuleBaseSrc implements \Magento\Framework\Event\ObserverInterface
{
    protected ComponentRegistrarInterface $componentRegistrar;

    /**
     * @param ComponentRegistrarInterface $componentRegistrar
     */
    public function __construct(
        ComponentRegistrarInterface $componentRegistrar
    ) {
        $this->componentRegistrar = $componentRegistrar;
    }
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $configObject = $observer->getData('config');
        $path = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, "Bss_HyvaCompatBase");
        if ($path && substr($path, 0, strlen(BP)) === BP) {
            $paths = ['src' => substr($path, strlen(BP) + 1)];
        }
        if (isset($paths)) {
            $configObject->setData(
                'extensions',
                $configObject->hasData('extensions') ? array_merge_recursive($configObject->getData('extensions'), [$paths]) : [$paths]
            );
        }
    }
}
