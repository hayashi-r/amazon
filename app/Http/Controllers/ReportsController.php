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
    public function create()
    {
        $mwsdata = \App\Mwsauth::orderBy('created_at', 'desc')->first();
        
        $sellerId = $mwsdata->seller_id;
        $mwsAuthToken = $mwsdata->token;  
        $marketplace = $mwsdata->marketplace_name;
        
               
        $requestReport = new Reports($sellerId, $marketplace, $mwsAuthToken);
        $requestId = $requestReport->requestReport();

        if(isset($requestId))
        {
          $getReportStatus = $requestReport->requestReportRequestList($requestId);

        if($getReportStatus === "_DONE_")
         {

           $generatedReportId = $requestReport->requestReportRequestList($requestId);
          } else {
            sleep(20);
            $generatedReportId = $requestReport->requestReportRequestList($requestId);
          }

          // Check if Report ID available, if not do something

            if(!$generatedReportId) {
              echo "No Report ID available";
            }

            if(isset($generatedReportId))
            {
                $amazonReport = $requestReport->getAmazonReport($generatedReportId);
 
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
