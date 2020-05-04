<?php

namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Loader
 * @package Lof\CategoryBannerSlider\Model\CategoryBanner\Source
 */
class BarPosition implements ArrayInterface
{

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $option = [
            [
                'value' => 'bottom',
                'label' => __('bottom')
            ],
            [
                'value' => 'top',
                'label' => __('top')
            ],
            [
                'value' => 'left',
                'label' => __('left')
            ],
            [
                'value' => 'right',
                'label' => __('light')
            ],
        ];
        return $option;
    }
}
