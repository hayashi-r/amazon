<?php

namespace App\Http\Controllers;

use App\Reports;
// use App\Mwsauth;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $mwsdata = \App\Mwsauth::where('marketplace_id', $id)->firstOrFail();
        
        $sellerId = $mwsdata->seller_id;
        $marketplaceId = $mwsdata->marketplace_id;
        $mwsAuthToken = $mwsdata->token;
             
        
        $requestReport = new Reports($sellerId, $marketplaceId, $mwsAuthToken);
        $requestId = $requestReport->requestReport();

        if(isset($requestId))
        {
          $reportRequestList = new Reports();
          $getReportStatus = $reportRequestList->requestReportRequestList($requestId);

        if($getReportStatus === "_DONE_")
         {

           $generatedReportId = $reportRequestList->requestReportRequestList($requestId);
          } else {
            sleep(20);
            $reportNewRequestList = new Reports();
            // $reportRequestList->requestReportRequestList($requestId);
            $generatedReportId = $reportRequestList->requestReportRequestList($requestId);
          }

          // Check if Report ID available, if not do something

            if(!$generatedReportId) {
              echo "No Report ID available";
            }

            if(isset($generatedReportId))
            {
              $newAmazonReport = new Reports();
              $amazonReport = $newAmazonReport->getAmazonReport($generatedReportId);

              

            }


        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }
}
