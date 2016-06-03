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

namespace Magestore\Webpos\Controller;

use Magento\Framework\App\RequestInterface;

/**
 * class \Magestore\Webpos\Controller\Webpos
 * 
 * Web POS controller abstract action 
 * Methods:
 *  createBlock
 *  dispatch
 * @category    Magestore
 * @package     Magestore\Webpos\Controller
 * @module      Webpos
 * @author      Magestore Developer
 */
abstract class AbstractAction extends \Magento\Framework\App\Action\Action
{
    /**
     * Webpos constructor.
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }
 
    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * Security
     */
    public function dispatch(RequestInterface $request)
    {
        return parent::dispatch($request);
    }
}