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

namespace Extait\WidgetsTransfer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * Config XML paths.
     */
    const CONFIG_XML_PATH_MODULE_ENABLE = 'extait_widgets_transfer/general/enable_module';
    const CONFIG_XML_PATH_ALLOWED_CLONING = 'extait_widgets_transfer/general/clone';
    const CONFIG_XML_PATH_DEFAULT_PAGE = 'extait_widgets_transfer/general/default_widgets_page';

    /**
     * This param use for redirect an user on the widget pro table if an user from it
     */
    const PARAM_WIDGET_PRO = 'pro';

    /**
     * Check whether the module is enabled or not.
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_MODULE_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether it is allowed cloning widgets to the same theme or not.
     *
     * @return bool
     */
    public function isAllowedCloningToSameTheme()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_ALLOWED_CLONING, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether it is allowed displaying the default widgets page or not.
     *
     * @return bool
     */
    public function isAllowedDisplayingDefaultPage()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_DEFAULT_PAGE, ScopeInterface::SCOPE_STORE);
    }
}
