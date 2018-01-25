<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 1/18/2018
 * Time: 7:08 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class DownloadRequest extends FormRequest
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
            'job_id'=>'string',
            'job_name'=>'string',

        ];


    }
}