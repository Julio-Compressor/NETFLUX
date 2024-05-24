<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            for ($y = 1; $y <= 5; $y++) {
                for ($e = 1; $e <= 16; $e++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
                    $episode->setNumber($e);
                    $episode->setSynopsis($faker->text(maxNbChars: 450));
                    $episode->setSeason($this->getReference('program_'.$i.'_season_'.$y));
                    $manager->persist($episode);

                }
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
