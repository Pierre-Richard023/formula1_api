<?php

namespace App\DataFixtures;

use App\Entity\Circuits;
use App\Entity\Races;
use App\Entity\Seasons;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RacesFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/races.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        if (isset($data)) {
            foreach ($data as $r) {
                $races = new Races();
                $races->setName($r['grandPrixId'])
                    ->setOfficialName($r['officialName'])
                    ->setRaceDate(date_create_from_format('Y-n-d', $r['date']))
                    ->setQualifyingFormat($r['qualifyingFormat'])
                    ->setLaps($r['laps'])
                    ->setDistance($r['distance'])
                    ->setSeason($this->getReference('season__' . $r['year'],Seasons::class))
                    ->setCircuit($this->getReference('circuit__' . $r['circuitId'],Circuits::class));

                $this->addReference('races__' . $r['id'], $races);
                $manager->persist($races);
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            SeasonsFixtures::class
        ];
    }
}
