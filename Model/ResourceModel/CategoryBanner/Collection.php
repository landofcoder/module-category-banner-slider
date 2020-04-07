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
        $this->_map['fields']['banner_id'] = 'main_table.banner_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    protected function _afterLoad()
    {
        $this->performAfterLoadBanner('lof_category_banner_store', 'banner_id');
        $this->_previewFlag = false;
        return parent::_afterLoad();
    }


    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);
        return $this;
    }

    protected function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('lof_category_banner_store', 'banner_id');
    }
}
