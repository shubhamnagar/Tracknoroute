<?php
namespace Raveinfosys\Tracknoroute\Controller\Adminhtml\Tracknoroute;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    public $resultPageFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Raveinfosys_Tracknoroute::content');
        $resultPage->addBreadcrumb(__('Manage 404 Error Pages'), __('Manage 404 Error Pages'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage 404 Error Pages'));
        return $resultPage;
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Raveinfosys_Tracknoroute::tracknoroute');
    }
}
