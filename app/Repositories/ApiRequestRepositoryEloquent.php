<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ApiRequestRepository;
use App\Entities\ApiRequest;
//use App\Validators\ApiRequestValidator;

/**
 * Class ApiRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ApiRequestRepositoryEloquent extends BaseRepository implements ApiRequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApiRequest::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
