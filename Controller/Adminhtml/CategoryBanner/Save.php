<?php
/**
 * Copyright (c) 2019 landofcoder
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

namespace Lof\CategoryBannerSlider\Controller\Adminhtml\CategoryBanner;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config;
use Magento\Framework\App\Filesystem\DirectoryList;
use Lof\CategoryBannerSlider\Model\CategoryBannerFactory;

/**
 * Class Save
 *
 * @package Lof\CategoryBannerSlider\Controller\Adminhtml\CategoryBanner
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Date filter instance
     *
     * @var Date
     */
    protected $_dateFilter;

    /**
     * @var Config
     */
    protected $mediaConfig;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * @var CategoryBannerFactory
     */
    protected $_categoryFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param Date $dateFilter
     * @param Config $mediaConfig
     * @param DirectoryList $mediaDirectory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param CategoryBannerFactory $categoryFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Lof\CategoryBannerSlider\Model\CategoryBanner\Media\Config $mediaConfig,
        DirectoryList $mediaDirectory,
        \Magento\Framework\Filesystem $filesystem,
        \Lof\CategoryBannerSlider\Model\CategoryBannerFactory $categoryFactory
    ) {
        $this->_filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->mediaConfig = $mediaConfig;
        $this->_dateFilter = $dateFilter;
        $this->dataPersistor = $dataPersistor;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $inputFilter = new \Zend_Filter_Input(
                ['create_at' => $this->_dateFilter],
                [],
                $data
            );
            $data = $inputFilter->getUnescaped();
            $id = $this->getRequest()->getParam('banner_id');
            $model = $this->_categoryFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Categorybanner no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);
            if (isset($data['categorybanner']['media_gallery'])) {
                $mediaGallery = $data['categorybanner']['media_gallery'];
                $json = [];
                if ($mediaGallery) {
                    foreach ($mediaGallery['images'] as $key => $image) {
                        if (!isset($image['file']) || $image['file'] == '') {
                            unset($mediaGallery['images'][$key]);
                            continue;
                        }
                        if (isset($image['removed']) && $image['removed'] == 1) {
                            unset($mediaGallery['images'][$key]);
                            continue;
                        }
                        $json[$key] = $image['file'];
                    }
                    $json = json_encode($json);
                    $model->setImages($json);
                }
            }

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Categorybanner.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Categorybanner.'));
            }
            // save data in session
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
