<?php
namespace Raveinfosys\Tracknoroute\Block\Adminhtml\Form\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    public $optionProvider;
    public $_allStores = null;
    public $_requireStoresFilter = false;
    public $_systemStore;
    public $registry;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\UrlRewrite\Model\OptionProvider $optionProvider,
        array $data = []
    ) {
        $this->optionProvider = $optionProvider;
        $this->_systemStore = $systemStore;
        $this->registry = $registry->registry('tracknoroute_form');
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function _construct()
    {
        parent::_construct();
        $this->setId('post_form');
        $this->setTitle(__('Post Information'));
    }

    public function _prepareForm()
    {
        $model = $this->registry;

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('post_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('URL Rewrite Information')]
        );

        if ($model->getPostId()) {
            $fieldset->addField('post_id', 'hidden', ['name' => 'post_id']);
        }

        $this->_prepareStoreElement($fieldset);

        $fieldset->addField(
            'request_path',
            'text',
            [
                'label' => __('Request Path'),
                'title' => __('Request Path'),
                'name' => 'request_path',
                'required' => true,
                'value' => $model->getUrl(),
            ]
        );

        $fieldset->addField(
            'tracknoroute_id',
            'hidden',
            [
                'name' => 'tracknoroute_id',
                'value' => $model->getId(),
            ]
        );

        $fieldset->addField(
            'target_path',
            'text',
            [
                'label' => __('Target Path'),
                'title' => __('Target Path'),
                'name' => 'target_path',
                'required' => true,
                'disabled' => false,
            ]
        );

        $fieldset->addField(
            'redirect_type',
            'select',
            [
                'label' => __('Redirect Type'),
                'title' => __('Redirect Type'),
                'name' => 'redirect_type',
                'options' => $this->optionProvider->toOptionArray(),
                'value' => '301',
            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => __('Description'),
                'title' => __('Description'),
                'name' => 'description',
                'cols' => 20,
                'rows' => 5,
                'wrap' => 'soft'
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function _prepareStoreElement($fieldset)
    {
        if ($this->_storeManager->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'store_id', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
        } else {
            $storeElement = $fieldset->addField(
                'store_id',
                'select',
                [
                    'label' => __('Store'),
                    'title' => __('Store'),
                    'name' => 'store_id',
                    'required' => true,
                ]
            );
            try {
                $stores = $this->_getStoresListRestrictedByEntityStores($this->_getEntityStores());
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $stores = [];
                $storeElement->setAfterElementHtml($e->getMessage());
            }
            $storeElement->setValues($stores);
        }
    }

    private function _getStoresListRestrictedByEntityStores(array $entityStores)
    {
        $stores = $this->_getAllStores();
        if ($this->_requireStoresFilter) {
            foreach ($stores as $i => $store) {
                if (isset($store['value']) && $store['value']) {
                    $found = false;
                    foreach ($store['value'] as $k => $v) {
                        if (isset($v['value']) && in_array($v['value'], $entityStores)) {
                            $found = true;
                        } else {
                            unset($stores[$i]['value'][$k]);
                        }
                    }
                    if (!$found) {
                        unset($stores[$i]);
                    }
                }
            }
        }

        return $stores;
    }

    public function _getAllStores()
    {
        if ($this->_allStores === null) {
            $this->_allStores = $this->_systemStore->getStoreValuesForForm();
        }

        return $this->_allStores;
    }
    public function _getEntityStores()
    {
        return $this->_getAllStores();
    }
}
