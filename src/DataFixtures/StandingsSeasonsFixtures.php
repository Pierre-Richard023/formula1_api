<?php

namespace App\DataFixtures;

use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingsSeasonsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsSeasons.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $k => $entries) {
            if ($k == 'drivers') {
                foreach ($entries as $entry) {
                    $standings = new Standings();
                    $standings->setSeason($this->getReference('season__' . $entry->year));
                    $this->addReference('standings__seasons__drivers__' . $entry->year, $standings);
                    $manager->persist($standings);
                }
            }
            if ($k == 'constructors') {
                foreach ($entries as $entry) {
                    $standings = new Standings();
                    $standings->setSeason($this->getReference('season__' . $entry->year));
                    $this->addReference('standings__seasons__constructors__' . $entry->year, $standings);
                    $manager->persist($standings);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonsFixtures::class,
            DriversFixtures::class,
            ConstructorsFixtures::class,
        ];
    }
}
