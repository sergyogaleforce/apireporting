<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class IdExcelClients.
 *
 * @package namespace App\Entities;
 */
class IdExcelClients extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id','campaign_summary_activity', 'campaign_daily_activity', 'advertiser_summary_activity',
        'campaign_status_metrics', 'campaign_event_detail'];



}
