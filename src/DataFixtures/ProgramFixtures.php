<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => 'Walking Dead',
            'synopsis' => 'Des zombies envahissent la terre.',
            'category' => 'category_Action',
        ],
        [
            'title' => 'Peaky Blinders',
            'synopsis' => 'Des histoires de gitan',
            'category' => 'category_Action',
        ],
        [
            'title' => 'Breaking bad',
            'synopsis' => 'Encore un qui essaye de faire de la meth',
            'category' => 'category_Action',
        ],
        [
            'title' => 'Dark',
            'synopsis' => "Apres la disparition d'un garçon, la peur nait dans la ville",
            'category' => 'category_Science Fiction',
        ],
        [
            'title' => 'Vikings',
            'synopsis' => "Des gros gars virils qui se tape sur la gueule",
            'category' => 'category_Aventure',
        ],
        [
            'title' => 'Blue eye samourai',
            'synopsis' => "Ca casse des gueules au sabre",
            'category' => 'category_Animation',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (Self::PROGRAMS as $key => $programs) {
            $program = new Program();
            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCategory($this->getReference($programs['category']));
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
