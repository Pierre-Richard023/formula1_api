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

        foreach ($data as $e) {
            $standing = $this->getReference("standings__r__" . $e->raceId, Standings::class);

            foreach ($e->standing as $st) {
                $standingEntry = new StandingEntry();
                $standingEntry->setStandings($standing)
                    ->setDriver($this->getReference('driver__' . $st->driverId, Drivers::class));
                if (isset($st->positionNumber))
                    $standingEntry->setPosition($st->positionNumber);
                if (isset($st->time))
                    $standingEntry->setRaceTime($st->time);
                if (isset($st->points))
                    $standingEntry->setPoints($st->points);
                else
                    $standingEntry->setPoints(0);

                $manager->persist($standingEntry);
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
