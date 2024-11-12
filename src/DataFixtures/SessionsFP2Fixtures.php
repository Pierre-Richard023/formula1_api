<?php

namespace App\DataFixtures;

use App\Entity\Sessions;
use App\Entity\StandingEntry;
use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SessionsFP2Fixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        ini_set('memory_limit', '512M');

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsFP2.json';
        $data = Items::fromFile($jsonFile);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        foreach ($data as $k => $entries) {
            if ($k === 'free-practice-2') {
                foreach ($entries as $entry) {
                    $session = new Sessions();
                    $session->setName("free-practice-2")
                        ->setRace($this->getReference('races__' . $entry->raceId));

                    $standings = new Standings();
                    $session->setStanding($standings);
                    $manager->persist($standings);
                    $manager->persist($session);

                    foreach ($entry->standing as $e) {
                        $standingEntry = new StandingEntry();
                        $standingEntry->setStandings($standings)
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
        $manager->clear();
        unset($data);

    }

    public function getDependencies()
    {
        return [
            RacesFixtures::class,
        ];
    }
}
