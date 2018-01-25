<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IdExcelClientsRepository;
use App\Entities\IdExcelClients;
use App\Validators\IdExcelClientsValidator;

/**
 * Class IdExcelClientsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IdExcelClientsRepositoryEloquent extends BaseRepository implements IdExcelClientsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IdExcelClients::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
