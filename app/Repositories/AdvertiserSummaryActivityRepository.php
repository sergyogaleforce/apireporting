<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AdvertiserSummaryActivityRepository.
 *
 * @package namespace App\Repositories;
 */
interface AdvertiserSummaryActivityRepository extends RepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
