/**
 * requirejs-config
 *
 * @copyright Copyright © 2020 Landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

var config = {
    map: {
        '*': {
            plugins: "Lof_CategoryBannerSlider/js/plugins",
            cameraBanner: 'Lof_CategoryBannerSlider/js/camera.min',
            slick: 'Lof_CategoryBannerSlider/js/slick.min',
            easing: 'Lof_CategoryBannerSlider/js/easing.min',
            modernizr: 'Lof_CategoryBannerSlider/js/modernizr.min',
        }
    },
    paths: {
        cameraBanner: 'Lof_CategoryBannerSlider/js/camera.min',
        slick: 'Lof_CategoryBannerSlider/js/slick.min',
        easing: 'Lof_CategoryBannerSlider/js/easing.min',
        modernizr: 'Lof_CategoryBannerSlider/js/modernizr.min',
    },
    shim: {
        cameraBanner: {
            deps: ['jquery'],
        },
        slick: {
            deps: ['jquery'],
        },
        easing: {
            deps: ['jquery'],
        },
        modernizr: {
            deps: ['jquery'],
        },
    }
};

