<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the commercial license
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category Extait
 * @package Extait_WidgetsTransfer
 * @copyright Copyright (c) 2016-2018 Extait, Inc. (http://www.extait.com)
 */

namespace Extait\WidgetsTransfer\Model\Widget\Type;

use Magento\Framework\Option\ArrayInterface;
use Magento\Widget\Model\Widget\Instance as WidgetModel;

class Options implements ArrayInterface
{
    /**
     * @var \Magento\Widget\Model\Widget\Instance
     */
    protected $widgetModel;

    /**
     * Options constructor.
     *
     * @param \Magento\Widget\Model\Widget\Instance $widgetModel
     */
    public function __construct(WidgetModel $widgetModel)
    {
        $this->widgetModel = $widgetModel;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->widgetModel->getWidgetsOptionArray('type');
    }
}
