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

namespace Extait\WidgetsTransfer\Plugin\Widget\Controller;

use Extait\WidgetsTransfer\Plugin\AbstractPlugin;
use Magento\Widget\Controller\Adminhtml\Widget\Instance\Delete as Subject;
use Extait\WidgetsTransfer\Helper\Data as WidgetsHelper;

class Delete extends AbstractPlugin
{
    /**
     * Change redirect on the widgets pro table if user from it.
     */
    public function afterExecute(Subject $subject)
    {
        $table = $subject->getRequest()->getParam('table');

        if ($table === WidgetsHelper::PARAM_WIDGET_PRO ||
            ($this->widgetsHelper->isModuleEnabled() &&
            $this->widgetsHelper->isAllowedDisplayingDefaultPage() === false)) {
            $this->response->setRedirect($this->urlBuilder->getUrl('extait_widgets/widget/index'));
        }
    }
}
