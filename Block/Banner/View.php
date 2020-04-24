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

    public function getCollectionBanner()
    {
        $banner = $this->_CategoryBannerFactory->create();
        $collection = $banner->getCollection();
        foreach ($collection as $item) {
            $item->getData();
        }
    }
}
