<?php
namespace Raveinfosys\Tracknoroute\Model\ResourceModel;

class Tracknoroute extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public $_date;
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }
    public function _construct()
    {
        $this->_init('tracknoroute', 'id');
    }
    public function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        return parent::_beforeSave($object);
    }

    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'url';
        }

        return parent::load($object, $value, $field);
    }

    public function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $select->where(
                'is_active = ?',
                1
            )->limit(
                1
            );
        }

        return $select;
    }
}
