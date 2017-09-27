<?php
namespace Raveinfosys\Tracknoroute\Model\Tracknoroute;

use \Magento\Framework\Registry as registry;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public $registry;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->loadedData = [];
        $this->loadedData = $this->registry->registry('tracknoroute_form')->getData();
        return $this->loadedData;
    }
}
