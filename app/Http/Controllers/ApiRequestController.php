<?php

namespace App\Http\Controllers;

use App\Entities\ApiRequest;
use App\Entities\CampaignSummaryActivity;
use App\Entities\InfoLoginToReachLocal;
use App\Http\Requests\AdvertiserSummaryActivityRequest;
use App\Http\Requests\CampaignStatusMetricRequest;
use App\Http\Requests\CampaignSummaryActivityRequest;
use App\Http\Requests\DownloadRequest;
use App\Repositories\ApiRequestRepository;
use App\Repositories\CampaignSummaryActivityRepository;
use Carbon\Carbon;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Revolution\Google\Sheets;
use Google;
use App\Helpers\LoginReachLocal;



use GuzzleHttp\Client;

use GuzzleHttp\Exception\ClientException;



class ApiRequestController extends Controller
{
    /**
     * Get the Report Request and process it
     *
     * @param CampaignSummaryActivityRequest $request
     * @return json array
     */



    public function report_request(CampaignSummaryActivityRequest $request)
    {
        $params = $request->all();
        $rpt_type = $params['report'];
        if($rpt_type == "Campaign_Summary_Activity" || $rpt_type == "Campaign_Daily_Activity" || $rpt_type == "Campaign_Event_Detail"
        || $rpt_type == "Advertiser_Summary_Activity" || $rpt_type == "Campaign_Metrics"){

            $api_request = new ApiRequest();
            $api_request->login_id = $params['login_id'];
            $api_request->report_name = $params['report'];
            $api_request->job_name = isset($params['job_name']) ? $params['job_name'] : "job_".random_int(1, 1000000);
            $api_request->begin_date = isset($params['begin_date']) ? $params['begin_date'] : null;
            $api_request->end_date = isset($params['end_date']) ? $params['end_date'] : null;
            $api_request->campaign_ids = isset($params['campaign_ids']) ? $params['campaign_ids'] : null;
            $api_request->advertiser_ids = isset($params['advertiser_ids']) ? $params['advertiser_ids'] : null;
            $api_request->cost_per_lead = isset($params['cost_per_lead']) ? $params['cost_per_lead'] : null;
            $api_request->cost_per_goal_lead = isset($params['cost_per_goal_lead']) ? $params['cost_per_goal_lead'] : null;
            $api_request->cost_per_visit = isset($params['cost_per_visit']) ? $params['cost_per_visit'] : null;
            $api_request->click_tru = isset($params['click_tru']) ? $params['click_tru'] : null;
            $api_request->click_to_call = isset($params['click_to_call']) ? $params['click_to_call'] : null;
            $api_request->position = isset($params['position']) ? $params['position'] : null;
            $api_request->status = "scheduled";
            $api_request->save();

            return response()->json(array(
                'code' => 200,
                'job_id' => $api_request->id,
                'message'  => "Ok"
            ));
        }else{
            return response()->json(array(
                'error' => 444,
                'message' => "Wrong report type"
            ));
        }

    }
    /**
     * Get a Download Request and process it
     *
     * Verify what kind of report the user want download
     * When the status is completed download report and update the excel
     *
     * @param DownloadRequest $request
     * Require job_id or job_name
     *
     * @return json object
     */

    public function report_download(DownloadRequest $request)
    {
        if(isset($request->input('job_id')) || isset($request->input('job_name')))
        {
            $params = $request->all();
            $repo = app('App\Repositories\ApiRequestRepository');
            $request = null;
            if(isset($params['job_id'])) {
                if ($params['job_id'] == "") {
                    return response()->json(array(
                        'error' => 400,
                        'message' => "Require job_id or job_name"
                    ));
                }
                $request = ApiRequest::find($params['job_id']);
            }else{
                if ($params['job_name'] == "") {
                    return response()->json(array(
                        'error' => 400,
                        'message' => "Require job_id or job_name"
                    ));
                }
                $request = $repo->where('job_name', $params['job_name'])->orwhere('job_id', $params['job_id']);
                if($request->count() > 0)
                    $request = $request->first();
                else
                    $request = null;
            }

            if($request == null){
                return response()->json(array(
                    'error' => 444,
                    'message' => "No qualified data to report"
                ));
            }else {
                if($request->status == "completed"){

                    //excel
                    Sheets\Sheets::setService(Google::make('sheets'));

                    if($request->report_name == "Campaign_Summary_Activity"){
                        Sheets\Sheets::spreadsheet(config('GOOGLE_SHEET_CAMP_SUM_ID'));
                        $header = $rows->pull(0);
                        $values = Sheets\Sheets::collection($header, $rows);
                        $values->toArray();

                        $results = app('App\Repositories\CampaignSummaryActivityRepository')->where('job_id', $request->id)->all();

                        if(count($results) > 0) {
                            foreach ($results as $reportline) {
                                $found = false;
                                $row = 2;
                                foreach ($values as $excelline) {
                                    if ($excelline['campaign_id'] == $reportline['campaign_id']) {
                                        $found = true;
                                        Sheets\Sheets::sheet('Sheet 1')->range('A' . $row)->update([$reportline]);
                                    }
                                    $row++;
                                }
                                if (!$found) {
                                    Sheets\Sheets::sheet('Sheet 1')->range('')->append([$reportline]);
                                }
                            }
                        }

                    }
                    elseif($request->report_name == "Campaign_Daily_Activity"){
                        Sheets\Sheets::spreadsheet(config('GOOGLE_SHEET_CAMP_DAILY_ID'));
                        $header = $rows->pull(0);
                        $values = Sheets\Sheets::collection($header, $rows);
                        $values->toArray();

                        $results = app('App\Repositories\CampaignDailyActivityRepository')->where('job_id', $request->id)->all();
                        if(count($results) > 0) {
                            foreach ($results as $reportline) {
                                $found = false;
                                $row = 2;
                                foreach ($values as $excelline) {
                                    if ($excelline['campaign_id'] == $reportline['campaign_id'] &&
                                        $excelline['report_date'] == $reportline['report_date']
                                    ) {
                                        $found = true;
                                        Sheets\Sheets::sheet('Sheet 1')->range('A' . $row)->update([$reportline]);
                                    }
                                    $row++;
                                }
                                if (!$found) {
                                    Sheets\Sheets::sheet('Sheet 1')->range('')->append([$reportline]);
                                }
                            }
                        }

                    }
                    elseif($request->report_name == "Campaign_Event_Detail"){

                    }
                    elseif($request->report_name == "Advertiser_Summary_Activity"){
                        Sheets\Sheets::spreadsheet(config('GOOGLE_SHEET_ADV_SUM_ID='));
                        $header = $rows->pull(0);
                        $values = Sheets\Sheets::collection($header, $rows);
                        $values->toArray();
                        $results = app('App\Repositories\AdvertiserSummaryActivityRepository')->where('job_id', $request->id)->all();
                        if(count($results) > 0) {
                            foreach ($results as $reportline) {
                                $found = false;
                                $row = 2;
                                foreach ($values as $excelline) {
                                    if ($excelline['advertiser_id'] == $reportline['advertiser_id']
                                    ) {
                                        $found = true;
                                        Sheets\Sheets::sheet('Sheet 1')->range('A' . $row)->update([$reportline]);
                                    }
                                    $row++;
                                }
                                if (!$found) {
                                    Sheets\Sheets::sheet('Sheet 1')->range('')->append([$reportline]);
                                }
                            }
                        }

                    }
                    else{
                        Sheets\Sheets::spreadsheet(config('GOOGLE_SHEET_CAMP_METRICS_ID='));
                        $header = $rows->pull(0);
                        $values = Sheets\Sheets::collection($header, $rows);
                        $values->toArray();
                        $results = app('App\Repositories\CampaignSatatusMetricsRepository')->where('job_id', $request->id)->all();
                        if(count($results) > 0) {
                            foreach ($results as $reportline) {
                                $found = false;
                                $row = 2;
                                foreach ($values as $excelline) {
                                    if ($excelline['campaign_id'] == $reportline['campaign_id']) {
                                        $found = true;
                                        Sheets\Sheets::sheet('Sheet 1')->range('A' . $row)->update([$reportline]);
                                    }
                                    $row++;
                                }
                                if (!$found) {
                                    Sheets\Sheets::sheet('Sheet 1')->range('')->append([$reportline]);
                                }
                            }
                        }

                    }

                    return response()->json(array(
                        'error' => '',
                        'code' => 200,
                        'message' => "Ok"
                    ));

                }else{
                    return response()->json(array(
                        'error' => 400,
                        'message' => "Report job is not completed: status=".$request->status
                    ));
                }
            }

        }else{
            return response()->json(array(
                'error' => 400,
                'message' => "Require job_id or job_name"
            ));
        }
    }



}
