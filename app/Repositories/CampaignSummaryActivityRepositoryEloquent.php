<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CampaignSummaryActivityRepository;
use App\Entities\CampaignSummaryActivity;
//use App\Validators\CampaignSummaryActivityValidator;

/**
 * Class CampaignSummaryActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CampaignSummaryActivityRepositoryEloquent extends BaseRepository implements CampaignSummaryActivityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CampaignSummaryActivity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
