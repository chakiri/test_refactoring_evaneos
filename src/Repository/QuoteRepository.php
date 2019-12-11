<?php

namespace App\Repository;

use App\Entity\Quote;
use App\Traits\Instantiation;

class QuoteRepository implements RepositoryInterface
{
    use Instantiation;
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
