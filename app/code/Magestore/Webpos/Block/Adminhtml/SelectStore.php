<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Webpos
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
namespace Magestore\Webpos\Block\Adminhtml;

/**
 * class \Magestore\Webpos\Block\Adminhtml\SelectStore
 * 
 * Web POS list store block
 * Methods:
 * 
 * @category    Magestore
 * @package     Magestore\Webpos\Adminhtml
 * @module      Webpos
 * @author      Magestore Developer
 */
class SelectStore extends \Magento\Backend\Block\Store\Switcher
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('sc_store_select');
    }
}
