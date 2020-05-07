<?php
namespace Lof\CategoryBannerSlider\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Layout;
use Lof\CategoryBannerSlider\Block\Banner;
use Lof\CategoryBannerSlider\Helper\Data;

/**
 * Class AddBlock
 * @package Lof\CategoryBannerSlider\Observer
 */
class AddBlock implements ObserverInterface
{

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * AddBlock constructor.
     *
     * @param RequestInterface $request
     * @param Data $helperData
     */
    public function __construct(
        RequestInterface $request,
        Data $helperData
    )
    {
        $this->request = $request;
        $this->helperData = $helperData;
    }

    /**
     * @param Observer $observer
     *
     * @return $this
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        if (!$this->helperData->getEnable()) {
            return $this;
        }

        $type = array_search($observer->getEvent()->getElementName(), [
            'header' => 'header',
            'content' => 'content',
            'page-top' => 'page.top',
            'footer-container' => 'footer-container',
            'sidebar' => 'catalog.leftnav'
        ], true);

        if ($type !== false) {
            /** @var Layout $layout */
            $layout = $observer->getEvent()->getLayout();
            $fullActionName = $this->request->getFullActionName();
            $output = $observer->getTransport()->getOutput();

            foreach ($this->helperData->getActiveBannerSlider() as $Banner) {
                $locations = array_filter(explode(',', $Banner->getLocation()));
                foreach ($locations as $value) {
                    list($pageType, $location) = explode('.', $value);
                    if (($fullActionName === $pageType || $pageType === 'allpage') &&
                        strpos($location, $type) !== false
                    ) {
                        $content = $layout->createBlock(Banner::class)
                            ->setBanner($Banner)
                            ->toHtml();

                        if (strpos($location, 'top') !== false) {
                            $output = "<div id=\"lof-bannerslider-block-before-{$type}-{$Banner->getId()}\">
                                        $content</div>" . $output;
                        } else {
                            $output .= "<div id=\"lof-bannerslider-block-after-{$type}-{$Banner->getId()}\">
                                        $content</div>";
                        }
                    }
                }
            }

            $observer->getTransport()->setOutput($output);
        }

        return $this;
    }
}