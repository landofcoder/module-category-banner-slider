<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

/**
 * Class CategoryBanner
 *
 * @package Lof\CategoryBannerSlider\Model\ResourceModel
 */
class CategoryBanner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @var string
     */
    protected $_BannerCategoryTable = '';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_category_banner', 'banner_id');
    }

    /**
     * @param AbstractModel $object
     * @param mixed $value
     * @param null $field
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
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
    protected function _saveCategoryBannerStores($banner)
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
     * @param $bannerId
     * @return array
     */
    public function getCategoryBannerCategory($bannerId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('lof_category_banner_category'),
            'category_id'
        )
            ->where(
                'banner_id = ?',
                (int)$bannerId
            );
        return $connection->fetchCol($select);
    }


    /**
     * @param $banner
     * @return $this
     */
    protected function _saveBannerCategory($banner)
    {
        $oldCategory = $this->getCategoryBannerCategory($banner->getId());
        $newCategory = (array)$banner->getCategory();
        if (empty($newCategory)) {
            $newCategory = (array)$banner->getCategoryId();
        }
        $table = $this->getTable('lof_category_banner_category');
        $insert = array_diff($newCategory, $oldCategory);
        $delete = array_diff($oldCategory, $newCategory);
        if ($delete) {
            $where = ['banner_id = ?' => (int)$banner->getId(), 'category_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $categoryId) {
                $data[] = ['banner_id' => (int)$banner->getId(), 'category_id' => (int)$categoryId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
        return $this;
    }



    /**
     * Process page data after saving
     *
     * @return $this
     * @throws LocalizedException
     */
    protected function _afterSave($bannerId)
    {
        $this->_saveBannerCategory($bannerId);
        $this->_saveCategoryBannerStores($bannerId);
        return parent::_afterSave($bannerId);
    }
}
