<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CampaignSummaryActivityRepository.
 *
 * @package namespace App\Repositories;
 */
interface CampaignSummaryActivityRepository extends RepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
