<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{

    protected $table = 'reports';

    protected $awsAccessKeyId = "";
    protected $endpoint = "";
    protected $sellerId = "";
    protected $marketplaceId = "";
    protected $mwsAuthToken = "";
    protected $action;
    protected $reportType;
    protected $signatureMethod = 'HmacSHA256';
    protected $signatureVersion = '2';
    protected $timestamp;
    protected $version;
    protected $startDate;
    public $url;
    public $orderarray;
    protected $secret;

    public function __construct($sellerId, $marketplace, $mwsAuthToken)
    {

      $this->marketplace = $marketplace;

      if($this->marketplace === "Amazon.com"){
        $this->awsAccessKeyId = env('AWS_ACCESSKEYID_US', "");
        $this->marketplaceId = env('AWS_MARKETPLACEID_US', "");
        $this->endpoint = env('AWS_ENDPOINT_NA', "");
        $this->secret = env('AWS_SECRETKEY_US', "");
        } else {
        $this->awsAccessKeyId = env('AWS_ACCESSKEYID_UK', "");
        $this->marketplaceId = env('AWS_MARKETPLACEID_UK', "");
        $this->endpoint = env('AWS_ENDPOINT_EU', "");
        $this->secret = env('AWS_SECRETKEY_UK', "");



        }

      $this->sellerId = $sellerId;
      $this->mwsAuthToken = $mwsAuthToken;
      $this->action = 'RequestReport';
      $this->reportType = '_GET_FLAT_FILE_ACTIONABLE_ORDER_DATA_';
      $this->timestamp = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
      $this->version = '2009-01-01';
      $this->startDate = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() - 5.098e+6); // 59days
      
    }

    
    public function requestReport()
    {
   

      $param = array();
      $param['AWSAccessKeyId']   = $this->awsAccessKeyId;
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
      $sign .= $this->endpoint . "\n";
      $sign .= '/' . "\n";
      $sign .= $arr;

      $signature = hash_hmac("sha256", $sign, $secret, true);
      $signature = urlencode(base64_encode($signature));

      $link  = "https://" . $this->endpoint. "/?";
      $link .= $arr . "&Signature=" . $signature;
      // dd($link); //for debugging - you can paste this into a browser and see if it loads.

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

     return $requestId;


    }

    public function requestReportRequestList($requestId)
    {

      $this->requestId = $requestId;

      $param = array();
      $param['AWSAccessKeyId']   = $this->awsAccessKeyId;
      $param['Action']           = 'GetReportRequestList';
      $param['ReportRequestIdList.Id.1']           = $requestId;
      $param['SellerId']         = $this->sellerId;
      $param['MarketplaceIdList.Id.1'] = $this->marketplaceId;
      $param['MWSAuthToken'] = $this->mwsAuthToken;
      $param['SignatureMethod']  = $this->signatureMethod;
      $param['SignatureVersion'] = $this->signatureVersion;
      $param['Timestamp']        = $this->timestamp;
      $param['Version']          = $this->version;

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
      $sign .= $this->endpoint . "\n";
      $sign .= '/' . "\n";
      $sign .= $arr;

      $signature = hash_hmac("sha256", $sign, $secret, true);
      $signature = urlencode(base64_encode($signature));

      $link  = "https://" . $this->endpoint. "/?";
      $link .= $arr . "&Signature=" . $signature;
      // dd($link); //for debugging - you can paste this into a browser and see if it loads.

      $ch = curl_init($link);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response = curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);

      $xml = (array)simplexml_load_string($response);

      $json = json_encode($xml);
      $reportDetails = json_decode($json,TRUE);

      $reportStatus = $reportDetails['GetReportRequestListResult']['ReportRequestInfo']['ReportProcessingStatus'];


      if($reportStatus === "_DONE_")
      {
        $generatedReportId = $reportDetails['GetReportRequestListResult']['ReportRequestInfo']['GeneratedReportId'];
        return $generatedReportId;
      } else {
        return $reportStatus;
      }


    }

    public function getAmazonReport($generatedReportId)
    {
      $param = array();
      $param['AWSAccessKeyId']   = $this->awsAccessKeyId;
      $param['Action']           = 'GetReport';
      $param['ReportId']           = $generatedReportId;
      $param['SellerId']         = $this->sellerId;
      $param['MarketplaceIdList.Id.1'] = $this->marketplaceId;
      $param['MWSAuthToken'] = $this->mwsAuthToken;
      $param['SignatureMethod']  = $this->signatureMethod;
      $param['SignatureVersion'] = $this->signatureVersion;
      $param['Timestamp']        = $this->timestamp;
      $param['Version']          = $this->version;

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
      $sign .= $this->endpoint . "\n";
      $sign .= '/' . "\n";
      $sign .= $arr;

      $signature = hash_hmac("sha256", $sign, $secret, true);
      $signature = urlencode(base64_encode($signature));

      $link  = "https://" . $this->endpoint. "/?";
      $link .= $arr . "&Signature=" . $signature;
     // dd($link); //for debugging - you can paste this into a browser and see if it loads.


       $csv = array_map(function($v){return str_getcsv($v, "\t");}, file($link));
           array_walk($csv, function(&$a) use ($csv) {
             $a = array_combine($csv[0], $a);
           });
           array_shift($csv); # remove column header

      // echo '<pre>' , var_dump($csv) , '</pre>';
      
           $orderarray = [];

      foreach($csv as $data => $orderdata){
        $orderarray[] = [
        'custid' => 100,
        'orderid' => $orderdata['order-id'],
        'purchasedate' => $orderdata['purchase-date'],
        'shipby' => $orderdata['promise-date'],
        'buyeremail' => $orderdata['buyer-email'],
        'buyername' => $orderdata['buyer-name'],
        'buyerphone' => $orderdata['buyer-phone-number'],
        'sku' => $orderdata['sku'],
        'productname' => $orderdata['product-name'],
        'qtypurchased' => (INT)$orderdata['quantity-purchased'],
        'shiplevel' => $orderdata['ship-service-level'],
        'recipient' => $orderdata['recipient-name'],
        'address1' => $orderdata['ship-address-1'],
        'address2' => $orderdata['ship-address-2'],
        'address3' => $orderdata['ship-address-3'],
        'city' => $orderdata['ship-city'],
        'state' => $orderdata['ship-state'],
        'postalcode' => $orderdata['ship-postal-code'],
        'country' => $orderdata['ship-country'],
        'businessorder' => $orderdata['is-business-order'] == 'true' ? 1 : 0,
        'marketplace' => $this->marketplace,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
        ];

      }

      \DB::table('order')->insert($orderarray);

      return redirect()->route('orders');

    }
    
    

}
