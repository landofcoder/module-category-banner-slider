<?php

namespace Lof\CategoryBannerSlider\Block\Banner;

use Magento\Framework\View\Element\Template;

class View extends Template
{
    /**
     * @var string $_template
     */
    protected $_template = "banner.phtml";

    public function __construct(Template\Context $context)
    {
        parent::__construct($context);
    }

}
