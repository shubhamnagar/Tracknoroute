<?php
namespace Raveinfosys\Tracknoroute\Block;

class Nocache extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

   /*<referenceContainer name="content">
       <block class="Raveinfosys\Tracknoroute\Block\Nocache" name="default_home_page_nocache" cacheable="false"/>
	</referenceContainer>*/
}
