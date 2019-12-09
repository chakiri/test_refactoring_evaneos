<?php

namespace App\Service;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Entity\User;

class RandomContext
{
    /**
     * @var Site
     */
    private $currentSite;
    /**
     * @var User
     */
    private $currentUser;

    /**
     * @var Quote
     */
    private $currentQuote;

    /**
     * @var Destination
     */
    private $currentDestination;

    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $this->currentQuote = new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date());
        $this->currentUser = new User($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
        $this->currentDestination = new Destination($faker->randomNumber(), $faker->country, $faker->country, $faker->name);
        $this->currentSite = new Site($faker->randomNumber(), $faker->url);
    }

    /**
     * @return Site
     */
    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @return Quote
     */
    public function getCurrentQuote()
    {
        return $this->currentQuote;
    }

    /**
     * @return mixed
     */
    public function getCurrentDestination()
    {
        return $this->currentDestination;
    }
}
