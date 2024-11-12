<?php

namespace App\DataFixtures;

use App\Entity\Constructors;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConstructorsFixtures extends Fixture
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }


    public function load(ObjectManager $manager): void
    {

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/constructors.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        if (isset($data)) {
            foreach ($data as $c) {
                $constructor = new Constructors();
                $constructor->setName($c['name'])
                    ->setFullName($c['fullName'])
                    ->setCountry($c['countryId'])
                    ->setRaceEntries($c['totalRaceEntries'])
                    ->setPodiums($c['totalPodiumRaces'])
                    ->setRaceWins($c['totalRaceWins'])
                    ->setWolrdChampionships($c['totalChampionshipWins']);

                $this->addReference('constructor__'.$c["id"], $constructor);
                $manager->persist($constructor);
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }
}
