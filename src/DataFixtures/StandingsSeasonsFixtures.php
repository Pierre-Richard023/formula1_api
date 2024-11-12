<?php

namespace App\DataFixtures;

use App\Entity\StandingEntry;
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
        ini_set('memory_limit', '1224M');
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsSeasons.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $k => $entries) {
            if ($k == 'drivers') {
                foreach ($entries as $entry) {
                    $season=$this->getReference('season__' . $entry->year);
                    $standings = new Standings();
                    $season->setDriverStandings($standings);
                    $manager->persist($standings);
                    $manager->persist($season);
                    foreach ($entry->standing as $s) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standings)
                            ->setDriver($this->getReference('driver__' . $s->driverId));
                        if (isset($s->positionNumber))
                            $standingEntry->setPosition($s->positionNumber);
                        if (isset($s->points))
                            $standingEntry->setPoints($s->points);
                        else
                            $standingEntry->setPoints(0);
                        $manager->persist($standingEntry);
                    }
                }
            }
            if ($k == 'constructors') {
                foreach ($entries as $entry) {
                    $season=$this->getReference('season__' . $entry->year);
                    $standings = new Standings();
                    $season->setConstructorStandings($standings);
                    $manager->persist($standings);
                    $manager->persist($season);
                    foreach ($entry->standing as $s) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standings)
                            ->setConstructor($this->getReference('constructor__' . $s->constructorId));
                        if (isset($s->positionNumber))
                            $standingEntry->setPosition($s->positionNumber);
                        if (isset($s->points))
                            $standingEntry->setPoints($s->points);
                        else
                            $standingEntry->setPoints(0);
                        $manager->persist($standingEntry);
                    }
                }
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
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
