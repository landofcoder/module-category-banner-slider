<?php

namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Source;

use Magento\Framework\Option\ArrayInterface;


class Location implements ArrayInterface
{
    const CATEGORY_CONTENT_TOP = 'catalog_category_view.content-top';
    const CATEGORY_CONTENT_BOTTOM = 'catalog_category_view.content-bottom';
    const CATEGORY_PAGE_TOP = 'catalog_category_view.page-top';
    const CATEGORY_PAGE_BOTTOM = 'catalog_category_view.footer-container';
    const CATEGORY_SIDEBAR_TOP = 'catalog_category_view.sidebar-top';
    const CATEGORY_SIDEBAR_BOTTOM = 'catalog_category_view.sidebar-bottom';

    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Category page'),
                'value' => [
                    [
                        'label' => __('Top of content'),
                        'value' => self::CATEGORY_CONTENT_TOP
                    ],
                    [
                        'label' => __('Bottom of content'),
                        'value' => self::CATEGORY_CONTENT_BOTTOM
                    ],
                    [
                        'label' => __('Top of page'),
                        'value' => self::CATEGORY_PAGE_TOP
                    ],
                    [
                        'label' => __('Bottom of page'),
                        'value' => self::CATEGORY_PAGE_BOTTOM
                    ],
                    [
                        'label' => __('Top of sidebar'),
                        'value' => self::CATEGORY_SIDEBAR_TOP
                    ],
                    [
                        'label' => __('Bottom of sidebar'),
                        'value' => self::CATEGORY_SIDEBAR_BOTTOM
                    ],
                ]
            ]

        ];

        return $options;
    }
}
