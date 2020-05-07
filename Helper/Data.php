<?php
/**
 * Copyright (c) 2019 landofcoder.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Lof\CategoryBannerSlider\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Lof\CategoryBannerSlider\Model\CategoryBannerFactory;

/**
 * Class Data
 *
 * @package Lof\CategoryBannerSlider\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var StoreManager
     */
    protected $_storeManager;

    protected $_categoryBannerFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $HttpContext;

    const XML_PATH_AUTO_PLAY_SLIDER = 'lofcategorybannerslider/slider/auto_play_slider';
    const XML_PATH_SELECT_ANIMATION_SLIDER = 'lofcategorybannerslider/slider/auto_play_slider';

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManager $_storeManager
     */
    public function __construct(Context $context, StoreManager $_storeManager,
                                ScopeConfigInterface $scopeConfig,
                                CategoryBannerFactory $categoryBannerFactory,
                                HttpContext $HttpContext)
    {
        $this->HttpContext =$HttpContext;
        $this->_categoryBannerFactory = $categoryBannerFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $_storeManager;
        parent::__construct($context);
    }

    /**
     * @param $key
     * @param null $store
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig($key, $store = null)
    {
        $store = $this->_storeManager->getStore($store);
        $result = $this->scopeConfig->getValue(
            $key,
            ScopeInterface::SCOPE_STORE,
            $store
        );
        return $result;
    }


    public function getSystemconfig($xmlpath)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue($xmlpath, $storeScope);
    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }


    /**
     * @param null $storeId
     * @return mixed
     */
    public function getEnable($storeId = null)
    {
        return $this->getConfig('lofcategorybannerslider/general/enabled', $storeId);
    }


    /**
     * @return \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection
     */
    public function getActiveBannerSlider()
    {
        /** @var \Lof\CategoryBannerSlider\Model\ResourceModel\CategoryBanner\Collection $collection */
        $collection = $this->_categoryBannerFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_group_id', [
                'finset' => $this->HttpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)
            ])
            ->addFieldToFilter('status', 1)->addOrder(' priority');

        return $collection;
    }
}
