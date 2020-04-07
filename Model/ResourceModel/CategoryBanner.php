<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model\ResourceModel;

use Lof\ProductTags\Model\ResourceModel\Tag;
use Magento\Framework\Model\AbstractModel;

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
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'name';
        }
        return parent::load($object, $value, $field);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $bannerId
     * @return array
     */
    public function lookupStoreIds($bannerId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('lof_category_banner_store'),
            'store_id'
        )
            ->where(
                'banner_id = ?',
                (int)$bannerId
            );
        return $connection->fetchCol($select);
    }

    /**
     * Save Category Banner Store
     */
    protected function _saveTagStores($banner)
    {
        $oldStores = $this->lookupStoreIds($banner->getId());
        $newStores = (array)$banner->getStores();
        if (empty($newStores)) {
            $newStores = (array)$banner->getStoreId();
        }
        $table = $this->getTable('lof_category_banner_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = ['banner_id = ?' => (int)$banner->getId(), 'store_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = ['banner_id' => (int)$banner->getId(), 'store_id' => (int)$storeId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
        return $this;
    }

    /**
     * Process page data after saving
     *
     * @param AbstractModel $object
     * @return $this
     * @throws LocalizedException
     */
    protected function _afterSave($bannerId)
    {
        $this->_saveTagStores($bannerId);
        return parent::_afterSave($bannerId);
    }
}
