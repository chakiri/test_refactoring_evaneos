<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Traits\Instantiation;

class DestinationRepository implements RepositoryInterface
{
    use Instantiation;
    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD

        $faker = \Faker\Factory::create();
        $faker->seed($id);

        return new Destination(
            $id,
            $faker->country,
            'en',
            $faker->slug()
        );
    }
}
