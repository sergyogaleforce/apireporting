<?php

namespace App\Http\Controllers;

use App\Entities\ApiRequest;
use App\Entities\CampaignDailyActivity;
use App\Entities\CampaignSatatusMetrics;
use App\Entities\CampaignSummaryActivity;
use App\Entities\InfoLoginToReachLocal;
use App\Http\Requests\ExecuteJobRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use App\Helpers\LoginReachLocal;

class ApiReportController extends Controller
{

    /*public function probando_coneccion()
    {
        return response()->json(array(
            'error' => "",
            'code' => 200,
            'message' => "Ok"));
    }*/

    /**
     * Get a ExceuteJobRequest Request and process it, executing a Campaign Summary Activity Report
     *
     * Verify the request status be scheduled and process it
     *
     *
     * @param ExecuteJobRequest $request
     *      *
     * @return json object
     */


    public function execute_campaign_summary_report(ExecuteJobRequest $request){
        $api_request = ApiRequest::find($request->input('job_id'));
        if(isset($api_request)){
            if($api_request->status == "scheduled"){

                $log_info = login();
                $data = json_decode($log_info);
                if ($data['error'] == "") {

                    $client = $this->get_client($log_info->access_token);
                    $params = array();
                    $adv_id = $api_request->adverstiser_ids;
                    if($api_request->beign_date != "" && $api_request->end_date != "") {
                        if ($api_request->begin_date != "") $params['start_date'] = $api_request->beign_date;
                        if ($api_request->end_date != "") $params['end_date'] = $api_request->end_date;
                    }
                    $camp_ids = explode(',', $api_request->campaign_ids);
                    if(count($camp_ids) > 0)
                        $params['global_master_campaign_id[]'] = $api_request->campaign_ids;
                        $params['interval_size'] = 'calendar_month';

                    try {

                        $response = $client->request('get', '/client_reports/search_activity/'.$adv_id.'?' . http_build_query($params));
                        $status = $response->getStatusCode();
                        if($status == 200){
                            //update status api request
                            $api_request->status = 'running';
                            $api_request->save();

                            //process the data and insert in our database

                            $campaigns = $response['report_data']['campaigns'];
                            foreach ($campaigns as $ind => $camp){
                                $insert = new CampaignSummaryActivity();
                                $insert->job_id = $api_request->id;
                                $insert->advertiser_id = $response['report_data']['global_master_advertiser_id'];
                                $insert->advertiser_name = $response['report_data']['global_master_advertiser_id'];
                                $insert->campaign_id = $response['report_data']['available_campaigns'][$ind]['global_master_campaign_id'];
                                $insert->campaign_name = $response['report_data']['available_campaigns'][$ind]['name'];

                                foreach ($camp['intervals'] as $int){
                                    $insert->total_spend += $int['spend'];
                                    $insert->total_web_events += $int['web_events'];
                                    $insert->total_impressions += $int['impressions'];
                                    $insert->total_calls += $int['calls'];
                                    $insert->total_emails += $int['emails'];
                                }

                                $insert->last_updated = $response['report_data']['data_import_status']['DailyCampaignActivity'];
                                $insert->camp_start_date = $camp['start_date'];
                                $insert->camp_end_date = $camp['end_date'];
                                $insert->camp_target_duration = $this->dateDifference($camp['start_date'], $camp['end_date']);
                                //pendding
                                $insert->camp_budget = 0;
                                $insert->save();
                            }

                            //update status api request
                            $api_request->status = 'completed';
                            $api_request->save();

                            return response()->json(array(
                                'error' => "",
                                'code' => 200,
                                'message' => "Ok"
                            ));

                        }else{
                            return response()->json(array(
                                'error' => $status,
                                'message' => "Error message depend of code"
                            ));
                        }
                    }
                    catch(ServerException $exception){
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }

                }else{
                    return response()->json(array(
                        'error' => 667,
                        'message' => "Login problems on reach local"
                    ));
                }



            }else{
                return response()->json(array(
                    'error' => 555,
                    'message' => "Job is already running"
                ));
            }
        }else{
            return response()->json(array(
                'error' => 444,
                'message' => "No qualified data to report"
            ));
        }
    }
    /**
     * Get a ExceuteJobRequest Request and process it, executing a Campaign Daily Activity Report
     *
     * Verify the request status be scheduled and process it
     *
     *
     * @param ExecuteJobRequest $request
     *      *
     * @return json object
     */
    public function execute_campaign_daily_report(ExecuteJobRequest $request)
    {
        $api_request = ApiRequest::find($request->input('job_id'));
        if (isset($api_request)) {
            if ($api_request->status == "scheduled") {
                $log_info = login();
                $data = json_decode($log_info);
                if ($data['error'] == "") {

                    $client = $this->get_client($log_info->access_token);
                    $params = array();
                    $adv_id = $api_request->adverstiser_ids;
                    if($api_request->beign_date != "" && $api_request->end_date != "") {
                        if ($api_request->begin_date != "") $params['start_date'] = $api_request->beign_date;
                        if ($api_request->end_date != "") $params['end_date'] = $api_request->end_date;
                    }
                    $camp_ids = explode(',', $api_request->campaign_ids);
                    if(count($camp_ids) > 0)
                        $params['global_master_campaign_id[]'] = $api_request->campaign_ids;

                    try {

                        $response = $client->request('get', '/client_reports/display_activity/'.$adv_id.'?' . http_build_query($params));
                        $status = $response->getStatusCode();
                        if ($status == 200) {
                            //update status api request
                            $api_request->status = 'running';
                            $api_request->save();

                            //process the data and insert in our database

                            $campaigns = $response['report_data']['campaigns'];
                            foreach ($campaigns as $ind => $camp){

                                foreach ($camp['intervals'] as $int){
                                    $insert = new CampaignDailyActivity();
                                    $insert->job_id = $api_request->id;
                                    $insert->advertiser_id = $response['report_data']['global_master_advertiser_id'];
                                    $insert->advertiser_name = $response['report_data']['global_master_advertiser_id'];
                                    $insert->campaign_id = $response['report_data']['available_campaigns'][$ind]['global_master_campaign_id'];
                                    $insert->campaign_name = $response['report_data']['available_campaigns'][$ind]['name'];
                                    $insert->total_spend = $int['spend'];
                                    $insert->total_web_events = $int['web_events'];
                                    $insert->total_impressions = $int['impressions'];
                                    $insert->total_calls = $int['calls'];
                                    $insert->total_emails = $int['emails'];
                                    $insert->last_updated = $response['report_data']['data_import_status']['DailyCampaignActivity'];
                                    $insert->report_date = $int['start_date'];
                                    //pendding
                                    $insert->camp_budget = 0;
                                    $insert->save();
                                }

                            }

                            //update status api request
                            $api_request->status = 'completed';
                            $api_request->save();

                            return response()->json(array(
                                'error' => "",
                                'code' => 200,
                                'message' => "Ok"
                            ));

                        } else {
                            return response()->json(array(
                                'error' => $status,
                                'message' => "Error message depend of code"
                            ));
                        }
                    } catch (ServerException $exception) {
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }


                } else {
                    return response()->json(array(
                        'error' => 555,
                        'message' => "Job is already running"
                    ));
                }
            } else {
                return response()->json(array(
                    'error' => 444,
                    'message' => "No qualified data to report"
                ));
            }
        }
    }

    /**
     * Get a ExceuteJobRequest Request and process it, executing a Advertiser Summary Activity Report
     *
     * Verify the request status be scheduled and process it
     *
     *
     * @param ExecuteJobRequest $request
     *      *
     * @return json object
     */

    public function execute_advertiser_summary_report(ExecuteJobRequest $request){
        $api_request = ApiRequest::find($request->input('job_id'));
        if(isset($api_request)){
            if($api_request->status == "scheduled") {

                $log_info = login();
                $data = json_decode($log_info);
                if ($data['error'] == "") {

                    $client = $this->get_client($log_info->access_token);
                    $params = array();
                    $adv_id = $api_request->adverstiser_ids;

                    try {

                        $response = $client->request('get', '/client_reports/campaigns_overview/'.$adv_id);
                        $status = $response->getStatusCode();
                        if($status == 200){

                            //update status api request
                            $api_request->status = 'running';
                            $api_request->save();

                            //process the data and insert in our database
                            $insert = new CampaignSummaryActivity();
                            $insert->job_id = $api_request->id;
                            $insert->advertiser_id = $response['report_data']['global_master_advertiser_id'];
                            $insert->advertiser_name = $response['report_data']['global_master_advertiser_id'];
                            $insert->total_impressions = $response['report_data']['totals']['impressions'];
                            $insert->total_calls = $response['report_data']['totals']['calls'];
                            $insert->total_emails = $response['report_data']['totals']['emails'];
                            $insert->total_web_events = $response['report_data']['totals']['web_events'];
                            $insert->total_visits = $response['report_data']['totals']['clicks'];
                            $insert->campaign_spend = 0;
                            foreach ($response['report_data']['campaigns'] as $camp){
                                foreach ($camp['cycles'] as $c)
                                    $insert->campaign_spend += $c['spend'];
                            }
                            $insert->last_updated = $response['report_data']['DailyCampaignActivity'];
                            $insert->save();

                            //update status api request
                            $api_request->status = 'completed';
                            $api_request->save();

                            return response()->json(array(
                                'error' => "",
                                'code' => 200,
                                'message' => "Ok"
                            ));

                        }else{
                            return response()->json(array(
                                'error' => $status,
                                'message' => "Error message depend of code"
                            ));
                        }
                    }
                    catch(ServerException $exception){
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }

                }else{
                    return response()->json(array(
                        'error' => 667,
                        'message' => "Login problems on reach local"
                    ));
                }

            }else{
                return response()->json(array(
                    'error' => 555,
                    'message' => "Job is already running"
                ));
            }
        }else{
            return response()->json(array(
                'error' => 444,
                'message' => "No qualified data to report"
            ));
        }
    }

    //reach local doesn't has this report detail
    public function execute_event_detail_report(ExecuteJobRequest $request){
        $api_request = ApiRequest::find($request->input('job_id'));
        if(isset($api_request)){
            if($api_request->status == "scheduled"){

                $log_info = login();
                $data = json_decode($log_info);
                if ($data['error'] == "") {

                    $client = $this->get_client($log_info->access_token);
                    $params = array();
                    $adv_id = $api_request->adverstiser_ids;
                    if($api_request->beign_date != "" && $api_request->end_date != "") {
                        if ($api_request->begin_date != "") $params['start_date'] = $api_request->beign_date;
                        if ($api_request->end_date != "") $params['end_date'] = $api_request->end_date;
                    }
                    $camp_ids = explode(',', $api_request->campaign_ids);
                    if(count($camp_ids) > 0)
                        $params['global_master_campaign_id[]'] = $api_request->campaign_ids;

                    try {

                        $response = $client->request('get', '' . http_build_query($params));
                        $status = $response->getStatusCode();
                        if($status == 200){
                            //process the data and insert in our database

                        }else{
                            return response()->json(array(
                                'error' => $status,
                                'message' => "Error message depend of code"
                            ));
                        }
                    }
                    catch(ServerException $exception){
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }

                }else{
                    return response()->json(array(
                        'error' => 667,
                        'message' => "Login problems on reach local"
                    ));
                }


            }else{
                return response()->json(array(
                    'error' => 555,
                    'message' => "Job is already running"
                ));
            }
        }else{
            return response()->json(array(
                'error' => 444,
                'message' => "No qualified data to report"
            ));
        }
    }

    /**
     * Get a ExceuteJobRequest Request and process it, executing a Campaign Status/Metrics Report
     *
     * Verify the request status be scheduled and process it
     *
     *
     * @param ExecuteJobRequest $request
     *      *
     * @return json object
     */

    public function execute_metrics_report(ExecuteJobRequest $request){
        $api_request = ApiRequest::find($request->input('job_id'));
        if(isset($api_request)){
            if($api_request->status == "scheduled"){
                $log_info = login();
                $data = json_decode($log_info);
                if ($data['error'] == "") {

                    $client = $this->get_client($log_info->access_token);
                    $params = array();
                    $adv_id = $api_request->adverstiser_ids;
                    if($api_request->beign_date != "" && $api_request->end_date != "") {
                        if ($api_request->begin_date != "") $params['start_date'] = $api_request->beign_date;
                        if ($api_request->end_date != "") $params['end_date'] = $api_request->end_date;
                    }
                    $camp_ids = explode(',', $api_request->campaign_ids);
                    if(count($camp_ids) > 0)
                        $params['global_master_campaign_id[]'] = $api_request->campaign_ids;
                    $cost_per_lead = explode(',', $api_request->cost_per_lead);
                    $cost_per_good_lead = explode(',', $api_request->cost_per_good_lead);
                    $cost_per_visit = explode(',', $api_request->cost_per_visit);
                    $click_thru = explode(',', $api_request->click_thru);
                    $click_to_call = explode(',', $api_request->click_to_call);
                    $position = explode(',', $api_request->position);

                    try {

                        $response1 = $client->request('get', '/client_reports/search_activity/'.$adv_id.'?' . http_build_query($params));
                        $status1 = $response1->getStatusCode();

                        if($status1 == 200){
                            //update status api request
                            $api_request->status = 'running';
                            $api_request->save();

                            //process the data and insert in our database

                            $campaigns = $response1['report_data']['campaigns'];
                            foreach ($campaigns as $ind => $camp){
                                $insert = new CampaignSatatusMetrics();
                                $insert->job_id = $api_request->id;
                                $insert->advertiser_id = $response1['report_data']['global_master_advertiser_id'];
                                $insert->advertiser_name = $response1['report_data']['global_master_advertiser_id'];
                                $insert->campaign_id = $response1['report_data']['available_campaigns'][$ind]['global_master_campaign_id'];
                                $insert->campaign_name = $response1['report_data']['available_campaigns'][$ind]['name'];
                                $total_impressions=0; $leads = 0;
                                $days=0;
                                foreach ($camp['intervals'] as $int){
                                    $days++;
                                    $insert->campaign_spend += $int['spend'];
                                    $insert->total_web_events += $int['web_events'];
                                    $total_impressions += $int['impressions'];
                                    $leads += $int['leads'];
                                    $insert->total_calls += $int['calls'];
                                    $insert->total_emails += $int['emails'];
                                    $insert->campaign_visits += $int['clicks'];
                                }
                                $insert->cost_per_lead = ($leads != 0) ? $insert->campaign_spend/ $leads : 0;
                                $insert->cost_per_visit = ($insert->campaign_visits > 0) ? $insert->campaign_spend/$insert->campaign_visits : 0;
                                $insert->click_tru_rate = ($total_impressions > 0) ? $insert->campaign_visits/$total_impressions : 0;
                                $insert->click_to_call_rate = ($insert->campaign_visits > 0) ? $insert->total_calls/$insert->campaign_visits : 0;
                                $insert->click_to_web_event = ($insert->campaign_visits > 0) ? $insert->total_web_events/$insert->campaign_visits : 0;
                                //pendding
                                $insert->percent_daily_budget_used = 0; //related to $days
                                $insert->percent_budget_used = 0;
                                $insert->qualified_calls = 0;

                                $insert->save();
                            }

                            //update status api request
                            $api_request->status = 'completed';
                            $api_request->save();

                            return response()->json(array(
                                'error' => "",
                                'code' => 200,
                                'message' => "Ok"
                            ));

                        }else{
                            return response()->json(array(
                                'error' => $status1,
                                'message' => "Error message depend of code"
                            ));
                        }
                    }
                    catch(ServerException $exception){
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }

                }else{
                    return response()->json(array(
                        'error' => 667,
                        'message' => "Login problems on reach local"
                    ));
                }


            }else{
                return response()->json(array(
                    'error' => 555,
                    'message' => "Job is already running"
                ));
            }
        }else{
            return response()->json(array(
                'error' => 444,
                'message' => "No qualified data to report"
            ));
        }
    }

    /**
     * Get a client with the access_token
     *
     *
     * @param $access_token
     *      *
     * @return Client
     */



    private function get_client($access_token){
        return new Client([
            'base_uri' => env('REACHLOCAL_API_URI_RPT'),
            'headers' => [
                'Authorization' => $access_token,
                'Accept' => 'application/json'
            ]
        ]);
    }

    /**
     * Get the different between two dates
     *
     *
     * @param $date_1
     * @param $date_2
     * @return var
     */

    private function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }
}
