<?php
/**
 * Collection
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner;
use Lof\CategoryBannerSlider\Model\ResourceModel\AbstractCollection;

/**
 * Class Collection
 *
 * @package Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner
 */
class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Lof\CategoryBannerSlider\Model\CategoryBanner::class,
            \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner::class
        );
    }


    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);
        return $this;
    }
}