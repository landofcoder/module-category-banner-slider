<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lof\CategoryBannerSlider\Model\CategoryBanner\Media;

use Magento\Store\Model\StoreManagerInterface;

/**
 * Catalog banner media config.
 *
 * @api
 * @since 100.0.2
 */
class Config implements ConfigInterface
{
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * Get filesystem directory path for banner images relative to the media directory.
     *
     * @return string
     */
    public function getBaseMediaPathAddition()
    {
        return 'categorybannerslider/banner';
    }

    /**
     * Get web-based directory path for banner images relative to the media directory.
     *
     * @return string
     */
    public function getBaseMediaUrlAddition()
    {
        return 'categorybannerslider/banner';
    }

    /**
     * @inheritdoc
     */
    public function getBaseMediaPath()
    {
        return 'categorybannerslider/Banner';
    }

    /**
     * @inheritdoc
     */
    public function getBaseMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'lof_categorybannerslider/categorybanner';
    }

    /**
     * Filesystem directory path of temporary banner images relative to the media directory.
     *
     * @return string
     */
    public function getBaseTmpMediaPath()
    {
        return 'lof/' . $this->getBaseMediaPathAddition();
    }

    /**
     * Get temporary base media URL.
     *
     * @return string
     */
    public function getBaseTmpMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'lof/' . $this->getBaseMediaUrlAddition();
    }

    /**
     * @inheritdoc
     */
    public function getMediaUrl($file)
    {
        return $this->getBaseMediaUrl() . '/' . $this->_prepareFile($file);
    }

    /**
     * @inheritdoc
     */
    public function getMediaPath($file)
    {
        return $this->getBaseMediaPath() . '/' . $this->_prepareFile($file);
    }

    /**
     * Get temporary media URL.
     *
     * @param string $file
     * @return string
     */
    public function getTmpMediaUrl($file)
    {
        return $this->getBaseTmpMediaUrl() . '/' . $this->_prepareFile($file);
    }

    /**
     * Part of URL of temporary banner images relative to the media directory.
     *
     * @param string $file
     * @return string
     */
    public function getTmpMediaShortUrl($file)
    {
        return 'lof/' . $this->getBaseMediaUrlAddition() . '/' . $this->_prepareFile($file);
    }

    /**
     * Part of URL of banner images relatively to media folder.
     *
     * @param string $file
     * @return string
     */
    public function getMediaShortUrl($file)
    {
        return $this->getBaseMediaUrlAddition() . '/' . $this->_prepareFile($file);
    }

    /**
     * Get path to the temporary media.
     *
     * @param string $file
     * @return string
     */
    public function getTmpMediaPath($file)
    {
        return $this->getBaseTmpMediaPath() . '/' . $this->_prepareFile($file);
    }

    /**
     * Process file path.
     *
     * @param string $file
     * @return string
     */
    protected function _prepareFile($file)
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }
}
