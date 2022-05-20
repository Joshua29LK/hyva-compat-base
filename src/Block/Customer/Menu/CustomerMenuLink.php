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

namespace Bss\HyvaCompatBase\Block\Customer\Menu;

use Magento\Framework\View\Element\Template;

/**
 * Customer menu link item default
 */
class CustomerMenuLink extends Template
{
    const LINK_TEXT = 'link_text';
    const LINK_TITLE = 'link_title';
    const LINK_URL = 'link_url';
    const LINK_TARGET = 'link_target';
    const LINK_CSS = 'link_css';
    const LINK_URL_PART = 'link_url_part';

    protected array $validTargetValues = ["_self", "_blank", "_parent", "_top"];

    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->setCss(['block', 'px-4', 'py-2', 'lg:px-5', 'lg:py-2', 'hover:bg-gray-100']);
    }

    /**
     * Get Link Title
     *
     * @return string|null
     */
    public function getLinkTitle(): ?string
    {
        return $this->getData(self::LINK_TITLE);
    }

    /**
     * Set Link Title
     *
     * @param string $title
     * @return $this
     */
    public function setLinkTitle(string $title): self
    {
        return $this->setData(self::LINK_TITLE, $title);
    }

    /**
     * Set Link Text
     *
     * @param string $text
     * @return $this
     */
    public function setLinkText(string $text): self
    {
        return $this->setData(self::LINK_TEXT, $text);
    }

    /**
     * Get Link text
     *
     * @return string|null
     */
    public function getLinkText(): ?string
    {
        return $this->getData(self::LINK_TEXT);
    }

    /**
     * Set link URL
     *
     * @param string $link
     * @return $this
     */
    public function setLink(string $link): self
    {
        return $this->setData(self::LINK_URL, $link);
    }

    /**
     * Get link URL
     *
     * @return string|null
     */
    public function getLink(): string
    {
        $url = $this->getData(self::LINK_URL);

        if (empty($url)) {
            if ($urlPart = $this->getData(self::LINK_URL_PART)) {
                $url = $this->getUrl($urlPart['path'] ?? '', $urlPart['params'] ?? []);
            } else {
                $url = "#";
            }
        }

        return $url;
    }

    /**
     * Get link target
     *
     * @return string|null
     */
    public function getLinkTarget(): ?string
    {
        return $this->getData(self::LINK_TARGET);
    }

    /**
     * Set link target
     *
     * @param string $target
     * @return $this
     */
    public function setLinkTarget(string $target): self
    {
        if (!in_array($target, $this->validTargetValues)) {
            return $this;
        }

        return $this->setData(self::LINK_TARGET, $target);
    }

    /**
     * Get css for link
     *
     * @return array|null
     */
    public function getCss(): array
    {
        $classes = $this->getData(self::LINK_CSS);
        if (is_null($classes)) {
            return [];
        }

        return $classes;
    }

    /**
     * Set css class
     *
     * @param array $classes
     * @return $this
     */
    public function setCss(array $classes): self
    {
        return $this->setData(self:: LINK_CSS, $classes);
    }

    /**
     * Add custom class to current link
     *
     * @param string $className
     * @return $this
     */
    public function addCssClass(string $className)
    {
        $currentClasses = $this->getCss();
        $currentClasses[] = $className;
        return $this->setCss($currentClasses);
    }

    /**
     * Remove a class name on link
     *
     * @param string $className
     * @return $this
     */
    public function removeCssClass(string $className): self
    {
        $currentClasses = $this->getCss();
        $needRemoveIndex = array_search($className, $currentClasses);

        if ($needRemoveIndex !== false) {
            unset($currentClasses[$needRemoveIndex]);
        }
        return $this->setCss($currentClasses);
    }
}
