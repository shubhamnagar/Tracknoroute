<?php
namespace Raveinfosys\Tracknoroute\Model\ResourceModel\Tracknoroute;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public $_idFieldName = 'post_id';
    public function _construct()
    {
        $this->_init(
            'Raveinfosys\Tracknoroute\Model\Tracknoroute',
            'Raveinfosys\Tracknoroute\Model\ResourceModel\Tracknoroute'
        );
    }
}
