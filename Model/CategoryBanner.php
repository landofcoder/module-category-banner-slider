<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model;

use Magento\Framework\Api\DataObjectHelper;

/**
 * Class CategoryBanner
 *
 * @package Lof\CategoryBannerSlider\Model
 */
class CategoryBanner extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var CategoryBannerInterfaceFactory
     */
    protected $categorybannerDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_category_banner';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CategoryBannerInterfaceFactory $categorybannerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CategoryBannerInterfaceFactory $categorybannerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection,
        array $data = []
    ) {
        $this->categorybannerDataFactory = $categorybannerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve categorybanner model with categorybanner data
     * @return CategoryBannerInterface
     */
    public function getDataModel()
    {
        $categorybannerData = $this->getData();

        $categorybannerDataObject = $this->categorybannerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $categorybannerDataObject,
            $categorybannerData,
            CategoryBannerInterface::class
        );

        return $categorybannerDataObject;
    }
}
