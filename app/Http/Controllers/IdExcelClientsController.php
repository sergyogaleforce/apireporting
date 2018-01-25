<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveIdExcelClients;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Entities\IdExcelClients;
use Illuminate\Support\Facades\Auth;

class IdExcelClientsController extends Controller
{


    /**
     * Get the Excel's IDs, for the user logged in and and shows them in the view's fields
     * Return view whit a object IDExcelClients
     *
     * @return view
     */

    public function show_id_excel_clients()
    {
        $user_id= Auth::id();


        $query = IdExcelClients::where('user_id', $user_id)->first();


            return view('idexcel',  compact('query'));

    }

    /**
     * Create Excels' ID (object IdExcelClients) for the user logged in  or update it
     * Return view whit a object IDExcelClients
     * @param SaveIdExcelClients $request
     * @return view
     */

    public function save_id_excel_clients(SaveIdExcelClients $request){

        sleep(0.75);

        $params= $request->all();


            //$created_date= Carbon::now();
            $user_id= Auth::id();

        $query = IdExcelClients::where('user_id', $user_id)->first();

            $id_excels= new IdExcelClients();
            $id_excels->user_id= $user_id;

            $id_excels->campaign_summary_activity= isset($params['campaign_summary_activity']) ? $params['campaign_summary_activity'] : null;
            $id_excels->campaign_daily_activity= isset($params['campaign_daily_activity']) ? $params['campaign_daily_activity'] : null;
            $id_excels->advertiser_summary_activity= isset($params['advertiser_summary_activity']) ? $params['advertiser_summary_activity'] : null;
            $id_excels->campaign_status_metrics= isset($params['campaign_status_metrics']) ? $params['campaign_status_metrics'] : null;
            $id_excels->campaign_event_detail= isset($params['campaign_event_detail']) ? $params['campaign_event_detail'] : null;


            if(!isset($query))
            {
                $id_excels->save();
                $query = IdExcelClients::where('user_id', $user_id)->first();
                return view('idexcel',  compact('query'));

            }
            else
            {


               $query1= IdExcelClients::where('user_id', $user_id)
                    ->update(['campaign_summary_activity' => $params['campaign_summary_activity'], 'campaign_daily_activity' => $params['campaign_daily_activity'],
                              'advertiser_summary_activity' => $params['advertiser_summary_activity'], 'campaign_status_metrics' => $params['campaign_status_metrics'],
                               'campaign_event_detail' => $params['campaign_event_detail']
                             ]);
                $query = IdExcelClients::where('user_id', $user_id)->first();
                return view('idexcel',  compact('query'));
            }








    }
}
