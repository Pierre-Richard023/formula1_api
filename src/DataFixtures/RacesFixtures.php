<?php

namespace App\DataFixtures;

use App\Entity\Circuits;
use App\Entity\Races;
use App\Entity\Seasons;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RacesFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/races.json';
        $data = Items::fromFile($jsonFile);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        foreach ($data as $dt) {

            $nbR = 1;
            foreach ($dt->races as $r) {
                $season = $this->getReference('season__' . $r->year, Seasons::class);
                $races = new Races();
                $races->setName($r->grandPrixId)
                    ->setRacesId($season->getSeasonsId() . '_r' . $nbR)
                    ->setOfficialName($r->officialName)
                    ->setRaceDate(date_create_from_format('Y-n-d', $r->date))
                    ->setQualifyingFormat($r->qualifyingFormat)
                    ->setLaps($r->laps)
                    ->setDistance($r->distance)
                    ->setSeason($season, Seasons::class)
                    ->setCircuit($this->getReference('circuit__' . $r->circuitId, Circuits::class));

                $this->addReference('races__' . $r->id, $races);
                $manager->persist($races);
                $nbR++;
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
