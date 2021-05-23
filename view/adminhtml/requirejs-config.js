/**
 * requirejs-config
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */


var config = {
    deps: [
        "mage/adminhtml/browser",
        "Lof_CategoryBannerSlider/js/browser"
    ],
    map: {
        '*': {
            categoryBannerGallery: 'Lof_CategoryBannerSlider/js/category-banner-gallery',
            'mage/adminhtml/browser': 'Lof_CategoryBannerSlider/js/browser'
        }
    },
    shim: {
        'Lof_CategoryBannerSlider/js/browser': ["jquery"]
    }
};
