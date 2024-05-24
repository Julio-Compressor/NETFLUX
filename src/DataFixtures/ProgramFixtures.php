<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 15; $i++) {
            $program = new Program();
            $program->setTitle($faker->words(3, true));
            $program->setSynopsis($faker->paragraph(2, true));
            $program->setCategory($this->getReference('category_' . $faker->numberBetween(1, 7)));
            $this->addReference('program_' . $i, $program );
            $manager->persist($program);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
