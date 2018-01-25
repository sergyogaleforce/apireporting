<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertiserSummaryActivityRequest extends FormRequest
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
            'advertiser_ids'=>'string'
        ];
    }
}
