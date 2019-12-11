<?php

namespace App\Repository;

use App\Entity\Site;
use App\Traits\Instantiation;

class SiteRepository implements RepositoryInterface
{
    use Instantiation;
    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        $faker = \Faker\Factory::create();
        $faker->seed($id);
        return new Site($id, $faker->url);
    }
}
