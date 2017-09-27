<?php
namespace Raveinfosys\Tracknoroute\Block\Adminhtml\Form;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    public $_coreRegistry = null;
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Add New URL Rewrite'));
        return parent::_prepareLayout();
    }

    public function _construct()
    {
        $this->_objectId = 'post_id';
        $this->_blockGroup = 'Raveinfosys_Tracknoroute';
        $this->_controller = 'adminhtml_form';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save'));
    }

    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
