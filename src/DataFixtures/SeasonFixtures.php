<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 15; $i++) {
            for ($y = 1; $y <= 5 ; $y++) {
                $season = new Season();
                $season -> setNumber($y);
                $season -> setYear($faker->year("+$i years"));
                $season -> setProgram($this->getReference('program_'.$i ));
                $this->addReference( 'program_'.$i.'_season_'.$y, $season);
                $manager->persist($season);
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}
