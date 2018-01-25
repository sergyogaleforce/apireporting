<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ApiRequestRepository.
 *
 * @package namespace App\Repositories;
 */
interface ApiRequestRepository extends RepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
