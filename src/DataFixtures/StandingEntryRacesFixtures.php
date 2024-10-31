<?php

namespace App\DataFixtures;

use App\Entity\StandingEntry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingEntryRacesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        ini_set('memory_limit', '512M');

        $jsonFileFP4 = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsR.json';
        $dataFP4 = Items::fromFile($jsonFileFP4);
        foreach ($dataFP4 as $k => $entries) {
            if ($k === 'races') {
                foreach ($entries as $e) {
                    $standing = $this->getReference("standings__r__" . $e->raceId);
                    $standingEntry = new StandingEntry();
                    $standingEntry->setStandings($standing)
                        ->setDriver($this->getReference('driver__' . $e->driverId));
                    if (isset($e->positionNumber))
                        $standingEntry->setPosition($e->positionNumber);
                    if (isset($e->time))
                        $standingEntry->setRaceTime($e->time);
                    if (isset($e->points))
                        $standingEntry->setPoints($e->points);

                    $manager->persist($standingEntry);

                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StandingsRacesFixtures::class
        ];
    }
}
