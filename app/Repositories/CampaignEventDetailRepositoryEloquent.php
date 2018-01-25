<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CampaignEventDetailRepository;
use App\Entities\CampaignEventDetail;
//use App\Validators\CampaignEventDetailValidator;

/**
 * Class CampaignEventDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CampaignEventDetailRepositoryEloquent extends BaseRepository implements CampaignEventDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CampaignEventDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
