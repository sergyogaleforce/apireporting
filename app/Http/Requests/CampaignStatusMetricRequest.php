<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStatusMetricRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login_id'=>'required|string',
            'api_key'=>'required|string',
            'report'=> 'required|string',
            'job_name'=>'string',
            'begin_date'=>'date',
            'end_date'=>'date',
            'cost_per_lead'=>'string',
            'cost_per_good_lead'=>'string',
            'cost_per_visit'=>'string',
            'click_thru'=>'string',
            'click_to_call'=>'string',
            'position'=>'string',
            'campaign_ids'=>'string',
            'advertiser_ids'=>'string',
        ];
    }
}
