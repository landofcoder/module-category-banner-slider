/**
 * requirejs-config
 *
 * @copyright Copyright © 2020 Landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

var config = {
    paths: {
        cameraBanner: 'Lof_CategoryBannerSlider/js/camera.min',
        easing: 'Lof_CategoryBannerSlider/js/jquery.easing.1.3',
    },
    shim: {
        cameraBanner: {
            deps: ['jquery'],
        },
        easing: {
            deps: ['jquery'],
        },
    }
};

