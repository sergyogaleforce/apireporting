<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CampaignSatatusMetrics.
 *
 * @package namespace App\Entities;
 */
class CampaignSatatusMetrics extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'job_id', 'campaign_id', 'campaign_name', 'advertiser_id',' advertiser_name', 'advertiser_code',
        'campaign_budget',
        'campaign_spend',
        'campaign_visits', 'total_calls', 'qualified_calls', 'total_emails',
        'total_coupons', 'total_web_events','total_qualified_web_events', 'cost_per_lead', 'cost_per_qualified_lead', 'cost_per_visit',
        'click_tru_rate', 'click_to_call_rate', 'position', 'percent_daily_budget_used', 'percent_budget_used', 'click_to_web_event'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'camp_status_metrics';

    public $timestamps= true;

}
