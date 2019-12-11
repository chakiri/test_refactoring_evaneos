<?php

namespace App\Service;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Entity\User;
use App\Traits\Instantiation;

class RandomContext
{
    use Instantiation;

    private static $faker;

    public function __construct()
    {
        self::$faker = \Faker\Factory::create();
    }

    public static function getSite(){
        return new Site(self::$faker->randomNumber(), self::$faker->url);
    }

    public static function getUser(){
        return new User(self::$faker->randomNumber(), self::$faker->firstName, self::$faker->lastName, self::$faker->email);
    }

    public static function getQuote(){
        return new Quote(self::$faker->randomNumber(), self::$faker->randomNumber(), self::$faker->randomNumber(), self::$faker->date());
    }

    public static function getDestination(){
        return new Destination(self::$faker->randomNumber(), self::$faker->country, self::$faker->country, self::$faker->name);
    }

}
