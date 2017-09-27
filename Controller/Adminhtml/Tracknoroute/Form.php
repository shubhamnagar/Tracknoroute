<?php
namespace Raveinfosys\Tracknoroute\Controller\Adminhtml\Tracknoroute;

class Form extends \Magento\Backend\App\Action
{
    public $_coreRegistry = null;
    public $tracknoroute;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Raveinfosys\Tracknoroute\Model\Tracknoroute $tracknoroute
    ) {
    
        $this->_coreRegistry = $coreRegistry;
        $this->tracknoroute = $tracknoroute;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $this->tracknoroute;
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model->load($id);
        }
        $url = $model->checkUrlForForm($model->getUrl());
        $model->setUrl($url);
        $this->_coreRegistry->register('tracknoroute_form', $model);
        if ($model->getStatus()) {
            $this->messageManager->addError(__('URL Redirect Already Created For "'.$model->getUrl().'".'));
            return $resultRedirect->setPath('*/*/index');
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
