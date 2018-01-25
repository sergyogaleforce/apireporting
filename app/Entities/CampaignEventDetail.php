<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CampaignEventDetail.
 *
 * @package namespace App\Entities;
 */
class CampaignEventDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'job_id','last_updated', 'advertiser_id',' advertiser_name', 'advertiser_code', 'campaign_id', 'campaign_name', 'event_type_name',
        'event_type_id', 'event_time', 'call_result', 'call_target', 'call_duration', 'universal_ip', 'tracking_code', 'customer_name',
        'customer_email', 'customer_address', 'customer_city', 'customer_state', 'customer_zip_code', 'customer_country', 'email_target',
        'web_event_id', 'web_event_name', 'web_event_submited', 'web_event_url', 'web_event_referent_url', 'call_recording_url'

    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= 'campevent_detail';

    public $timestamps= true;

}
