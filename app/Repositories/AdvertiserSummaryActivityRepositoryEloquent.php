<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdvertiserSummaryActivityRepository;
use App\Entities\AdvertiserSummaryActivity;
//use App\Validators\AdvertiserSummaryActivityValidator;

/**
 * Class AdvertiserSummaryActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdvertiserSummaryActivityRepositoryEloquent extends BaseRepository implements AdvertiserSummaryActivityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdvertiserSummaryActivity::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
