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

namespace Extait\WidgetsTransfer\Block\Adminhtml;

use Extait\WidgetsTransfer\Helper\Data as WidgetsHelper;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;

/** @api */
class HiddenMenuItems extends Template
{
    /**
     * @var \Extait\WidgetsTransfer\Helper\Data
     */
    protected $widgetsHelper;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * HiddenMenuItems constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Extait\WidgetsTransfer\Helper\Data $widgetsHelper
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        Context $context,
        WidgetsHelper $widgetsHelper,
        EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->widgetsHelper = $widgetsHelper;
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * Get Json config with module configuration.
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->jsonEncoder->encode(
            [
                'isModuleEnabled' => $this->widgetsHelper->isModuleEnabled(),
                'isAllowedDisplayingDefaultPage' => $this->widgetsHelper->isAllowedDisplayingDefaultPage(),
            ]
        );
    }
}
