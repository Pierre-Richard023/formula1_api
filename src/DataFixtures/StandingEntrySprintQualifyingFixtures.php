<?php

namespace App\DataFixtures;

use App\Entity\StandingEntry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingEntrySprintQualifyingFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }


    public function load(ObjectManager $manager): void
    {
        $jsonFileSQ = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsSQ.json';
        $dataSQ = Items::fromFile($jsonFileSQ);
        foreach ($dataSQ as $k => $entries) {
            if ($k === 'sprint-qualifying') {
                foreach ($entries as $entry) {
                    $standing = $this->getReference("standings__sqfg__" . $entry->raceId);
                    foreach ($entry->standing as $e) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standing)
                            ->setDriver($this->getReference('driver__' . $e->driverId));
                        if (isset($e->positionNumber))
                            $standingEntry->setPosition($e->positionNumber);
                        if (isset($e->time))
                            $standingEntry->setRaceTime($e->time);
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
            StandingsSprintQualifyingFixtures::class
        ];
    }

}
