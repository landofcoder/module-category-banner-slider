<?php


namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Loader
 * @package Lof\CategoryBannerSlider\Model\CategoryBanner\Source
 */
class Loader implements ArrayInterface
{
    const BAR = 'bar';
    const PIE = 'pie';
    const NONE = 'none';

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $option = [
            [
                'value' => self::BAR,
                'label' => __('bar')
            ],
            [
                'value' => self::PIE,
                'label' => __('pie')
            ],
            [
                'value' => self::NONE,
                'label' => __('none')
            ]
        ];
        return $option;
    }
}
