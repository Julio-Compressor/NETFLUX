<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create( 'fr_FR');
        for ($i = 1; $i <= 10; $i++) {
            $actor = new Actor();
            $actor -> setName($faker->name());
            for ($j = 1; $j <= 3; $j++) {
                $actor -> addProgram($this->getReference('program_' . $faker->numberBetween(1,15)));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
