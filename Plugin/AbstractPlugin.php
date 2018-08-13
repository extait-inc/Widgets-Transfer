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

namespace Extait\WidgetsTransfer\Plugin;

use Extait\WidgetsTransfer\Helper\Data as WidgetsHelper;
use Magento\Framework\App\Response\Http;
use Magento\Framework\UrlInterface;

abstract class AbstractPlugin
{
    /**
     * @var \Extait\WidgetsTransfer\Helper\Data
     */
    protected $widgetsHelper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\Response\Http
     */
    protected $response;

    /**
     * AbstractPlugin constructor.
     *
     * @param \Extait\WidgetsTransfer\Helper\Data $widgetsHelper
     */
    public function __construct(WidgetsHelper $widgetsHelper, UrlInterface $urlBuilder, Http $response)
    {
        $this->widgetsHelper = $widgetsHelper;
        $this->urlBuilder = $urlBuilder;
        $this->response = $response;
    }
}
