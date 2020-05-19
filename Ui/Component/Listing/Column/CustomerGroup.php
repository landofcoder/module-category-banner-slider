<?php

namespace Lof\CategoryBannerSlider\Ui\Component\Listing\Column;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\ResourceModel\Group\Collection as GroupCollection;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class CustomerGroup
 * @package Lof\CategoryBannerSlider\Ui\Component\Listing\Column
 */
class CustomerGroup extends Column
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var GroupCollection
     */
    protected $customerGroup;

    /**
     * CustomerGroup constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param GroupRepositoryInterface $groupRepository
     * @param GroupCollection $GroupCollection
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        GroupRepositoryInterface $groupRepository,
        GroupCollection $GroupCollection,
        array $components = [],
        array $data = []
    )
    {
        $this->groupRepository = $groupRepository;
        $this->customerGroup = $GroupCollection;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->getData('name')])) {
                    $item[$this->getData('name')] = $this->prepareItem($item);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get customer group name
     * @param array $item
     *
     * @return \Magento\Framework\Phrase|string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareItem(array $item)
    {
        $content = [];
        $origGroup = $item[$this->getData('name')];
        if (!is_array($origGroup)) {
            $origGroup = explode(',', $origGroup);
        }

        $origGroup = array_intersect($this->customerGroup->getAllIds(), $origGroup);
        foreach ($origGroup as $group) {
            $content[] = $this->groupRepository->getById($group)->getCode();
        }

        if (empty($content) || count($content) === $this->customerGroup->count()) {
            return __('All Customer Groups');
        }

        return implode(', ', $content);
    }
}
