<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{

    protected $table = 'reports';

    protected $awsAccessKeyIdUS;
    protected $awsAccessKeyIdEU;
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
    protected $secret;

    public function __construct()
    {
      $this->awsAccessKeyIdUS = 'AKIAJ3W2Y6O7ZIKID3DA';
      $this->awsAccessKeyIdEU = config('aws.accesskeyiduk');
      $this->sellerId = 'A1G4PRG75E40ML';
      $this->marketplaceId = 'ATVPDKIKX0DER';
      $this->mwsAuthToken = 'amzn.mws.9aa46736-63c5-1cf9-7ae7-5c76c1a65299';
      $this->action = 'RequestReport';
      $this->reportType = '_GET_FLAT_FILE_ACTIONABLE_ORDER_DATA_';
      $this->timestamp = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
      $this->version = '2009-01-01';
      $this->startDate = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() - 5.098e+6); // 59days
      $this->secret = '7y0iZ3mF42K7HmFA42if2BFpYt7WQHyoXCcO2M6S';
    }

    public function requestReport()
    {

      $param = array();
      $param['AWSAccessKeyId']   = $this->awsAccessKeyIdUS;
      $param['Action']           = $this->action;
      $param['ReportType']           = $this->reportType;
      $param['SellerId']         = $this->sellerId;
      $param['MarketplaceIdList.Id.1'] = $this->marketplaceId;
      $param['MWSAuthToken'] = $this->mwsAuthToken;
      $param['SignatureMethod']  = $this->signatureMethod;
      $param['SignatureVersion'] = $this->signatureVersion;
      $param['Timestamp']        = $this->timestamp;
      $param['Version']          = $this->version;
      $param['StartDate']    = $this->startDate;

      $secret = $this->secret;

      $url = array();
      foreach ($param as $key => $val) {

          $key = str_replace("%7E", "~", rawurlencode($key));
          $val = str_replace("%7E", "~", rawurlencode($val));
          $url[] = "{$key}={$val}";
      }

      sort($url);

      $arr   = implode('&', $url);

      $sign  = 'GET' . "\n";
      $sign .= 'mws.amazonservices.com' . "\n";
      $sign .= '/' . "\n";
      $sign .= $arr;

      $signature = hash_hmac("sha256", $sign, $secret, true);
      $signature = urlencode(base64_encode($signature));

      $link  = "https://mws.amazonservices.com/?";
      $link .= $arr . "&Signature=" . $signature;
      // echo($link); //for debugging - you can paste this into a browser and see if it loads.

      $ch = curl_init($link);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response = curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);

      $xml = (array)simplexml_load_string($response);

      $json = json_encode($xml);
      $reportRequestId = json_decode($json,TRUE);

      $requestId = $reportRequestId['RequestReportResult']['ReportRequestInfo']['ReportRequestId'];

      $saveID = 

      return redirect()->action(
      'ReportsController@getReportRequestList', ['requestId' => $requestId]
       );

    }

    public function requestReportRequestList()
    {

      $this->requestId = $requestId;

      dd($requestId);

    }

}
