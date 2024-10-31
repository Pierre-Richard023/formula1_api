<?php

namespace App\DataFixtures;

use App\Entity\Drivers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DriversFixtures extends Fixture
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/drivers.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (isset($data)) {

            foreach ($data as $d) {

                $driver = new Drivers();

                $driver->setFirstName($d['firstName'])
                    ->setLastName($d['lastName'])
                    ->setFullName($d['name'])
                    ->setAbbreviation($d['abbreviation'])
                    ->setDateOfBirth(date_create_from_format('Y-n-d', $d['dateOfBirth']))
                    ->setPlaceOfBirth($d['placeOfBirth'])
                    ->setCountry($d['countryOfBirthCountryId'])
                    ->setNationality($d['nationalityCountryId'])
                    ->setPermanentNumber($d['permanentNumber'])
                    ->setGrandsPrixEntered($d['totalRaceEntries'])
                    ->setPolePositions($d['totalPolePositions'])
                    ->setPodiums($d['totalPodiums'])
                    ->setRaceWins($d['totalRaceWins'])
                    ->setWorldChampionships($d['totalChampionshipWins']);

                if ($d['dateOfDeath'] !== null)
                    $driver->setDateOfDeath(date_create_from_format('Y-n-d', $d['dateOfDeath']));

                $this->addReference('driver__' . $d['id'], $driver);
                $manager->persist($driver);
            }
        }

        $manager->flush();
    }
}
