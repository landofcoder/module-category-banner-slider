# Mage2 Module Lof CategoryBannerSlider

    ``lof/module-categorybannerslider``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Magento 2 Category Banner extension allows you to add banner images on category pages and display them in an attractive slider. Its extensive features include slider themes, animation effects, slider duration, pause on hover, pagination and auto play etc. You can also configure banner dimensions, banner title and content in the slider.

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Lof`
 - Enable the module by running `php bin/magento module:enable Lof_CategoryBannerSlider`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require lof/module-categorybannerslider`
 - enable the module by running `php bin/magento module:enable Lof_CategoryBannerSlider`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Helper
	- Lof\CategoryBannerSlider\Helper\Data


## Attributes



