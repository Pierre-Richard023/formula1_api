<?php

namespace App\DataFixtures;

use App\Entity\Drivers;
use App\Entity\Races;
use App\Entity\Sessions;
use App\Entity\StandingEntry;
use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SessionsFP1Fixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }


    public function load(ObjectManager $manager): void
    {
        ini_set('memory_limit', '512M');

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsFP1.json';
        $data = Items::fromFile($jsonFile);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        foreach ($data as $entry) {
            $session = new Sessions();
            $session->setName("free-practice-1")
                ->setRace($this->getReference('races__' . $entry->raceId, Races::class));
            $standings = new Standings();
            $session->setStanding($standings);
            $manager->persist($standings);
            $manager->persist($session);
            foreach ($entry->standing as $e) {
                $standingEntry = new StandingEntry();
                $standingEntry->setStandings($standings)
                    ->setDriver($this->getReference('driver__' . $e->driverId, Drivers::class));
                if (isset($e->positionNumber))
                    $standingEntry->setPosition($e->positionNumber);
                if (isset($e->time))
                    $standingEntry->setRaceTime($e->time);
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
            RacesFixtures::class,
        ];
    }
}
