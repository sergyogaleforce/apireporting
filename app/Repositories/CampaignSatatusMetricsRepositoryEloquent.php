<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CampaignSatatusMetricsRepository;
use App\Entities\CampaignSatatusMetrics;
use App\Validators\CampaignSatatusMetricsValidator;

/**
 * Class CampaignSatatusMetricsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CampaignSatatusMetricsRepositoryEloquent extends BaseRepository implements CampaignSatatusMetricsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CampaignSatatusMetrics::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
