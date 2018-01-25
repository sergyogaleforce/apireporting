<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CampaignDailyActivity.
 *
 * @package namespace App\Entities;
 */
class CampaignDailyActivity extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'job_id', 'report_date', 'advertiser_id',' advertiser_name', 'advertiser_code', 'campaign_id', 'campaign_name', 'campaign_spend',
        'campaign_adjustment', 'campaign_fees', 'visits', 'impressions', 'calls', 'emails', 'coupons','web_links', 'web_events',
        'last_updated'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'campdaily_activity';

    public $timestamps= true;

}
