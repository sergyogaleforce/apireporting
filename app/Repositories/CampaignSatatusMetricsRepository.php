<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CampaignSatatusMetricsRepository.
 *
 * @package namespace App\Repositories;
 */
interface CampaignSatatusMetricsRepository extends RepositoryInterface
{
   public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
