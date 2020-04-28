<?php


namespace Lof\CategoryBannerSlider\Block;

use Lof\CategoryBannerSlider\Model\CategoryBannerFactory;
use Magento\Framework\View\Element\Template;
use Lof\CategoryBannerSlider\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;

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

    /**
     * @var string
     */
    protected $_template = "banner.phtml";

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var CategoryBannerFactory
     */
    protected $_CategoryBannerFactory;

    protected $_storeManager;

    public function __construct(
        Template\Context $context,
        \Lof\CategoryBannerSlider\Model\CategoryBannerFactory $CategoryBannerFactory,
        \Magento\Framework\Registry $registry,
        Data $helperData,
        StoreManagerInterface $storeManager
    )
    {
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        $this->_helperData = $helperData;
        $this->_CategoryBannerFactory = $CategoryBannerFactory;
        parent::__construct($context);
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

    public function getBannerCollection()
    {
        $Bannerollection = $this->_CategoryBannerFactory->create();
        $Bannerollection->getCollection();
        return $Bannerollection;
    }

    public function getImageUrl()
    {
        $Bannerollection = $this->_CategoryBannerFactory->create()->getCollection();
        $imagesjson = $Bannerollection->getImages();

        $imageurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $imagesjson;
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
        $pauseonhover = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/pause_on_hover_slider');
        return $pauseonhover;
    }

    public function getPlayPauseButtonConfig()
    {
        $pausebuttons = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/button_play_plause_slider');
        return $pausebuttons;
    }

    public function getBarPositionConfig()
    {
        $barposition = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/bar_position_slider');
        return $barposition;
    }

    public function getPiePositionConfig()
    {
        $barposition = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/pie_position_slider');
        return $barposition;
    }
}
