<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CampaignSummaryActivity.
 *
 * @package namespace App\Entities;
 */
class CampaignSummaryActivity extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'job_id', 'advertiser_id',' advertiser_name', 'advertiser_code', 'campaign_id', 'campaign_name', 'total_spend',
        'total_adjustment', 'total_fees', 'total_visits', 'total_impressions', 'total_calls', 'total_emails', 'total_coupons',
        'total_web_links', 'total_web_events','last_updated', 'camp_start_date', 'camp_end_date', 'camp_target_duration',
        'camp_budget'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'campsummary_activity';

    public $timestamps= true;
}
