<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AdvertiserSummaryActivity.
 *
 * @package namespace App\Entities;
 */
class AdvertiserSummaryActivity extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'job_id', 'advertiser_id', 'advertiser_name','advertiser_code', 'campaign_spend', 'campaign_adjustment', 'campaign_fees',
        'total_visits', 'total_impressions', 'total_calls', 'total_emails', 'total_coupons', 'total_web_links', 'total_web_events',
        'last_updated'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'advertiser_summary';

    public $timestamps= true;

}
