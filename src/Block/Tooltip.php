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

namespace Bss\HyvaCompatBase\Block;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;

class Tooltip extends Template
{
    const TOOLTIP_ID = 'tooltip_uniqid';
    const TOOLTIP_WIDTH = 'tooltip_width';
    const TOOLTIP_WIDTH_MOBILE = 'tooltip_width_mobile';

    // DEFAULT VALUE
    const TOOLTIP_WIDTH_VALUE = 500;
    const TOOLTIP_WIDTH_MOBILE_VALUE = '100vw';

    protected Json $jsonSerializer;

    /**
     * Default template, can override through set template
     *
     * @var string
     */
    protected $_template = "Bss_HyvaCompatBase::page/tooltip.phtml";

    /**
     * @param Template\Context $context
     * @param Json $jsonSerializer
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Json $jsonSerializer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * Get init function name for tooltip
     *
     * @return string
     */
    public function getJsFuncName(): string
    {
        return "initTooltip" . $this->getTooltipId();
    }

    /**
     * Json encode data
     *
     * @param mixed $data
     * @return bool|string
     */
    public function jsonSerialize($data)
    {
        if ($data === null) {
            $data = "";
        }
        return $this->jsonSerializer->serialize($data);
    }

    /**
     * Get unique tooltip ID
     *
     * @return string
     */
    public function getTooltipId(): string
    {
        if (!$this->getData(self::TOOLTIP_ID)) {
            $this->setData(self::TOOLTIP_ID, uniqid());
        }

        return $this->getData(self::TOOLTIP_ID);
    }

    /**
     * Set tooltip unique id
     *
     * @param string $uniqid
     * @return Tooltip
     */
    public function setTooltipId(string $uniqid)
    {
        return $this->setData(self::TOOLTIP_ID, $uniqid);
    }

    /**
     * Get tooltip width
     *
     * @param string $screen - screen type
     * @return int|string
     */
    public function getTooltipWidth(string $screen = 'desktop')
    {
        if ($screen === 'mobile') {
            if (!$this->getData(self::TOOLTIP_WIDTH_MOBILE)) {
                $this->setData(self::TOOLTIP_WIDTH_MOBILE, self::TOOLTIP_WIDTH_MOBILE_VALUE);
            }

            return $this->getData(self::TOOLTIP_WIDTH_MOBILE);
        }

        if (!$this->getData(self::TOOLTIP_WIDTH)) {
            $this->setData(self::TOOLTIP_WIDTH, self::TOOLTIP_WIDTH_VALUE);
        }

        return (int) $this->getData(self::TOOLTIP_WIDTH);
    }

    /**
     * Set modal width
     *
     * @param int $width
     * @param int|string $widthMobile
     * @return Tooltip
     */
    public function setTooltipWidth(int $width, $widthMobile)
    {
        $this->setData(self::TOOLTIP_WIDTH, $width);
        $this->setData(self::TOOLTIP_WIDTH_MOBILE, $widthMobile);

        return $this;
    }
}
