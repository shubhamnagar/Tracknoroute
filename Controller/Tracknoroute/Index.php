<?php
namespace Raveinfosys\Tracknoroute\Controller\Tracknoroute;

class Index extends \Magento\Cms\Controller\Noroute\Index
{
    public $resultForwardFactory;
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Raveinfosys\Tracknoroute\Model\Tracknoroute');
        $model->checkAndSave($this->getRequest()->getServer());
        $pageId = $this->_objectManager->get(
            'Magento\Framework\App\Config\ScopeConfigInterface',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )->getValue(
            \Magento\Cms\Helper\Page::XML_PATH_NO_ROUTE_PAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $pageHelper = $this->_objectManager->get('Magento\Cms\Helper\Page');
        $resultPage = $pageHelper->prepareResultPage($this, $pageId);
        if ($resultPage) {
            $resultPage->setStatusHeader(404, '1.1', 'Not Found');
            $resultPage->setHeader('Status', '404 File not found');
            return $resultPage;
        } else {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');
            return $resultForward;
        }
    }
}
