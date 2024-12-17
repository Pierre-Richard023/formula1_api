<?php

namespace App\DataFixtures;

use App\Entity\Drivers;
use App\Entity\StandingEntry;
use App\Entity\Standings;
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
        ini_set('memory_limit', '1224M');

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsR.json';
        $data = Items::fromFile($jsonFile);
        foreach ($data as $k => $entries) {
            if ($k === 'races') {
                foreach ($entries as $e) {
                    $standing = $this->getReference("standings__r__" . $e->raceId,Standings::class);
                    $standingEntry = new StandingEntry();
                    $standingEntry->setStandings($standing)
                        ->setDriver($this->getReference('driver__' . $e->driverId,Drivers::class));
                    if (isset($e->positionNumber))
                        $standingEntry->setPosition($e->positionNumber);
                    if (isset($e->time))
                        $standingEntry->setRaceTime($e->time);
                    if (isset($e->points))
                        $standingEntry->setPoints($e->points);
                    else
                        $standingEntry->setPoints(0);

                    $manager->persist($standingEntry);
                }
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            SessionsRacesFixtures::class
        ];
    }
}
