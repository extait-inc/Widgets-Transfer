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
use Magento\Widget\Model\Widget\InstanceFactory;
use Extait\WidgetsTransfer\Helper\Data as WidgetsHelper;

class MassClone extends Action
{
    /**
     * @var \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection
     */
    protected $widgetCollection;

    /**
     * @var \Magento\Widget\Model\Widget\InstanceFactory
     */
    protected $widgetFactory;

    /**
     * @var \Extait\WidgetsTransfer\Helper\Data
     */
    protected $widgetsHelper;

    /**
     * MassClone constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $widgetCollection
     * @param \Magento\Widget\Model\Widget\InstanceFactory $widgetFactory
     * @param \Extait\WidgetsTransfer\Helper\Data $widgetsHelper
     */
    public function __construct(
        Context $context,
        WidgetCollection $widgetCollection,
        InstanceFactory $widgetFactory,
        WidgetsHelper $widgetsHelper
    ) {
        parent::__construct($context);

        $this->widgetCollection = $widgetCollection;
        $this->widgetFactory = $widgetFactory;
        $this->widgetsHelper = $widgetsHelper;
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

        $themeID = $this->getRequest()->getParam('theme_id');
        $countWidgets = count($widgetsIDs);
        $countSuccessful = $countWidgets;

        foreach ($widgetsIDs as $widgetsID) {
            $widget = $this->widgetFactory->create()->load($widgetsID);
            $widgetData = $widget->getData();

            if ($this->widgetsHelper->isAllowedCloningToSameTheme() === false && $widgetData['theme_id'] == $themeID) {
                $countSuccessful--;
                continue;
            }

            $clonedData = $this->prepareData($widgetData, $themeID);
            $clonedWidget = $this->widgetFactory->create()->setData($clonedData);
            $clonedWidget->save();
        }

        if ($countSuccessful === count($widgetsIDs)) {
            $this->messageManager->addSuccessMessage(__('All widgets have been added to the theme successfully.'));
        } elseif ($countSuccessful === 0) {
            if ($countWidgets === 1) {
                $this->messageManager->addWarningMessage(__('This widget has been already added!'));
            } else {
                $this->messageManager->addWarningMessage(__('These widgets have been already added!'));
            }
        } else {
            $this->messageManager->addSuccessMessage(
                __(
                    '%1 from %2 widgets have been added to the theme. %3 widgets were added earlier.',
                    $countSuccessful,
                    $countWidgets,
                    $countWidgets - $countSuccessful
                )
            );
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }

    /**
     * Data preparation.
     *
     * @param array $data
     * @param $themeID
     * @return array
     */
    private function prepareData(array $data, $themeID)
    {
        $groups = [];

        foreach ($data['page_groups'] as $pageGroup) {
            $groups[] = [
                'page_group' => $pageGroup['page_group'],
                $pageGroup['page_group'] => [
                    'page_id' => '0',
                    'for' => $pageGroup['page_for'],
                    'layout_handle' => $pageGroup['layout_handle'],
                    'block' => $pageGroup['block_reference'],
                    'template' => $pageGroup['page_template'],
                    'entities' => $pageGroup['entities'],
                ],

            ];
        }

        $data['page_groups'] = $groups;
        $data['theme_id'] = $themeID;
        unset($data['instance_id']);

        return $data;
    }
}
