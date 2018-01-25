<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CampaignDailyActivityRepository;
use App\Entities\CampaignDailyActivity;
//use App\Validators\CampaignDailyActivityValidator;

/**
 * Class CampaignDailyActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CampaignDailyActivityRepositoryEloquent extends BaseRepository implements CampaignDailyActivityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CampaignDailyActivity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
