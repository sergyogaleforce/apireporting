<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InfoLoginToReachLocalRepository;
use App\Entities\InfoLoginToReachLocal;
use App\Validators\InfoLoginToReachLocalValidator;

/**
 * Class InfoLoginToReachLocalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InfoLoginToReachLocalRepositoryEloquent extends BaseRepository implements InfoLoginToReachLocalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InfoLoginToReachLocal::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
