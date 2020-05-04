<?php

namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Effect
 * @package Lof\CategoryBannerSlider\Model\CategoryBanner\Source
 */
class Effect implements ArrayInterface
{
    const RANDOM = 'random';
    const SIMPLE_FADE = 'simpleFade';
    const CURTAIN_TOP_LEFT = 'curtainTopLeft';
    const CURTAIN_TOP_RIGHT = 'curtainTopRight';
    const CURTAIN_BOTTOM_LEFT = 'curtainBottomLeft';
    const CURTAIN_BOTTOM_RIGHT = 'curtainBottomRight';
    const CURTAIN_SLICE_LEFT = 'curtainSliceLeft';
    const CURTAIN_SLICE_RIGHT = 'curtainSliceRight';
    const BLIND_CURTAIN_TOP_LEFT = 'blindCurtainTopLeft';
    const BLIND_CURTAIN_TOP_RIGHT = 'blindCurtainTopRight';
    const BLIND_CURTAIN_BOTTOM_LEFT = 'blindCurtainBottomLeft';
    const BLIND_CURTAIN_BOTTOM_RIGHT = 'blindCurtainBottomRight';
    const BLIND_CURTAIN_SLICE_BOTTOM = 'blindCurtainSliceBottom';
    const BLIND_CURTAIN_SLICE_TOP = 'blindCurtainSliceTop';
    const STAMPEDE = 'stampede';
    const MOSAIC = 'mosaic';
    const MOSAIC_REVERSE = 'mosaicReverse';
    const MOSAIC_RANDOM = 'mosaicRandom';
    const MOSAIC_SPIRAL = 'mosaicSpiral';
    const MOSAIC_SPIRAL_REVERSE = 'mosaicSpiralReverse';
    const TOP_LEFT_BOTTOM_RIGHT = 'topLeftBottomRight';
    const BOTTOM_RIGHT_TOP_LEFT = 'bottomRightTopLeft';
    const BOTTOM_LEFT_TOP_RIGHT = 'bottomLeftTopRight';

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $option = [
            [
                'value' => self::RANDOM,
                'label' => __('Random')
            ],
            [
                'value' => self::SIMPLE_FADE,
                'label' => __('Simple Fade')
            ],
            [
                'value' => self::CURTAIN_TOP_LEFT,
                'label' => __('Curtain Top Left')
            ],
            [
                'value' => self::CURTAIN_TOP_RIGHT,
                'label' => __('Curtain Top Right')
            ],
            [
                'value' => self::CURTAIN_BOTTOM_LEFT,
                'label' => __('Curtain Bottom Left')
            ],
            [
                'value' => self::CURTAIN_BOTTOM_RIGHT,
                'label' => __('Curtain Bottom Right')
            ],
            [
                'value' => self::CURTAIN_SLICE_LEFT,
                'label' => __('Curtain Slice Left')
            ],
            [
                'value' => self::CURTAIN_SLICE_RIGHT,
                'label' => __('Curtain Slice Right')
            ],
            [
                'value' => self::BLIND_CURTAIN_TOP_LEFT,
                'label' => __('Blind Curtain Top Left')
            ],
            [
                'value' => self::BLIND_CURTAIN_TOP_RIGHT,
                'label' => __('Blind Curtain Top Right')
            ],
            [
                'value' => self::BLIND_CURTAIN_BOTTOM_LEFT,
                'label' => __('Blind Curtain Bottom Left')
            ],
            [
                'value' => self::BLIND_CURTAIN_BOTTOM_RIGHT,
                'label' => __('Blind Curtain Bottom Right')
            ],
            [
                'value' => self::BLIND_CURTAIN_SLICE_BOTTOM,
                'label' => __('Blind Curtain Slice Bottom')
            ],
            [
                'value' => self::BLIND_CURTAIN_SLICE_TOP,
                'label' => __('Blind Curtain Slice Top')
            ],
            [
                'value' => self::STAMPEDE,
                'label' => __('Stampede')
            ],
            [
                'value' => self::MOSAIC,
                'label' => __('mosaic')
            ],
            [
                'value' => self::MOSAIC_REVERSE,
                'label' => __('Mosaic Reverse')
            ],
            [
                'value' => self::MOSAIC_RANDOM,
                'label' => __('Mosaic Random')
            ],
            [
                'value' => self::MOSAIC_SPIRAL,
                'label' => __('Mosaic Spiral')
            ],
            [
                'value' => self::MOSAIC_SPIRAL_REVERSE,
                'label' => __('Mosaic Spiral Reverse')
            ],
            [
                'value' => self::TOP_LEFT_BOTTOM_RIGHT,
                'label' => __('Top Left Bottom Right')
            ],
            [
                'value' => self::BOTTOM_RIGHT_TOP_LEFT,
                'label' => __('Bottom Right Top Left')
            ],
            [
                'value' => self::BOTTOM_LEFT_TOP_RIGHT,
                'label' => __('Bottom Left Top Right')
            ],
        ];

        return $option;
    }
}
