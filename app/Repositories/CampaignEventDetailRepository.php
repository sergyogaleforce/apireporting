<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CampaignEventDetailRepository.
 *
 * @package namespace App\Repositories;
 */
interface CampaignEventDetailRepository extends RepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);
}
