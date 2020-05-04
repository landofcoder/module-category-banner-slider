<?php


namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Loader
 * @package Lof\CategoryBannerSlider\Model\CategoryBanner\Source
 */
class PiePosition implements ArrayInterface
{

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $option = [
            [
                'value' => 'rightTop',
                'label' => __('rightTop')
            ],
            [
                'value' => 'leftTop',
                'label' => __('leftTop')
            ],
            [
                'value' => 'leftBottom',
                'label' => __('leftBottom')
            ],
            [
                'value' => 'rightBottom',
                'label' => __('rightBottom')
            ],
        ];
        return $option;
    }
}
