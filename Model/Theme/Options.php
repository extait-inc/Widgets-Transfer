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

namespace Extait\WidgetsTransfer\Model\Theme;

use Magento\Framework\App\Area;
use Magento\Framework\Option\ArrayInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;

class Options implements ArrayInterface
{
    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory
     */
    protected $themeCollectionFactory;

    /**
     * Options constructor.
     *
     * @param \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory
     */
    public function __construct(ThemeCollectionFactory $themeCollectionFactory)
    {
        $this->themeCollectionFactory = $themeCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $collection = $this->themeCollectionFactory->create()->addFieldToFilter('area', Area::AREA_FRONTEND);
        $options = [];

        foreach ($collection->getItems() as $theme) {
            $options[] = ['value' => $theme->getData('theme_id'), 'label' => $theme->getData('theme_title')];
        }

        return $options;
    }
}
