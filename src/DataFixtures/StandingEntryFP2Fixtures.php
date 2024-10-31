<?php

namespace App\DataFixtures;

use App\Entity\StandingEntry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingEntryFP2Fixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }


    public function load(ObjectManager $manager): void
    {
        $jsonFileFP2 = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsFP2.json';
        $dataFP2 = Items::fromFile($jsonFileFP2);
        foreach ($dataFP2 as $k => $entries) {
            if ($k === 'free-practice-2') {
                foreach ($entries as $entry) {
                    $standing = $this->getReference("standings__fp2__" . $entry->raceId);
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
            StandingsFP2Fixtures::class
        ];
    }
}
