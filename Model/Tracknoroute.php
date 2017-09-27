<?php
namespace Raveinfosys\Tracknoroute\Model;

use Raveinfosys\Tracknoroute\Api\Data\TracknorouteInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Tracknoroute extends \Magento\Framework\Model\AbstractModel implements TracknorouteInterface, IdentityInterface
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'Track404';
    public $_cacheTag = 'Track404';
    public $_eventPrefix = 'Track404';
    public $requestScheme;
    public $serverName;
    public $redirectUrl;
    public $remoteAddress;
    public $fullUrl;
    public $currentDate;
    public function _construct()
    {
        $this->_init('Raveinfosys\Tracknoroute\Model\ResourceModel\Tracknoroute');
    }
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    
    public function getId()
    {
        return $this->getData(self::ID);
    }
    public function getUrl()
    {
        return $this->getData(self::URL);
    }
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }
    public function getCount()
    {
        return $this->getData(self::COUNT);
    }
    public function getRemoteAddress()
    {
        return $this->getData(self::REMOTE_ADDRESS);
    }
    public function getRefferalUrl()
    {
        return $this->getData(self::REFERRAL_URL);
    }
    public function getCreatedDate()
    {
        return $this->getData(self::CREATED_DATE);
    }
    public function getUpdatedDate()
    {
        return $this->getData(self::UPDATED_DATE);
    }
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
    public function setCount($count)
    {
        return $this->setData(self::COUNT, $count);
    }
    public function setRemoteAddress($remoteaddress)
    {
        return $this->setData(self::REMOTE_ADDRESS, $remoteaddress);
    }
    public function setRefferalUrl($refferalurl)
    {
        return $this->setData(self::REFERRAL_URL, $refferalurl);
    }
    public function setCreatedDate($createddate)
    {
        return $this->setData(self::CREATED_DATE, $createddate);
    }
    public function setUpdatedDate($updateddate)
    {
        return $this->setData(self::UPDATED_DATE, $updateddate);
    }
    public function checkAndSave($request)
    {
        $this->setServerVariables($request);
        $collection = $this->getFilteredCollection();
        if (!empty($collection->getData())) {
            $this->updateExistingEntries($collection);
            return;
        }
        $this->setId(null);
        $this->setUrl($this->fullUrl);
        $this->setStatus(0);
        $this->setCount(1);
        $this->setRemoteAddress($this->remoteAddress);
        $this->setRefferalUrl($this->serverName);
        $this->setCreatedDate($this->currentDate);
        $this->setUpdatedDate($this->currentDate);
        $this->save();
        return;
    }
    public function setServerVariables($request)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        $serverName = $storeManager->getStore()->getBaseUrl();
        $this->requestScheme = $request->REQUEST_SCHEME.'://';
        $this->serverName = $request->SERVER_NAME;
        $this->redirectUrl = $request->REQUEST_URI;
        $this->remoteAddress = $request->REMOTE_ADDR;
        $this->fullUrl = $serverName.substr($this->redirectUrl, 1);
        $this->currentDate = date('Y-m-d H:i:s');
        return;
    }
    public function getFilteredCollection()
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('url', ['like' => $this->fullUrl]);
        $firstItem = $collection->getFirstItem();
        return $firstItem;
    }
    public function updateExistingEntries($collection)
    {
        $currentCount = $collection->getCount();
        $ip = (strpos($collection->getRemoteAddress(), $this->remoteAddress) !== false) ? $collection->getRemoteAddress() : $collection->getRemoteAddress().','.$this->remoteAddress;
        $collection->setCount($currentCount+1);
        $collection->setUpdatedDate($this->currentDate);
        $collection->setRemoteAddress($ip);
        $collection->save();
        return;
    }

    public function checkUrlForForm($url)
    {
        $explodeUrl1 = explode('://', $url);
        if (count($explodeUrl1) > 1) {
            $explodeUrl2 = explode('/', $explodeUrl1['1']);
            if ($explodeUrl2['1'] == 'index.php') {
                $urlToRemove = $explodeUrl1[0].'://'.$explodeUrl2[0].'/'.$explodeUrl2[1].'/';
            } else {
                $urlToRemove = $explodeUrl1[0].'://'.$explodeUrl2[0].'/';
            }
            $finalUrl = explode($urlToRemove, $url);
            if (count($finalUrl) > 1) {
                return $finalUrl[1];
            }
        }
        return $url;
    }
}
