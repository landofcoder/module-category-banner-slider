<?php
namespace Lof\CategoryBannerSlider\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class BannerConfigProvider implements ConfigProviderInterface{

    public function getConfig()
    {
        $config = [];
        $config['autoAdvance'] = true;
        return $config;
    }
}
