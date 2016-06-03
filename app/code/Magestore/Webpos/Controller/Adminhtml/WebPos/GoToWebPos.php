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
namespace Magestore\Webpos\Controller\Adminhtml\WebPos;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\StoreCookieManagerInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreIsInactiveException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\ResultFactory;
/**
 * class \Magestore\Webpos\Controller\Adminhtml\Webpos\GoToWebPos
 * 
 * Action to go to Web POS page
 * Methods:
 *  execute
 * 
 * @category    Magestore
 * @package     Magestore\Webpos\Controller\Adminhtml\Webpos
 * @module      Webpos
 * @author      Magestore Developer
 */
class GoToWebPos extends \Magestore\Webpos\Controller\Adminhtml\AbstractAction
{
    /**
     *
     * @var \Magento\Store\Model\Data\StoreConfigFactory 
     */
    protected $_storeConfigFactory;
    
    /**
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Store\Model\Data\StoreConfigFactory $storeConfigFactory
     * @param \Magento\Backend\App\Action\Context $context
     * @param StoreCookieManagerInterface $storeCookieManager
     * @param HttpContext $httpContext
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\Data\StoreConfigFactory $storeConfigFactory,
        StoreCookieManagerInterface $storeCookieManager,
        HttpContext $httpContext,
        StoreRepositoryInterface $storeRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeConfigFactory = $storeConfigFactory;
        $this->storeCookieManager = $storeCookieManager;
        $this->httpContext = $httpContext;
        $this->storeRepository = $storeRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context,$resultPageFactory,$resultLayoutFactory,$resultForwardFactory);
    }
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $storeId = $this->getRequest()->getParam('webpos_storeid');
        $storeModel = $this->_objectManager->create('Magento\Store\Model\Store')->load($storeId);
        $storeCode = $storeModel->getCode();;

        try {
            $store = $this->storeRepository->getActiveStoreByCode($storeCode);
        } catch (StoreIsInactiveException $e) {
            $error = __('Requested store is inactive');
        } catch (NoSuchEntityException $e) {
            $error = __('Requested store is not found');
        }

        if (isset($error)) {
            $this->messageManager->addError($error);
            $isSecured = (int)$this->storeManager->getStore()->isCurrentlySecure();
            $urlRedirect = $storeModel->getBaseUrl(UrlInterface::URL_TYPE_WEB, $isSecured).'webpos';
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($urlRedirect);
        }

        $defaultStoreView = $this->storeManager->getDefaultStoreView();
        if ($defaultStoreView->getId() == $store->getId()) {
            $this->storeCookieManager->deleteStoreCookie($store);
        } else {
            $this->httpContext->setValue(Store::ENTITY, $store->getCode(), $defaultStoreView->getCode());
            $this->storeCookieManager->setStoreCookie($store);
        }

        $isSecured = (int)$this->storeManager->getStore()->isCurrentlySecure();
        $urlRedirect = $storeModel->getBaseUrl(UrlInterface::URL_TYPE_WEB, $isSecured).'webpos';
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath($urlRedirect);
    }
}
