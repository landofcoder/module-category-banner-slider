<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Lof\CategoryBannerSlider\Model\CategoryBanner
     */
    protected $_categoryBanner;

    public function __construct(\Lof\CategoryBannerSlider\Model\CategoryBanner $categoryBanner)
    {
        $this->_categoryBanner = $categoryBanner;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->_categoryBanner->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
