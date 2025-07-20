<?php

namespace App\DataFixtures;

use App\Entity\Constructors;
use App\Entity\Drivers;
use App\Entity\Entrants;
use App\Entity\EntrantsDrivers;
use App\Entity\Races;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EntrantsDriversFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        ini_set('memory_limit', '512M');

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/EntrantsDrivers.json';
        $data = Items::fromFile($jsonFile);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        foreach ($data as $entry) {
            $entrantsDrivers = new EntrantsDrivers();
            $entrantsDrivers
                ->setDrivers($this->getReference('driver__' . $entry->driverId, Drivers::class));

            foreach ($entry->entrants as $d) {


                $entrants = new Entrants();
                $entrants->setSeason($d->year)
                    ->setTestDriver($d->testDriver)
                    ->setConstructors($this->getReference('constructor__' . $d->constructorId, Constructors::class));

                $races = [];
                foreach ($d->rounds as $r) {
                    $racesId ='f1s'.$d->year.'_r'.$r;
                    $races[] = $racesId;
                }

                $entrants->setRaces($races);

                $manager->persist($entrants);
                $entrantsDrivers->addEntrant($entrants);
            }
            $manager->persist($entrantsDrivers);

        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            DriversFixtures::class,
            ConstructorsFixtures::class,
        ];
    }
}
