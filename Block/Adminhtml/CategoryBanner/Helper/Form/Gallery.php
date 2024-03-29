<?php

namespace Lof\CategoryBannerSlider\Block\Adminhtml\CategoryBanner\Helper\Form;

use Magento\Framework\App\ObjectManager;
use Lof\CategoryBannerSlider\Model\CategoryBanner;
use Magento\Eav\Model\Entity\Attribute;
use Magento\Framework\Registry;
use phpDocumentor\Reflection\Types\This;

/**
 * Adminhtml gallery block
 */
class Gallery extends \Magento\Framework\View\Element\AbstractBlock
{
    /**
     * Gallery field name suffix
     *
     * @var string
     */
    protected $fieldNameSuffix = 'categorybanner';

    /**
     * Gallery html id
     *
     * @var string
     */
    protected $htmlId = 'media_gallery';

    /**
     * Gallery name
     *
     * @var string
     */
    protected $name = 'categorybanner[media_gallery]';

    /**
     * Html id for data scope
     *
     * @var string
     */
    protected $image = 'image';

    /**
     * @var string
     */
    protected $formName = 'lof_categorybannerslider_categorybanner_form';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Data\Form
     */
    protected $form;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form $form
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form $form,
        Registry $registry,
        $data = []
    ) {
        $this->_registry = $registry;
        $this->storeManager = $storeManager;
        $this->form = $form;
        parent::__construct($context, $data);
    }

    /**
     * Returns element html.
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = $this->getContentHtml();
        return $html;
    }

    /**
     * Get banner images
     *
     * @return array|null
     */
    public function getImages()
    {
        $mediaGallery = $this->registry->registry('lof_categorybannerslider_categorybanner')->getData('media_gallery');
        if (!empty($mediaGallery)) {
            foreach ($mediaGallery['images'] as $key => $image) {
                if (isset($image['video_description']) && $image['video_description'] != '') {
                    $mediaGallery['images'][$key]['video_description'] = base64_decode($image['video_description']);
                }

                if (isset($image['role']) && $image['role'] != '') {
                    $mediaGallery['images'][$key]['role'] = base64_decode($image['role']);
                }

                if (isset($mediaGallery['images']) && isset($mediaGallery['images'][$key]['description'])) {
                    $mediaGallery['images'][$key]['description'] = base64_decode($image['description']);
                }
            }

            return $mediaGallery;
        }
    }

    /**
     * Prepares content block
     *
     * @return string
     */
    public function getContentHtml()
    {
        /* @var $content \Lof\CategoryBannerSlider\Block\Adminhtml\CategoryBanner\Helper\Form\Gallery\Content */
        $content = $this->getChildBlock('content_items');
        $content->setId($this->getHtmlId() . '_content')->setElement($this);
        $content->setFormName($this->formName);
        $galleryJs = $content->getJsObjectName();
        $content->getUploader()->getConfig()->setMediaGallery($galleryJs);
        return $content->toHtml();
    }

    /**
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->addChild('content_items','Lof\CategoryBannerSlider\Block\Adminhtml\CategoryBanner\Helper\Form\Gallery\Content');
        return parent::_prepareLayout();
    }


    /**
     * Returns html id
     *
     * @return string
     */
    protected function getHtmlId()
    {
        return $this->htmlId;
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns suffix for field name
     *
     * @return string
     */
    public function getFieldNameSuffix()
    {
        return $this->fieldNameSuffix;
    }

    /**
     * Returns data scope html id
     *
     * @return string
     */
    public function getDataScopeHtmlId()
    {
        return $this->image;
    }

    /**
     * Returns html content of the block
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->getElementHtml();
    }

    /**
     * Retrieve data object related with form
     *
     * @return ProductInterface|Product
     */
    public function getDataObject()
    {
        return $this->registry->registry('current_product');
    }


}
