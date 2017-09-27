<?php
namespace Raveinfosys\Tracknoroute\Controller\Adminhtml\Tracknoroute;

class Save extends \Magento\Backend\App\Action
{
    public $messageManager;
    public $tracknoroute;
    public $UrlRewrite;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteFactory $urlRewriteFactory,
        \Magento\UrlRewrite\Model\UrlRewrite $UrlRewrite,
        \Raveinfosys\Tracknoroute\Model\Tracknoroute $tracknoroute
    ) {
    
        
        $this->messageManager = $context->getMessageManager();
        $this->tracknoroute = $tracknoroute;
        $this->UrlRewrite = $UrlRewrite;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->tracknoroute;
        if ($data = $this->getRequest()->getPost()) {
            if (strpos($data['request_path'], '//') !== false) {
                $this->messageManager->addError(__('Do not use two or more consecutive slashes in the request path.'));
                return $resultRedirect->setPath('*/*/form', ['id' => $data['tracknoroute_id']]);
            }
            try {
                $urlRewriteModel = $this->UrlRewrite;
                $urlRewriteModel->setId(null);
                $urlRewriteModel->setEntityType('cms-page');
                $urlRewriteModel->setStoreId($data['store_id']);
                $urlRewriteModel->setIsSystem(0);
                $urlRewriteModel->setRedirectType($data['redirect_type']);
                $urlRewriteModel->setIdPath(rand(1, 100000));
                $urlRewriteModel->setTargetPath($data['target_path']);
                $urlRewriteModel->setRequestPath($data['request_path']);
                $urlRewriteModel->save();
                $model->load($data['tracknoroute_id']);
                if ($model->getData()) {
                    $model->setStatus(1);
                    $model->save();
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
            $this->messageManager->addSuccess(__('URL Redirect Created Successfully.'));
        } else {
            $messageManager->addError(__('Some errors in creating url redirect, please try again.'));
        }
        return $resultRedirect->setPath('tracknoroute/tracknoroute/index');
    }
}
