<?php

namespace App\DataFixtures;

use App\Entity\MemoryGameHistory;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MemoryGameHistoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $randomScore = $faker->numberBetween(26, 52);
            
            $history = new MemoryGameHistory();
            $history->setScore($randomScore % 2 == 0 ? $randomScore : $randomScore + 1);
            $history->setPseudo($faker->name());
            $history->setWidth(4);
            $history->setHeight(4);
            
            $manager->persist($history);
        }

        $manager->flush();
    }
}
