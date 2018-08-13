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

namespace Extait\WidgetsTransfer\Controller\Adminhtml\Widget;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Widget\Model\ResourceModel\Widget\Instance\Collection as WidgetCollection;

class MassDelete extends Action
{
    /**
     * @var \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection
     */
    protected $widgetCollection;

    /**
     * MassDelete constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $widgetCollection
     */
    public function __construct(Context $context, WidgetCollection $widgetCollection)
    {
        parent::__construct($context);

        $this->widgetCollection = $widgetCollection;
    }

    /**
     * Widgets mass delete.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $selected = $this->getRequest()->getParam('selected');
        $widgetsIDs = $selected;

        if (!isset($selected)) {
            $excluded = $this->getRequest()->getParam('excluded');

            if ($excluded !== false) {
                $this->widgetCollection->addFieldToFilter('instance_id', ['nin' => $excluded]);
            }

            $widgetsIDs = $this->widgetCollection->getAllIds();
        }

        foreach ($widgetsIDs as $widgetsID) {
            /** @var \Magento\Widget\Model\Widget\Instance $widget */
            $widget = $this->widgetCollection->getItemById($widgetsID);

            $widget->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($widgetsIDs)));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }
}
