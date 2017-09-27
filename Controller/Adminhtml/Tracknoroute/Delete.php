<?php
namespace Raveinfosys\Tracknoroute\Controller\Adminhtml\Tracknoroute;

class Delete extends \Magento\Backend\App\Action
{
    public $_urlRewriteFactory;
    public $messageManager;
    public $tracknoroute;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Raveinfosys\Tracknoroute\Model\Tracknoroute $tracknoroute
    ) {
    
        $this->messageManager = $context->getMessageManager();
        $this->tracknoroute = $tracknoroute;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        if ($data = $this->getRequest()->getParams()) {
            if (isset($data['selected'])) {
                try {
                    $count = 0;
                    $model = $this->tracknoroute;
                    $collection = $model->getCollection();
                    $collection->addFieldToFilter('id', ['in' => $data['selected']]);
                    foreach ($collection as $key => $value) {
                        $value->delete();
                        $count++;
                    }
                    if ($count > 1) {
                        $this->messageManager->addSuccess(__($count.' Entries Deleted Successfully.'));
                    } else {
                        $this->messageManager->addSuccess(__('Entry Deleted Successfully.'));
                    }
                } catch (\Exception $e) {
                    $this->messageManager->addError(__($e->getMessage()));
                }
            } else {
                $this->messageManager->addError(__('Some Error In Processing Your Request, Please Try Again!'));
            }
        } else {
            $this->messageManager->addError(__('Please select entries!'));
        }
        return $resultRedirect->setPath('tracknoroute/tracknoroute/index');
    }
}
