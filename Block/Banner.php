<?php


namespace Lof\CategoryBannerSlider\Block;

use Lof\CategoryBannerSlider\Model\CategoryBanner;
use Lof\CategoryBannerSlider\Model\ResourceModel\BannerCategory\Collection;
use Magento\Framework\View\Element\Template;
use Lof\CategoryBannerSlider\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;
use Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config;

/**
 * Class View
 * @package Lof\CategoryBannerSlider\Block
 */
class Banner extends Template
{
    /**
     * @var Data
     */
    protected $_helperData;

    protected $_mediaConfig;

    /**
     * @var string
     */
    protected $_template = "banner.phtml";

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Lof\CategoryBannerSlider\Model\CategoryBanner
     */
    protected $_categoryBanner;


    /**
     * @var Collection
     */
    protected $_bannerCategoryCollection;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        Template\Context $context,
        \Lof\CategoryBannerSlider\Model\CategoryBannerFactory $CategoryBanner,
        \Magento\Framework\Registry $registry,
        Data $helperData,
        StoreManagerInterface $storeManager,
        \Lof\CategoryBannerSlider\Model\ResourceModel\BannerCategory\Collection $bannerCategoryCollection,
        \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig
    )
    {
        $this->_mediaConfig = $mediaConfig;
        $this->_bannerCategoryCollection = $bannerCategoryCollection;
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        $this->_helperData = $helperData;
        $this->_categoryBanner = $CategoryBanner;
        parent::__construct($context);
    }


    public function getMediaUrl()
    {
        $mediaUrl = $this->_mediaConfig->getBaseTmpMediaUrl();
        return $mediaUrl;
    }

    /**
     * @return string|void
     */
    protected function _toHtml()
    {
        if ($this->_helperData->getEnable() == 0) {
            return;
        }
        return parent::_toHtml();
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    public function checkBannerCategory()
    {
        $currentCategory = $this->getCurrentCategory();
        $entityId = $currentCategory->getEntityId();
        $checkCategory = $this->_bannerCategoryCollection->addFieldToFilter('category_id', $entityId);
        if ($checkCategory->getData()) {
            if ($checkCategory->getData('banner_id')) {
                return true;
            }
        }
        return false;
    }

    public function getListBanner(){
        $currentCategory = $this->getCurrentCategory();
        $entityId = $currentCategory->getEntityId();
        $checkCategory = $this->_bannerCategoryCollection->addFieldToFilter('category_id', $entityId);
        if ($checkCategory->getData('banner_id')) {
            foreach ($checkCategory->getData() as $key => $item) {
                $list[$key] = $item['banner_id'];
            }
        }
        return $list;
    }

    public function getImagesBannerCategory($bannerId)
    {
        $banner = $this->_categoryBanner->create()->load($bannerId);
        $jsonImages = $banner->getData("images");
        $images = get_object_vars(json_decode($jsonImages));
        return $images;
    }

    public function getStatusdBanner($bannerId)
    {
        $banner = $this->_categoryBanner->create()->load($bannerId);
        $status = $banner->getData("status");
        return $status;
    }



    public function getAutoPlayConfig()
    {
        $autoplay = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/auto_play_slider');
        return $autoplay;
    }

    public function getEffectConfig()
    {
        $effect = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/select_animation_slider');
        return $effect;
    }

    public function getIntervalConfig()
    {
        $interval = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/interval_slider');
        return $interval;
    }

    public function getDurationConfig()
    {
        $duration = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/duration_slider');
        return $duration;
    }

    public function getPaginationConfig()
    {
        $pagination = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/show_pagination_slider');
        return $pagination;
    }

    public function getNavigationConfig()
    {
        $navigation = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/show_navigation_slider');
        return $navigation;
    }

    public function getLoaderConfig()
    {
        $loader = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/loader_slider');
        return $loader;
    }

    public function getPauseOnHoverConfig()
    {
        $pauseOnHover = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/pause_on_hover_slider');
        return $pauseOnHover;
    }

    public function getPlayPauseButtonConfig()
    {
        $pauseButtons = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/button_play_plause_slider');
        return $pauseButtons;
    }

    public function getBarPositionConfig()
    {
        $barPosition = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/bar_position_slider');
        return $barPosition;
    }

    public function getPiePositionConfig()
    {
        $barPosition = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/pie_position_slider');
        return $barPosition;
    }
}
