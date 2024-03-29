<?php
namespace Lof\CategoryBannerSlider\Ui\Component\CategoryBanner;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\AbstractComponent;


class MassActions extends AbstractComponent
{
    const NAME = 'massaction';

    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * Constructor
     *
     * @param AuthorizationInterface $authorization
     * @param ContextInterface $context
     * @param UiComponentInterface[] $components
     * @param array $data
     */
    public function __construct(
        AuthorizationInterface $authorization,
        ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        $this->authorization = $authorization;
        parent::__construct($context, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function prepare() : void
    {
        $config = $this->getConfiguration();

        foreach ($this->getChildComponents() as $actionComponent) {
            $actionType = $actionComponent->getConfiguration()['type'];
            if ($this->isActionAllowed($actionType)) {
                // phpcs:ignore Magento2.Performance.ForeachArrayMerge
                $config['actions'][] = array_merge($actionComponent->getConfiguration(), ['__disableTmpl' => true]);
            }
        }
        $origConfig = $this->getConfiguration();
        if ($origConfig !== $config) {
            $config = array_replace_recursive($config, $origConfig);
        }

        $this->setData('config', $config);
        $this->components = [];

        parent::prepare();
    }

    /**
     * @inheritdoc
     */
    public function getComponentName() : string
    {
        return static::NAME;
    }

    /**
     * Check if the given type of action is allowed
     *
     * @param string $actionType
     * @return bool
     */
    public function isActionAllowed($actionType) : bool
    {
        $isAllowed = true;
        switch ($actionType) {
            case 'delete':
                $isAllowed = $this->authorization->isAllowed('Lof_CategoryBannerSlider::CategoryBanner');
                break;
            default:
                break;
        }
        return $isAllowed;
    }
}
