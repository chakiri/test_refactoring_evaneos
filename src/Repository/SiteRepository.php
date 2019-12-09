<?php

namespace App\Repository;

use App\Entity\Site;

class SiteRepository implements RepositoryInterface
{
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
