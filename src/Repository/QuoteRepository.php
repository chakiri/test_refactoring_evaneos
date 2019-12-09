<?php

namespace App\Repository;

use App\Entity\Quote;

class QuoteRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id)
    {
        $faker = \Faker\Factory::create();
        $faker->seed($id);

        return new Quote(
            $id,
            $faker->numberBetween(1, 10),
            $faker->numberBetween(1, 200),
            $faker->date()
        );
    }
}
