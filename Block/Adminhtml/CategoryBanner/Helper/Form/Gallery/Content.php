<?php

namespace Lof\CategoryBannerSlider\Block\Adminhtml\CategoryBanner\Helper\Form\Gallery;

use Magento\Framework\App\ObjectManager;
use Magento\Backend\Block\Media\Uploader;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Backend\Block\DataProviders\ImageUploadConfig as ImageUploadConfigDataProvider;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\CollectionFactory;

/**
 * Block for gallery content.
 */
class Content extends \Magento\Backend\Block\Widget
{
    /**
     * @var string
     */
    protected $_template = 'Lof_CategoryBanner::helper/gallery.phtml';

    /**
     * @var \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config
     */
    protected $_mediaConfig;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * @var ImageUploadConfigDataProvider
     */
    private $imageUploadConfigDataProvider;

    /**
     * @var Database
     */
    private $fileStorageDatabase;


    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    public $_objectManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegister;

    protected $_categorybanner;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig
     * @param array $data
     * @param ImageUploadConfigDataProvider $imageUploadConfigDataProvider
     * @param Database $fileStorageDatabase
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig,
        array $data = [],
        ImageUploadConfigDataProvider $imageUploadConfigDataProvider = null,
        \Magento\Framework\Registry $coreRegister,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        CollectionFactory $categorybanner,
        Database $fileStorageDatabase = null
    ) {
        $this->_categorybanner = $categorybanner;
        $this->_objectManager = $objectManager;
        $this->_coreRegister = $coreRegister;
        $this->_jsonEncoder = $jsonEncoder;
        $this->_mediaConfig = $mediaConfig;
        parent::__construct($context, $data);
        $this->imageUploadConfigDataProvider = $imageUploadConfigDataProvider
            ?: ObjectManager::getInstance()->get(ImageUploadConfigDataProvider::class);
        $this->fileStorageDatabase = $fileStorageDatabase
            ?: ObjectManager::getInstance()->get(Database::class);
    }

    /**
     * Prepare layout.
     *
     * @return AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->addChild(
            'uploader',
            \Magento\Backend\Block\Media\Uploader::class,
            ['image_upload_config_data' => $this->imageUploadConfigDataProvider]
        );

        $this->getUploader()->getConfig()->setUrl(
            $this->_urlBuilder->addSessionParam()->getUrl('lof_categorybannerslider/categorybanner/upload')
        )->setFileField(
            'image'
        )->setFilters(
            [
                'images' => [
                    'label' => __('Images (.gif, .jpg, .png)'),
                    'files' => ['*.gif', '*.jpg', '*.jpeg', '*.png'],
                ],
            ]
        );

        $this->_eventManager->dispatch('category_banner_gallery_prepare_layout', ['block' => $this]);

        return parent::_prepareLayout();
    }


    /**
     * @return mixed
     */
    public function images()
    {
        $categorybanner = $this->_categorybanner->create();
        $collection = $categorybanner->addFieldToFilter('images');
        $img_data = $collection->getData();
        return $img_data;
    }


    /**
     * Retrieve uploader block
     *
     * @return Uploader
     */
    public function getUploader()
    {
        return $this->getChildBlock('uploader');
    }

    /**
     * Retrieve uploader block html
     *
     * @return string
     */
    public function getUploaderHtml()
    {
        return $this->getChildHtml('uploader');
    }

    /**
     * Returns js object name
     *
     * @return string
     */
    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

    /**
     * Returns buttons for add image action.
     *
     * @return string
     */
    public function getAddImagesButton()
    {
        return $this->getButtonHtml(
            __('Add New Images'),
            $this->getJsObjectName() . '.showUploader()',
            'add',
            $this->getHtmlId() . '_add_images_button'
        );
    }

    /**
     * Returns image json
     *
     * @return string
     */
    public function getImagesJson()
    {
        $value['images'] = $this->images();
        if (is_array($value['images']) && count($value['images']) > 0) {
            foreach ($value['images'] as &$image) {
                $image['url'] = $this->_mediaConfig->getMediaUrl($image['img_name']);
                $image['file'] = $image['img_name'];
                $image['label'] = $image['img_label'];
                $image['value_id'] = $image['img_id'];
                $image['banner_id'] = $image['banner_id'];
                $image['description'] = $image['img_description'];
            }
            return $this->_jsonEncoder->encode($value['images']);
        }

        return '[]';
    }

    /**
     * Sort images array by position key
     *
     * @param array $images
     * @return array
     */
    private function sortImagesByPosition($images)
    {
        if (is_array($images)) {
            usort(
                $images,
                function ($imageA, $imageB) {
                    return ($imageA['position'] < $imageB['position']) ? -1 : 1;
                }
            );
        }
        return $images;
    }

    /**
     * Returns image values json
     *
     * @return string
     */
    public function getImagesValuesJson()
    {
        $values = [];
        return $this->_jsonEncoder->encode($values);
    }

    /**
     * Get image types data
     *
     * @return array
     */
    public function getImageTypes()
    {
        $imageTypes = [];
        foreach ($this->images() as $attribute) {
            /* @var $attribute \Magento\Eav\Model\Entity\Attribute */
            $imageTypes['image'] = [
                'code' => 'image',
                'value' => $attribute['img_name'],
                'label' => $attribute['img_label'],
                'scope' => 'Store View',
                'name' => 'gallery[image]',
            ];
        }
        return $imageTypes;
    }



    /**
     * Retrieve JSON data
     *
     * @return string
     */
    public function getImageTypesJson()
    {
        return $this->_jsonEncoder->encode($this->getImageTypes());
    }

    /**
     * Returns image helper object.
     *
     * @return \Magento\Catalog\Helper\Image
     * @deprecated 101.0.3
     */
    private function getImageHelper()
    {
        if ($this->imageHelper === null) {
            $this->imageHelper = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Catalog\Helper\Image::class);
        }
        return $this->imageHelper;
    }
}