<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Filesystem;
/**
 * Class CategoryBanner
 *
 * @package Lof\CategoryBannerSlider\Model
 */
class CategoryBanner extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_category_banner';


    const CACHE_TAG = 'category_banner';

    /**
     * CategoryBanner status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = 'category_banner';


    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection,
        \Magento\Framework\Filesystem $filesystem,
        array $data = []
    ) {
        $this->_filesystem = $filesystem;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Retrieve media gallery images
     *
     * @return \Magento\Framework\Data\Collection
     */
    public function getMediaGalleryImages(){
        $directory = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
        if (!$this->hasData('media_gallery_images')) {
            $this->setData('media_gallery_images', $this->_collectionFactory->create());
        }
        if (!$this->getData('media_gallery_images')->count() && is_array($this->getMediaGallery('images'))) {
            $images = $this->getData('media_gallery_images');
            foreach ($this->getMediaGallery('images') as $image) {
                if (!empty($image['disabled'])
                    || !empty($image['removed'])
                    || empty($image['value_id'])
                    || $images->getItemById($image['value_id']) != null
                ) {
                    continue;
                }
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['id'] = $image['value_id'];
                $image['path'] = $directory->getAbsolutePath($this->getMediaConfig()->getMediaPath($image['file']));
                $images->addItem(new \Magento\Framework\DataObject($image));
            }
            $this->setData('media_gallery_images', $images);
        }

        return $this->getData('catalog_product_image');
    }
}
