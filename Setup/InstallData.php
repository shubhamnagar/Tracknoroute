<?php

namespace Raveinfosys\Tracknoroute\Setup;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class InstallData implements InstallDataInterface
{
   
    protected $pageFactory;
    protected $scopeConfig;
    public function __construct(
        PageFactory $pageFactory,
        ScopeConfigInterface $scopeConfig
    ) {
    
        $this->pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $noroutepageValue = $this->getMyValue();
        $noroutepageValue = $noroutepageValue ? $noroutepageValue : 'no-route';
        $noRoutePage = $this->UpdatePage()->load($noroutepageValue, 'identifier');
        $xmlToSave = '<referenceContainer name="content">
                       <block class="Raveinfosys\Tracknoroute\Block\Nocache" name="default_home_page_nocache" cacheable="false"/>
                      </referenceContainer>';
        $xml = $noRoutePage->getLayoutUpdateXml();
        $newXML = $xml.$xmlToSave;
        $noRoutePage->setLayoutUpdateXml($newXML)->save();
    }

    public function UpdatePage()
    {
        return $this->pageFactory->create();
    }

    public function getMyValue()
    {
        return $this->scopeConfig->getValue('web/default/cms_no_route');
    }
}
