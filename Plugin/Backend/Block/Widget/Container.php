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

namespace Extait\WidgetsTransfer\Plugin\Backend\Block\Widget;

use Extait\WidgetsTransfer\Plugin\AbstractPlugin;
use Magento\Backend\Block\Widget\Form\Container as Subject;
use Extait\WidgetsTransfer\Helper\Data as WidgetsHelper;

class Container extends AbstractPlugin
{
    /**
     * Set back url as the widgets pro table if user from it.
     */
    public function aroundGetBackUrl(Subject $subject, \Closure $proceed)
    {
        $backURL = $proceed();
        $table = $subject->getRequest()->getParam('table');

        if ($table === WidgetsHelper::PARAM_WIDGET_PRO ||
            ($this->widgetsHelper->isModuleEnabled() &&
            $this->widgetsHelper->isAllowedDisplayingDefaultPage() === false)) {
            $backURL = $this->urlBuilder->getUrl('extait_widgets/widget/index');
        }

        return $backURL;
    }

    /**
     * Add the table param if user from the widgets pro table.
     */
    public function aroundGetDeleteUrl(Subject $subject, \Closure $proceed)
    {
        $deleteURL = $proceed();
        $table = $subject->getRequest()->getParam('table');

        if ($table === WidgetsHelper::PARAM_WIDGET_PRO ||
            ($this->widgetsHelper->isModuleEnabled() &&
            $this->widgetsHelper->isAllowedDisplayingDefaultPage() === false)) {
            $deleteURL = $this->urlBuilder->getUrl('*/*/delete', [
                'instance_id' => $subject->getRequest()->getParam('instance_id'),
                'table' => $table,
            ]);
        }

        return $deleteURL;
    }
}
