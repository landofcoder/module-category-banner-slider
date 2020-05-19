<?php


namespace Lof\CategoryBannerSlider\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Lof\CategoryBannerSlider\Model\CategoryBanner\Source\Location;


/**
 * Class Location
 * @package Lof\CategoryBannerSlider\Ui\Component\Listing\Column
 */
class BannerPostion extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->getData('name')])) {
                    $data = $this->getLocation($item[$this->getData('name')]);
                    $item[$this->getData('name')] = '<b>' . implode(', ', $data) . '</b></br>';
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function getLocation($data)
    {
        $location = [];
        $data = explode(',', $data);
        foreach ($data as $item) {
            switch ($item) {
                case Location::CATEGORY_CONTENT_TOP:
                    $location[] = __('Category Content Top');
                    break;
                case Location::CATEGORY_CONTENT_BOTTOM:
                    $location[] = __('Category Content Bottom');
                    break;
                case Location::CATEGORY_PAGE_TOP:
                    $location[] = __('Category Page Top');
                    break;
                case Location::CATEGORY_PAGE_BOTTOM:
                    $location[] = __('Category Page Bottom');
                    break;
                case Location::CATEGORY_SIDEBAR_TOP:
                    $location[] = __('Category Slider Top');
                    break;
                case Location::CATEGORY_SIDEBAR_BOTTOM:
                    $location[] = __('Category Slider Bottom');
                    break;
            }
        }
        return $location;
    }
}
