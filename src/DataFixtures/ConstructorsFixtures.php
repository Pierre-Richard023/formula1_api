<?php

namespace App\DataFixtures;

use App\Entity\Constructors;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConstructorsFixtures extends Fixture implements DependentFixtureInterface
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
                $constructor->setConstructorId($c['id'])
                    ->setName($c['name'])
                    ->setFullName($c['fullName'])
                    ->setCountry($this->getReference('country__'. $c["countryId"],Country::class))
                    ->setRaceEntries($c['totalRaceEntries'])
                    ->setPodiums($c['totalPodiumRaces'])
                    ->setRaceWins($c['totalRaceWins'])
                    ->setWolrdChampionships($c['totalChampionshipWins']);

                $this->addReference('constructor__' . $c["id"], $constructor);
                $manager->persist($constructor);
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }
}
