<?php
/**
 * CategoryBanner
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

namespace Lof\CategoryBannerSlider\Model;

use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class CategoryBanner
 *
 * @package Lof\CategoryBannerSlider\Model
 */
class CategoryBanner extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_category_banner';

    const CACHE_TAG = 'category_banner';

    /**
     * @var string
     */
    protected $_cacheTag = 'category_banner';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource
     * @param \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner $resource,
        \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $resourceCollection,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
}
