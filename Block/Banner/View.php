<?php

namespace Lof\CategoryBannerSlider\Block\Banner;

use Lof\CategoryBannerSlider\Model\CategoryBannerFactory;
use Magento\Framework\View\Element\Template;
use Lof\CategoryBannerSlider\Helper\Data;

/**
 * Class View
 * @package Lof\CategoryBannerSlider\Block\Banner
 */
class View extends Template
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
     * @var CategoryBannerFactory
     */
    protected $_CategoryBannerFactory;

    public function __construct(
        Template\Context $context,
        \Lof\CategoryBannerSlider\Model\CategoryBannerFactory $CategoryBannerFactory,
        Data $helperData
    ) {
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
        $playpausebuttons = $this->_helperData->getSystemconfig('lofcategorybannerslider/slider/button_play_plause_slider');
        return $playpausebuttons;
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
