<?php

namespace App\DataFixtures;

use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StandingsRacesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/races.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $entries) {
            $session = $this->getReference("sessions__r__" . $entries->id);
            $standings = new Standings();
            $this->addReference('standings__r__' . $entries->id, $standings);
            $session->setStanding($standings);
            $manager->persist($standings);
            $manager->persist($session);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SessionsRacesFixtures::class
        ];
    }
}
