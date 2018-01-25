<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ApiRequest.
 *
 * @package namespace App\Entities;
 */
class ApiRequest extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id', 'login_id', 'report_name','job_name','begin_date', 'end_date', 'campaign_ids', 'advertiser_ids',
        'cost_per_lead', 'cost_per_goal_lead', 'cost_per_visit', 'click_tru', 'click_to_call', 'position', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'api_report';

    public $timestamps= true;

}
