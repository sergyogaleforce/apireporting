<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CampaignDailyActivityRepository.
 *
 * @package namespace App\Repositories;
 */
interface CampaignDailyActivityRepository extends RepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
