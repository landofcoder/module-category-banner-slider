<?php


namespace Lof\CategoryBannerSlider\Block;

use Lof\CategoryBannerSlider\Model\ResourceModel\BannerCategory\Collection;
use Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
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

    /**
     * @var Config
     */
    protected $_mediaConfig;

    /**
     * @var string
     */

    protected $HttpContext;

    public $_bannerCollection = null;

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

    /**
     * @var Collection
     */
    protected $_bannerCategoryCollection;

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
     * @param Collection $bannerCategoryCollection
     * @param Config $mediaConfig
     */
    public function __construct(
        Template\Context $context,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory $categoryBannerFactory,
        \Magento\Framework\Registry $registry,
        Data $helperData,
        StoreManagerInterface $storeManager,
        \Lof\CategoryBannerSlider\Model\ResourceModel\BannerCategory\Collection $bannerCategoryCollection,
        \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig,
        HttpContext $HttpContext
    )
    {
        $this->_mediaConfig = $mediaConfig;
        $this->HttpContext = $HttpContext;
        $this->_bannerCategoryCollection = $bannerCategoryCollection;
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        $this->_helperData = $helperData;
        $this->_request = $context->getRequest();
        $this->_categoryBannerFactory = $categoryBannerFactory;
        parent::__construct($context);
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
     * @return string|void
     */
//    protected function _toHtml()
//    {
//        if ($this->_helperData->getEnable() == 1) {
//            return;
//        }
//        return parent::_toHtml();
//    }



    /**
     * @param $positon
     */
    public function setBannerPosition($positon)
    {
        $bannerCollection = $this->_categoryBannerFactory->create();
        $bannerCollection->addFieldToFilter('location', $positon);

        if ($bannerCollection->getData()) {
            $checkcustomer = $bannerCollection->addFieldToFilter('customer_group_id', [
                'finset' => $this->HttpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)
            ]);
            if ($checkcustomer->getData()) {
                $_template = "banner.phtml";
                $this->setTemplate($_template);

            }
        }
    }

    /**
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
        return $this->_categoryBannerFactory;
    }

    /**
     * @return mixed|null
     */
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * @return bool
     */
    public function checkBannerCategory()
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory) {
            $checkCategory = $this->_bannerCategoryCollection->addFieldToFilter('category_id', $currentCategory->getEntityId());
            if ($checkCategory->getData()) {
                if ($checkCategory->getData('banner_id')) {
                    return true;
                }
            }
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getListBanner()
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory) {
            $checkCategory = $this->_bannerCategoryCollection->addFieldToFilter('category_id', $currentCategory->getEntityId());
            if ($checkCategory->getData('banner_id')) {
                foreach ($checkCategory->getData() as $key => $item) {
                    $list[$key] = $item['banner_id'];
                }
            }
        }
        return $list;
    }

    /**
     * @param $bannerId
     * @return array
     */
    public function getImagesBannerCategory($bannerId)
    {
        $bannerCollection = $this->_categoryBannerFactory->create();
        $bannerCollection->load($bannerId);
        $jsonImages = $bannerCollection->getData();
        $images = get_object_vars(json_decode($jsonImages->getImages()));
        return $images;
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
