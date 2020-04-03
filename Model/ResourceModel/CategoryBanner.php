<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model\ResourceModel;

/**
 * Class CategoryBanner
 *
 * @package Lof\CategoryBannerSlider\Model\ResourceModel
 */
class CategoryBanner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_category_banner', 'banner_id');
    }
}
