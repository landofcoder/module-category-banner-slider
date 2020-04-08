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
     * CategoryBanner status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

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

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
