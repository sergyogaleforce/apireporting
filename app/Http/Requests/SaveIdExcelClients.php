<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveIdExcelClients extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * The user must provide the Excel IDs obtained from Google SpreetSheet
     * This rules aren't request
     * @return array
     */


    public function rules()
    {
        return [
            'campaign_summary_activity'=>'string',
            'campaign_daily_activity'=>'string',
            'advertiser_summary_activity'=>'string',
            'campaign_status_metric'=>'string',
            'campaign_event_detail'=>'string',
        ];
    }
}
