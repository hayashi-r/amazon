<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $awsAccessKeyIdUS = 'AKIAJ3W2Y6O7ZIKID3DA';
    protected $awsAccessKeyIdEU = 'AKIAJZNSTFU53FUIOGOA';
    protected $sellerId;
    protected $marketplaceId;
    protected $mwsAuthToken;
    protected $action;
    protected $reportType;
    protected $signatureMethod = 'HmacSHA256';
    protected $signatureVersion = '2';
    protected $timestamp;
    protected $version;
    protected $startDate;
    public $url;

    public function __construct($sellerId, $marketplaceId, $mwsAuthToken)
    {
      $this->sellerId = $sellerId;
      $this->marketplaceId = $marketplaceId;
      $this->mwsAuthToken = $mwsAuthToken;
      $this->action = 'RequestReport';
      $this->reportType = '_GET_FLAT_FILE_ACTIONABLE_ORDER_DATA_';
      $this->timestamp = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
      $this->version = '2009-01-01';
      $this->startDate = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() - 5.098e+6); // 59days
    }
}
