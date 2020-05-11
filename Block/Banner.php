<?php


namespace Lof\CategoryBannerSlider\Block;

use Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;
use Lof\CategoryBannerSlider\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;
use Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config;
use phpDocumentor\Reflection\Types\This;

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
     * @var Config
     */
    protected $_mediaConfig;

    /**
     * @var string
     */

    protected $HttpContext;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory
     */
    protected $_categoryBannerFactory;

    /**
     * @var null
     */
    protected $_position = null;
    protected $_bannerCollection = null;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Banner constructor.
     * @param Template\Context $context
     * @param CollectionFactory $categoryBannerFactory
     * @param \Magento\Framework\Registry $registry
     * @param Data $helperData
     * @param StoreManagerInterface $storeManager
     * @param Config $mediaConfig
     */
    public function __construct(
        Template\Context $context,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory $categoryBannerFactory,
        \Magento\Framework\Registry $registry,
        Data $helperData,
        StoreManagerInterface $storeManager,
        \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig,
        HttpContext $HttpContext
    )
    {
        $this->_mediaConfig = $mediaConfig;
        $this->HttpContext = $HttpContext;
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        $this->_helperData = $helperData;
        $this->_request = $context->getRequest();
        $this->_categoryBannerFactory = $categoryBannerFactory;
        parent::__construct($context);
    }

    /**
     * @param $positon
     */
    public function setBannerPosition($positon)
    {
        if ($this->_helperData->getEnable() == 1) {
            $storeId = $this->_storeManager->getStore()->getId();
            $bannerCollection = $this->_categoryBannerFactory->create();
            $bannerCollection->setStoreFilters($storeId);
            $bannerCollection->addFieldToFilter('location', $positon);
            $bannerCollection->addFieldToFilter('customer_group_id', [
                'finset' => $this->HttpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)
            ]);
            $this->addPageToFilter($bannerCollection);
            $_template = "banner.phtml";
            $this->setTemplate($_template);

            if (count($bannerCollection->getData())) {
                $this->_bannerCollection = $bannerCollection;
                $this->_position = $positon;
            }
        }

    }

    public function addPageToFilter(&$collection)
    {
        $page_name = $this->getRequest()->getFullActionName();
        if ($page_name == 'catalog_category_view') {
            $category_id = $this->getRequest()->getParam('id', 0);
            $collection->getSelect()
                ->joinLeft(
                    ['tbl_categories' => $collection->getTable('lof_category_banner_category')],
                    'main_table.banner_id = tbl_categories.banner_id',
                    []
                )->where('tbl_categories.category_id IN (?)', $category_id);
        } else {
            $collection->getSelect()->where('page_name LIKE "%' . $page_name . '%") ');
        }
        return $collection;
    }


    /**
     * @return string
     */
    public function getMediaUrl()
    {
        $mediaUrl = $this->_mediaConfig->getBaseTmpMediaUrl();
        return $mediaUrl;
    }

    /**
     *
     * /**
     * @return Banner
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return |null
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * @return CollectionFactory
     */
    public function getBannerCollection()
    {
        return $this->_bannerCollection;
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
