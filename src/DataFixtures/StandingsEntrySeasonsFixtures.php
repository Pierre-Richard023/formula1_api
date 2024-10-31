<?php

namespace App\DataFixtures;

use App\Entity\StandingEntry;
use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingsEntrySeasonsFixtures extends Fixture implements DependentFixtureInterface
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
                    $standing = $this->getReference('standings__seasons__drivers__' . $entry->year);
                    foreach ($entry->standing as $s) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standing)
                            ->setDriver($this->getReference('driver__' . $s->driverId));
                        if (isset($e->positionNumber))
                            $standingEntry->setPosition($e->positionNumber);
                        if (isset($e->points))
                            $standingEntry->setPoints($e->points);
                        else
                            $standingEntry->setPoints(0);

                        $manager->persist($standingEntry);
                    }
                }
            }
            if ($k == 'constructors') {
                foreach ($entries as $entry) {
                    $standing = $this->getReference('standings__seasons__constructors__' . $entry->year);
                    foreach ($entry->standing as $s) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standing)
                            ->setConstructor($this->getReference('constructor__' . $s->constructorId));
                        if (isset($e->positionNumber))
                            $standingEntry->setPosition($e->positionNumber);
                        if (isset($e->points))
                            $standingEntry->setPoints($e->points);
                        else
                            $standingEntry->setPoints(0);

                        $manager->persist($standingEntry);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StandingsSeasonsFixtures::class
        ];
    }
}
