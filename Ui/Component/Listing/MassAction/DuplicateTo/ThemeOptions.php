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

namespace Extait\WidgetsTransfer\Ui\Component\Listing\MassAction\DuplicateTo;

use Zend\Stdlib\JsonSerializable;
use Extait\WidgetsTransfer\Model\Theme\Options;
use Magento\Framework\UrlInterface;

class ThemeOptions implements JsonSerializable
{
    /**
     * @var \Extait\WidgetsTransfer\Model\Theme\Options
     */
    protected $themeOptions;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /*
     * @var array
     */
    protected $data;

    /**
     * ThemeOptions constructor.
     *
     * @param \Extait\WidgetsTransfer\Model\Theme\Options $themeOptions
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(Options $themeOptions, UrlInterface $urlBuilder, array $data = [])
    {
        $this->themeOptions = $themeOptions;
        $this->data = $data;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get action options
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $themeOptions = $this->themeOptions->toOptionArray();
        $options = [];

        foreach ($themeOptions as $themeOption) {
            $options[] = [
                'type' => 'theme_' . $themeOption['value'],
                'label' => $themeOption['label'],
                'confirm' => $this->data['confirm'],
                'url' => $this->urlBuilder->getUrl($this->data['url'], [
                    $this->data['param'] => $themeOption['value'],
                ]),
            ];
        }

        return $options;
    }
}
