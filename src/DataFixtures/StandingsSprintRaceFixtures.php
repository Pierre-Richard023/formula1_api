<?php

namespace App\DataFixtures;

use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingsSprintRaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsSR.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $k => $entries) {
            if ($k == 'sprint-race') {
                foreach ($entries as $entry) {
                    $session = $this->getReference("sessions__sr__" . $entry->raceId);
                    $standings = new Standings();
                    $this->addReference('standings__sr__' . $entry->raceId, $standings);
                    $session->setStanding($standings);
                    $manager->persist($standings);
                    $manager->persist($session);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SessionsSprintRaceFixtures::class
        ];
    }
}
