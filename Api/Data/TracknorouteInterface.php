<?php
namespace Raveinfosys\Tracknoroute\Api\Data;

interface TracknorouteInterface
{
    const ID       = 'id';
    const URL       = 'url';
    const STATUS         = 'status';
    const COUNT       = 'count';
    const REMOTE_ADDRESS = 'remote_address';
    const REFERRAL_URL   = 'referral_url';
    const CREATED_DATE     = 'created_date';
    const UPDATED_DATE     = 'updated_date';
    public function getId();
    public function getUrl();
    public function getStatus();
    public function getCount();
    public function getRemoteAddress();
    public function getRefferalUrl();
    public function getCreatedDate();
    public function getUpdatedDate();
    public function setId($id);
    public function setUrl($url);
    public function setStatus($status);
    public function setCount($count);
    public function setRemoteAddress($remote_address);
    public function setRefferalUrl($refferal_url);
    public function setCreatedDate($created_date);
    public function setUpdatedDate($updated_date);
}
